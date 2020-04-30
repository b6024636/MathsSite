<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions\Questions;
use App\Models\Tasks\Tasks;
use App\Models\Tasks\TaskCompleted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use App\Models\Users\Students;
use App\Models\Groups\Groups;
use App\Models\Topics\Topics;

class TaskController extends Controller
{
    private $question;

    private $tasks;
    /**
     * @var TaskCompleted
     */
    private $taskCompleted;
    /**
     * @var Students
     */
    private $students;
    /**
     * @var Groups
     */
    private $groups;
    /**
     * @var Topics
     */
    private $topics;

    /**
     * TaskController constructor.
     * @param Questions $question
     * @param Tasks $tasks
     * @param TaskCompleted $taskCompleted
     * @param Students $students
     * @param Groups $groups
     * @param Topics $topics
     */
    public function __construct(
        Questions $question,
        Tasks $tasks,
        TaskCompleted $taskCompleted,
        Students $students,
        Groups $groups,
        Topics $topics
    )
    {
        $this->question = $question;
        $this->tasks = $tasks;
        $this->taskCompleted = $taskCompleted;
        $this->students = $students;
        $this->groups = $groups;
        $this->topics = $topics;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tasks = '';
        $chosenTopic = '';
        $title = '';
        if(isset($request->topic))
        {
            $tasks = $this->tasks::where('topic', '=', $request->topic)->get();
            $chosenTopic = $this->topics::where('id', '=', $request->topic)->get();
            foreach ($chosenTopic as $_topic)
                $title = $_topic->title;
        }


        $topics = $this->topics::orderBy('title', 'asc')->get();

        return view('tasks/viewtasks', ['topics' => $topics, 'tasks' => $tasks, 'topicId' => $request->topic, 'chosenTopic' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tasks/createtask', $this->manageTaskDetails());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');

        $user = Auth::guard('teacher')->user();
        $data = $this->tasks::create([
            'title' => $request->get('title'),
            'rating' => 0,
            'marks' => $this->getFullMarksForTask(explode(',', $request->get('questions'))),
            'questions' => $request->get('questions'),
            'is_private' => $request->get('is-private') == 'on' ? true : false,
            'school' => $user->assigned_school,
            'created_by' => $user->username,
            'topic' => $request->get('topic'),
        ]);

        return redirect('/myschool');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $array = $this->manageTaskDetails();

        $array['chosenTask'] = $this->tasks::findOrFail($id);

        return view('tasks/edittask', $array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = $this->tasks::findOrFail($id);

        $task->title = $request->get('title');
        $task->marks = $this->getFullMarksForTask(explode(',', $request->get('questions')));
        $task->questions = $request->get('questions');
        $task->is_private = $request->get('is-private') == 'on' ? true : false;
        $task->topic = $request->get('topic');
        $task->save();

        return redirect('/myschool/task/manage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');

        $this->taskCompleted::where('task_id', '=', $id)->delete();

        $groups = $this->groups::all();

        foreach($groups as $group)
        {
            $assigned_tasks = explode(',', $group->assigned_tasks);
            if (($key = array_search($id, $assigned_tasks)) !== false) {
                unset($assigned_tasks[$key]);
            }
            $group->assigned_tasks = implode(',', $assigned_tasks);
            $group->save();
        }

        $task = $this->tasks::findOrFail($id);
        $task->delete();
        return redirect('/myschool/task/manage');
    }
    public function beginTask($id)
    {
        if($id)
            return view('tasks/task', ['questions' => $this->getQuestionsForTask($id), 'taskId' => $id, 'task' => $this->getTaskName($id)]);
        return redirect("/");
    }
    public function getQuestionsForTask($id)
    {
        $task = $this->tasks::find($id);

        return $task->questions;
    }

    public function getAllQuestions()
    {
        return $this->question::all();
    }

    /**
     * Get total marks of all the questions.
     *
     * @param  array  $questionIds
     * @return integer
     */
    private function getFullMarksForTask($questionIds)
    {
        $marks = 0;
        foreach($questionIds as $id)
        {
            $question = $this->question::find($id);
            $marks += $question->Marks;
        }
        return $marks;
    }
    public function getTaskName($id)
    {
        return $this->tasks::find($id)->title;
    }

    public function finishTask(Request $request)
    {
        $user = 'regular';
        $_request = json_decode($request->scores);
        $count = 1;
        $total = 0;
        $marksPerQuestion = [];
        $taskId = 0;
        foreach($_request as $_response)
        {
            $response = get_object_vars($_response);
            if(isset($response['taskId']))
            {
                $taskId = $response['taskId'];
                continue;
            }

            $marksPerQuestion[] = implode('..', [
                'questionNumber' => $count,
                'marks' => $response['marks']
            ]);
            $total += $response['marks'];
            $count++;
        }

        if(Auth::guard('student')->check())
        {
            $this->taskCompleted::create([
                'student_id' => Auth::guard('student')->user()->student_id,
                'task_id' => $taskId,
                'marks_per_question' => implode(',', $marksPerQuestion),
                'total_marks_earned' => $total
            ]);
            $user = 'student';
        }


        $marksAvailable = $this->tasks::find($taskId)->marks;

        $response = [
            'total' => $total,
            'marksAvailable' => $marksAvailable,
            'percent' => number_format(($total/$marksAvailable) * 100, 0),
            'user' => $user,
        ];
        return json_encode($response);
    }

    public function getCompletedTasksByUser(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');
        $teacher = Auth::guard('teacher')->user();
        $student = $this->students::find($request->student_id);
        $group = $this->groups::find($request->group_id);
        if($teacher->assigned_school != $student->assigned_school)
            return redirect('/');

        $taskData = [];

        foreach (explode(',', $group->assigned_tasks) as $taskId)
        {
            $taskData['assigned_tasks'][$taskId]['assigned'] = $this->tasks::find($taskId);
        }

        $completedTasks = $this->taskCompleted->where([
            ['student_id', '=', $student->student_id]
        ])->get();

        foreach ($completedTasks as $task)
        {
            if(array_key_exists($task->task_id, $taskData['assigned_tasks']))
            {
                $_task = $this->taskCompleted::orderBy('created_at', 'desc')->where([
                    ['student_id', '=', $student->student_id],
                    ['task_id', '=', $task->task_id]
                ])->first();

                $attempts = DB::table('taskcompleted')->where([['student_id', $student->student_id], ['task_id', $task->task_id]])->count();
                $taskData['assigned_tasks'][$task->task_id]['completed'] = $_task;
                $taskData['assigned_tasks'][$task->task_id]['completed']['attempts'] = $attempts;

            }
        }
        $taskData['code']['code'] = $group->code;
        $taskData['student'] = $student;

        return view('schools/viewcompletedtasks', ['data' => $taskData]);
    }

    public function getCompletedTasksByGroup(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');
        $teacher = Auth::guard('teacher')->user();
        $group = $this->groups::find($request->group_id);
        $task = $this->tasks::find($request->task_id);
        if($teacher->assigned_school != $group->assigned_school)
            return redirect('/');

        $taskData = [];

        $studentListFetch = $this->students::select('student_id')->where('assigned_groups', 'LIKE', '%,' . $group->id . ',%')->get();
        $studentList = [];
        foreach ($studentListFetch as $studentId)
            $studentList[] = $studentId->student_id;

        foreach($studentList as $studentId) {
            $studentsCompletedTasks = $this->taskCompleted::orderBy('created_at', 'desc')->where([
                ['task_id', '=', $task->id],
                ['student_id', '=', $studentId]
            ])->first();
            if(!is_null($studentsCompletedTasks))
            {
                $attempts = DB::table('taskcompleted')->where([['student_id', $studentId], ['task_id', $task->id]])->count();
                $taskData['studentTask'][] = [
                    'studentId' => $studentId,
                    'completedTask' => $studentsCompletedTasks,
                    'completed' => true,
                    'attempts' => $attempts
                ];
            }else{
                $taskData['studentTask'][] = [
                    'studentId' => $studentId,
                    'completed' => false
                ];
            }
        }
        $taskData['details'] = [
            'task' => $task,
            'group' => $group
        ];

        if(!isset($taskData['studentTask']))
            $taskData['studentTask'] = '';
//        print_r($taskData);
//        die();

        return view('schools/viewcompletedgrouptasks', ['data' => $taskData]);
    }

    /**
     * @return mixed
     */
    public function manageTasks()
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');
        $teacher = Auth::guard('teacher')->user();
        $tasks = $this->tasks::all();

        return view('tasks/managetasks', ['tasks' => $tasks]);
    }
    public function manageTaskDetails()
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');

        $user = Auth::guard('teacher')->user();
        $topics = $this->topics::orderBy('title', 'asc')->get();

        $questionArray = [];
        foreach ($topics as $topic)
        {
            $questionArray[$topic->id] = [
                'id' => $topic->id,
                'title' => $topic->title,
                'questions' => []
            ];
        }

        foreach ($this->getAllQuestions() as $question)
        {
            $questionArray[$question->topic]['questions'][] = [
                'id' => $question->id,
                'question' => $question->Question,
                'description' =>$question->Description
            ];
        }

        return [
            'questions' => $this->getAllQuestions(),
            'allQuestions' => $questionArray,
            'topics' => $topics = $this->topics::orderBy('title', 'asc')->get()
        ];


    }
}

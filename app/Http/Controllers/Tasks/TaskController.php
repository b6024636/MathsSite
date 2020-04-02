<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions\Questions;
use App\Models\Tasks\Tasks;
use App\Models\Tasks\TaskCompleted;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class TaskController extends Controller
{
    private $question;

    private $tasks;
    /**
     * @var TaskCompleted
     */
    private $taskCompleted;

    /**
     * TaskController constructor.
     * @param Questions $question
     * @param Tasks $tasks
     * @param TaskCompleted $taskCompleted
     */
    public function __construct(Questions $question, Tasks $tasks, TaskCompleted $taskCompleted )
    {
        $this->question = $question;
        $this->tasks = $tasks;
        $this->taskCompleted = $taskCompleted;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tasks = $this->tasks::all();

        return view('tasks/viewtasks', ['allTasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tasks/createtask', ['questions' => $this->getAllQuestions()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $data = $this->tasks::create([
            'title' => $request->get('title'),
            'rating' => 0,
            'marks' => $this->getFullMarksForTask($request->get('questions')),
            'questions' => implode(',', $request->get('questions')),
            'is_private' => $request->get('is-private') == 'on' ? true : false,
            'school' => $request->get('school'),
            'created_by' => 'Test',
            'topic' => $request->get('topic'),
        ]);

        return $this->index();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
//        print_r($marksPerQuestion);
//        die();

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


        return $this->respond("no");
        if($json)
            return json_encode("test");
        return false;
        return json_encode($scores);
    }

}

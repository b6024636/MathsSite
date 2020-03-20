<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions\Questions;
use App\Models\Tasks\Tasks;

class TaskController extends Controller
{
    private $question;

    private $tasks;

    public function __construct( Questions $question, Tasks $tasks )
    {
        $this->question = $question;
        $this->tasks = $tasks;
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
//        echo '<pre>';
//        print_r($request->all());
//        die();

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
        return "no";
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

    public function finishTask()
    {
        die("hi");
        return $this->respond("no");
        if($json)
            return json_encode("test");
        return false;
        return json_encode($scores);
    }

}

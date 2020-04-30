<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topics\Topics;

class QuestionController extends Controller
{
    /**
     * @var Topics
     */
    private $topics;

    /**
     * QuestionController constructor.
     * @param Topics $topics
     */
    public function __construct(Topics $topics)
    {
        $this->topics = $topics;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');
        return view('questions/createquestion', ['topics' => $topics = $this->topics::orderBy('title', 'asc')->get()]);
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

        $data = \App\Models\Questions\Questions::create([
            'Type' => $request->get('question-type'),
            'Question' => $request->get('question'),
            'Description' => $request->get('description'),
            'Marks' => $request->get('marks'),
            'Image' => $request->get('image'),
            'Answer' => $request->get('answer'),
            'Optional_Answers' => $request->get('optional-answers'),
            'Is_Private' => $request->get('is-private') == 'on' ? true : false,
            'School' => $user->assigned_school,
            'CreatedBy' => $user->username,
            'topic' => $request->get('topic'),
        ]);
        return redirect('/myschool');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return false|string
     */
    public function show($id, $json = null)
    {
        $question = \App\Models\Questions\Questions::find($id);
        $questionArr = [
            'id' => $id,
            'question_type' => $question->Type,
            'question' => $question->Question,
            'description' => $question->Description,
            'marks' => $question->Marks,
            'image' => $question->Image,
            'answer' => $question->Answer,
            'optional_answers' => $question->Optional_Answers,
            'is_private' => $question->Is_Private,
            'school' => $question->School,
            'created_by' => $question->CreatedBy,
            'topic' => $question->topic,
        ];


        if(!is_null($json))
            return json_encode($this->show($id));

        return $questionArr;
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

    public function getQuestionJson($id)
    {
        return json_encode($this->show($id));
    }
}

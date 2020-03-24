<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Groups\Groups;
use App\Models\Users\Teachers;
use App\Models\Users\Students;
use App\Models\Tasks\Tasks;

class GroupController extends Controller
{
    /**
     * @var Groups
     */
    protected $group;
    /**
     * @var Teachers
     */
    private $teachers;
    /**
     * @var Students
     */
    private $students;
    /**
     * @var Tasks
     */
    private $tasks;

    /**
     * GroupController constructor.
     * @param Groups $group
     * @param Teachers $teachers
     * @param Students $students
     * @param Tasks $tasks
     */
    public function __construct(Groups $group, Teachers $teachers, Students $students, Tasks $tasks)
    {
        $this->group = $group;
        $this->teachers = $teachers;
        $this->students = $students;
        $this->tasks = $tasks;
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');

        $school = Auth::guard('teacher')->user()->assigned_school;
        $this->group::create([
           'code' => $request->code,
           'assigned_school' =>  $school
        ]);

        return redirect('/myschool');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($id)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');

        $group = $this->group::find($id);
        if($group->assigned_school != Auth::guard('teacher')->user()->assigned_school)
            return redirect('/');
        $students = $this->students::where('assigned_groups', '=', $id)->get();
        $teachers = $this->teachers::where('assigned_groups', '=', $id)->get();
        $tasks = [];
        if($group->assigned_tasks){
            foreach(explode(',', $group->assigned_tasks) as $taskId)
            {
                $tasks[] = $this->tasks::find($taskId);
            }
        }

        return view('schools/viewgroup', ['group' => $group,'students' => $students,'teachers' => $teachers,'tasks' => $tasks,]);
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
}

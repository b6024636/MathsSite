<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Groups\Groups;
use App\Models\Users\Teachers;
use App\Models\Users\Students;
use App\Models\Tasks\Tasks;
use Illuminate\Support\Facades\DB;

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
        $students = $this->students::where([
            ['assigned_groups', 'LIKE', '%,' . $id . ',%'],
            ['assigned_school', '=', Auth::guard('teacher')->user()->assigned_school]
        ])->get();
        $teachers = $this->teachers::where([
            ['assigned_groups', 'LIKE', '%,' . $id . ',%'],
            ['assigned_school', '=', Auth::guard('teacher')->user()->assigned_school]
        ])->get();
        $schoolStudents = $this->students::where([
            ['assigned_school', '=', Auth::guard('teacher')->user()->assigned_school],
            ['assigned_groups', 'NOT LIKE', '%,' . $id . ',%']
        ])->get();
        $schoolTeachers = $this->teachers::where([
            ['assigned_school', '=', Auth::guard('teacher')->user()->assigned_school],
            ['assigned_groups', 'NOT LIKE', '%,' . $id . ',%']
        ])->get();
        $tasks = [];
        if($group->assigned_tasks){
            foreach(explode(',', $group->assigned_tasks) as $taskId)
            {
                $tasks[] = $this->tasks::find($taskId);
            }
        }

        return view('schools/viewgroup', [
            'group' => $group,
            'students' => $students,
            'teachers' => $teachers,
            'tasks' => $tasks,
            'schoolStudents' => $schoolStudents,
            'schoolTeachers' => $schoolTeachers]);
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

    public function addUserToGroup(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');
        if($request->user == 'student')
        {
            foreach($request->students as $studentId)
            {
                $student = $this->students::find($studentId);
                if(!in_array($request->group_id, explode(',', $student->assigned_groups)))
                    $student->update(['assigned_groups' => $student->assigned_groups . $request->group_id . ',']);

            }
        }
        else{
            foreach($request->teachers as $teacherId)
            {
                $teacher = $this->teachers::find($teacherId);
                if(!in_array($request->group_id, explode(',', $teacher->assigned_groups)))
                    $teacher->update(['assigned_groups' => $teacher->assigned_groups . $request->group_id . ',']);

            }
        }
        return redirect('groups/group/'.$request->group_id);
    }


    public function removeUserFromGroup(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            return redirect('/');
        if($request->user == 'student')
        {
            $student = $this->students::find($request->student_id);
            if(in_array($request->group_id, $groups = explode(',', $student->assigned_groups)))
            {
                $key = array_search($request->group_id, $groups);
                unset($groups[$key]);
                $student->update(['assigned_groups' => ',' . implode(',', $groups)]);
            }
        }
        else{
            $teacher = $this->teachers::find($request->teacher_id);
            if(in_array($request->group_id, $groups = explode(',', $teacher->assigned_groups)))
            {
                $key = array_search($request->group_id, $groups);
                unset($groups[$key]);
                $teacher->update(['assigned_groups' => ',' . implode(',', $groups)]);
            }
        }
        return redirect('groups/group/'.$request->group_id);
    }

}

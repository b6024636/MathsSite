<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\School\SchoolAddressController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;
use App\Models\Schools\School;
use App\Models\Groups\Groups;
use App\Models\Tasks\Tasks;
use App\Models\Users\Teachers;
use App\Models\Users\Students;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    protected $authManager;

    protected $school;

    protected $groups;
    /**
     * @var Tasks
     */
    private $tasks;
    /**
     * @var Teachers
     */
    private $teachers;
    /**
     * @var Students
     */
    private $students;

    /**
     * SchoolController constructor.
     * @param AuthManager $authManager
     * @param School $school
     * @param Groups $groups
     * @param Tasks $tasks
     * @param Teachers $teachers
     * @param Students $students
     */
    public function __construct(AuthManager $authManager, School $school, Groups $groups, Tasks $tasks, Teachers $teachers, Students $students)
    {
        $this->authManager = $authManager;
        $this->school = $school;
        $this->groups = $groups;
        $this->tasks = $tasks;
        $this->teachers = $teachers;
        $this->students = $students;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $schools = \App\Models\Schools\School::all();

        return view('schools/viewschools', ['allSchools' => $schools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('schools/createschool');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
//        echo '<pre>';
//        print_r($request->all());;
//        print_r($request->allFiles());
//        print_r(get_class_methods($request));
//        die();
//        $this->validate($request, [
//            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//        ]);

        /*if($request->hasFile('logo')){
            die('true');
            $image = $request->file('logo');
            $imageName = $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/' . $this->getImagePath($imageName));
            $image->move($destinationPath, $imageName);
           // $this->save();
        }
        die('false');*/

        /*if($request->logo){
            $image = $request->file('logo');
            $imageName = $request->logo->getClientOriginalExtension();
            $destinationPath = public_path('/images/' . $this->getImagePath($imageName));
            $image->move($destinationPath, $imageName);
            // $this->save();
        }*/
        $address = \App\Models\Schools\SchoolAddress::create([
            'address1' => $request->get('address1'),
            'address2' =>  $request->get('address2'),
            'postcode' =>  $request->get('postcode'),
            'county' =>  $request->get('county'),
            'country' =>  $request->get('country'),
        ]);

        $imageName = $request->get('logo');

        \App\Models\Schools\School::create([
            'Name' => $request->get('name'),
            'Contact_Number' => $request->get('contact'),
            'Address_id' => $address->id,
            'Email' => $request->get('email'),
            'Logo' => isset($imageName) ? $this->getImagePath($imageName) . '/' . $imageName : 'null',
            'Pending' => true,
        ]);
        return redirect('schools/school');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $school = \App\Models\Schools\School::find($id);
        $address = \App\Models\Schools\SchoolAddress::find($school->Address_id);
        $schoolArr = [
            'Name' => $school->Name,
            'Contact Number' => $school->Contact_Number,
            'Email' => $school->Email,
            'Address Line 1' => $address->Address1,
            'Address Line 2' => $address->Address2,
            'Postcode' => $address->Postcode,
            'County' => $address->County,
            'Country' => $address->Country,
            'Pending' => $school->Pending
        ];
        return view('schools/viewschool', ['school' => $schoolArr]);
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

    private function getImagePath($imageName)
    {
        return $imageName[0] . '/' . $imageName[1];
    }

    public function mySchool()
    {
        if(Auth::guard('student')->check() || Auth::guard('teacher')->check()) {
            if (Auth::guard('student')->check())
                $user = Auth::guard('student')->user();
            if (Auth::guard('teacher')->check())
                $user = Auth::guard('teacher')->user();
            $school = $this->school::find($user->assigned_school);
            $groups = $this->groups::where('assigned_school', '=', $user->assigned_school)->get();
            $tasks = [];
            $usedId = [];
            if(Auth::guard('student')->check())
            {
                foreach (explode(',', $user->assigned_groups) as $group_id)
                {
                    if(!$group_id)
                        continue;
                    $group = $this->groups::find($group_id);
                    foreach(explode(',', $group->assigned_tasks) as $task_id)
                    {
                        if(!$task_id)
                            continue;
                        if(!isset($usedId[$task_id])) {
                            $usedId[$task_id] = $task_id;
                            $tasks[] = $this->tasks::find($task_id);
                        }
                    }
                }
            }
            return view('schools/myschool', ['school' => $school, 'user' => $user, 'groups' => $groups, 'tasks' => $tasks]);
        }
        return redirect('/');
    }

    public function manageTeachers()
    {
        if(!Auth::guard('teacher')->check())
            redirect('/');
        $user = Auth::guard('teacher')->user();

        $staff = $this->teachers::where('assigned_school', '=', $user->assigned_school)->get();

        return view('schools/managestaff', ['staff' => $staff]);
    }
    public function manageStudents()
    {
        if(!Auth::guard('teacher')->check())
            redirect('/');
        $user = Auth::guard('teacher')->user();

        $students = $this->students::where('assigned_school', '=', $user->assigned_school)->get();

        return view('schools/managestudents', ['students' => $students]);
    }

    public function resetPassword(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            redirect('/');
        if($request->get('user') == 'teacher'){
            $teacher = $this->teachers::findOrFail($request->get('id'));
            $teacher->password = Hash::make($teacher->username . '00000');
            $teacher->save();
            return 'success';
        }
        if($request->get('user') == 'student'){
            $student = $this->students::findOrFail($request->get('id'));
            $student->password = Hash::make($student->student_id . '00000');
            $student->save();
            return 'success';
        }
    }

    public function deleteUser(Request $request)
    {
        if(!Auth::guard('teacher')->check())
            redirect('/');
        if($request->get('user') == 'teacher'){
            $teacher = $this->teachers::findOrFail($request->get('id'));
            $teacher->delete();
            return 'success';
        }
        if($request->get('user') == 'student'){
            $student = $this->students::findOrFail($request->get('id'));
            $this->taskCompleted::where('student_id', '=', $student->student_id)->delete();
            $student->delete();
            return 'success';
        }

    }
}

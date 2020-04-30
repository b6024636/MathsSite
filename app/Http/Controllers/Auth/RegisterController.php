<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Users\Admin;
use App\Models\Users\Teachers;
use App\Models\Users\Students;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Schools\School;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $schools;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(School $school)
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
        $this->schools = $school;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'admin']);
    }

    public function showTeacherRegisterForm()
    {
        return view('auth.register', ['url' => 'teacher']);
    }

    public function showStudentRegisterForm()
    {
        return view('auth.register', ['url' => 'student', ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Create a new teacher user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createTeacher(Request $request)
    {
        $this->validator($request->all())->validate();
        $teacher = Teachers::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'assigned_school' => 1,
            'role' => 'teacher',
            'assigned_groups' => ',',
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/teacher');
    }

    protected function createAdmin(Request $request)
    {
        $this->validator($request->all())->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'role' => 'admin',
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/admin');
    }

    protected function createStudent(Request $request)
    {
        $user = Auth::user();

        $this->validator($request->all())->validate();
        $student = Students::create([
            'student_id' => $request['student-id'],
            'assigned_school' => 1,//$user->assigned_school,
            'assigned_groups' => ',',
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/student');
    }
}

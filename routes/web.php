<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/schooltest', 'SchoolTestController');
Route::resource('/schools/schooladdress', 'School\SchoolAddressController');
Route::resource('/admin/school', 'School\SchoolController');
Route::resource('/questions/question', 'Questions\QuestionController');
Route::resource('/tasks/task', 'Tasks\TaskController');
Route::resource('/groups/group', 'Groups\GroupController');


Route::get('/myschool', 'School\SchoolController@mySchool');

Route::get('/myschool/task/manage', 'Tasks\TaskController@manageTasks');
Route::get('/manage/students', 'School\SchoolController@manageStudents');
Route::get('/manage/teachers', 'School\SchoolController@manageTeachers');
Route::get('/resetPassword', 'School\SchoolController@resetPassword');
Route::get('/deleteuser', 'School\SchoolController@deleteUser');


Route::get('/tasks/task/begintask/{id}', 'Tasks\TaskController@beginTask')->where('id', '[0-9]+');;
//Route::get('/tasks/task/finishtask', [ 'uses' => 'Tasks\TaskController@finishTask']);
Route::post('/tasks/task/finishtask', 'Tasks\TaskController@finishTask');

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/teacher', 'Auth\LoginController@showTeacherLoginForm');
Route::get('/login/student', 'Auth\LoginController@showStudentLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/teacher', 'Auth\RegisterController@showTeacherRegisterForm');
Route::get('/register/student', 'Auth\RegisterController@showStudentRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/teacher', 'Auth\LoginController@teacherLogin');
Route::post('/login/student', 'Auth\LoginController@studentLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/teacher', 'Auth\RegisterController@createTeacher');
Route::post('/register/student', 'Auth\RegisterController@createStudent');

Route::post('/groups/adduser', 'Groups\GroupController@addUserToGroup');
Route::post('/groups/removeuser', 'Groups\GroupController@removeUserFromGroup');
Route::post('/groups/addwork', 'Groups\GroupController@addWorkToGroup');
Route::post('/groups/removework', 'Groups\GroupController@removeWorkFromGroup');
Route::post('/groups/studentwork', 'Tasks\TaskController@getCompletedTasksByUser');
Route::post('/groups/taskresults', 'Tasks\TaskController@getCompletedTasksByGroup');


Route::view('/admin', 'admin/admin');

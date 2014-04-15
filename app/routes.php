<?php

use Illuminate\Http\Response;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



Route::get('/', function()
{
	//return View::make('hello');
	return "hello";
});
//首页
Route::get('mainPage','HomeController@mainPage');

Route::get('route','HomeController@showRoute');

//register模块路由
//注册表单
Route::get('register/form','RegisterController@registerForm');
//提交表单
Route::post('register/register','RegisterController@register');
//检测邮箱是否已注册
Route::post('register/checkEmail','RegisterController@checkEmail');
//提供验证码
Route::get('register/code','RegisterController@identifyingCode');
//检验验证码
Route::post('register/vaild','RegisterController@iCodeCheck');
//发送验证邮件
Route::get('register/mail','RegisterController@sendMail');
//验证用户邮箱
Route::get('register/vaildEmail/{userId}/{authCode}','RegisterController@vaildEmail');
//填写密保问题
Route::get('register/security','RegisterController@setSecurity');
Route::post('register/security','RegisterController@setSecurity');



//login模块路由
//登录表单
Route::get('login/form','LoginController@loginForm');
//提交表单
Route::post('login/login','LoginController@login');
//注销用户
Route::get('login/logout','LoginController@logout');
//忘记密码
Route::get('login/forget','LoginController@forgetPassword');
Route::post('login/forget','LoginController@forgetPassword');
//重置密码
Route::get('login/reset/{userId}/{authCode}','LoginController@resetPassword');
//验证密保问题
Route::get('login/Vsecurity/{operation?}','LoginController@vaildSecurity');
Route::post('login/Vsecurity/{operation?}','LoginController@vaildSecurity');
//修改密码
Route::get('login/chgPass','LoginController@changePassword');
Route::post('login/chgPass','LoginController@changePassword');
//修改邮箱
Route::get('login/chgEmail','LoginController@changeEmail');
Route::post('login/chgEmail','Logincontroller@changeEmail');
Route::get('login/activeNewEmail/{userId}/{authCode}/{newEmail}/{vaildCode}','LoginController@activeNewEmail');
//设置个人信息
Route::get('login/profile','LoginController@setProfile');
Route::post('login/profile','LoginController@setProfile');
//显示个人信息
Route::get('login/show','LoginController@showProfile');



//后台模块
Route::get('admin/list','AdminController@userList');
Route::get('admin/login','AdminController@login');
Route::post('admin/login','AdminController@login');
Route::get('admin/logout','AdminController@logout');
Route::get('admin/logout','AdminController@logout');
//提升为管理员
Route::get('admin/upToM/{uid}','AdminController@upToM');
Route::get('admin/downToU/{mid}','AdminController@downToU');
Route::get('admin/delUser/{uid}','AdminController@delUser');

//教师管理员操作
Route::get('admin/addTeacher/{uid}','AdminController@addTeacher');
Route::get('admin/delTeacher/{uid}','AdminController@delTeacher');

//文件操作
Route::get('file/form','FileController@form');

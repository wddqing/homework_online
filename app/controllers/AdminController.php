<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class AdminController extends BaseController{
	protected $layout = 'layouts.adminMaster';
	public function Login(){
		if(!empty($_POST)){
			//后台登录判断
			//超级管理员密码：homework_super 用户名：super@hm.com
			$admin = admin::where('loginName','=',Input::get('email'));
			if($admin->count() == 1){
				$admin = $admin->first();
				if(Hash::check(Input::get('password'),$admin->password )){
					$timeStamp = time();
					session_start();
					$_SESSION['admin'] = $timeStamp;
					$_SESSION['type'] = $admin->type;
					setcookie('admin',$timeStamp.$admin->type);
					return Redirect::to('admin/list');
				}
				return Redirect::to('admin/login');
			}else{
				return Redirect::to('admin/login');
			}
		}else{
			//返回登录表单
			$this->layout->content = view::make('admin.form');
		}
	}
	
	public function Logout(){
		session_start();
		unset($_SESSION['admin']);
		unset($_SESSION['type']);
		setcookie('admin','',-1);
		
		return Redirect::to('admin/login');
	}
	//用户和管理员列表
	public function userList(){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type'])){
			$alluser = userMain::paginate(10);
			$allmanager = admin::paginate(10);
			$allteacher = userMain::whereHas('Utype',function($q){
				$q->where('type','=',2);
			})->paginate(10);
			$result['users'] = $alluser;
			$result['admins'] = $allmanager;
			$result['teachers'] = $allteacher;
			$result['type'] = $_SESSION['type'];
			$this->layout->content = view::make('admin.list',$result);
		}else{
			return Redirect::to('admin/login');
		}
		
	}
	//提升为管理员
	public function upToM($uid){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type']) && $_SESSION['type'] == 2){
			$user = userMain::find($uid);
			if(admin::where('id','=',$uid)->count() < 1){
				$admin = new admin();
				$admin->id = $user->id;
				$admin->loginName = $user->email;
				$admin->password = $user->password;
				$admin->type = 1;
				$admin->save();
				return Redirect::to('admin/list');
			}else{
				return "该用户已经是管理员了";
			}
			
		}else{
			return Redirect::to('admin/login');
		}
	}
	//删除管理员
	public function downToU($mid){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type']) && $_SESSION['type'] == 2){
			$admin = admin::find($mid);
			$admin->delete();
			return Redirect::to('admin/list');
		}else{
			return Redirect::to('admin/login');
		}
	}
	//删除用户
	public function delUser($uid){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type']) && $_SESSION['type'] == 2){
			$user = userMain::find($uid);
			$user->Utype->delete();
			$user->delete();
			return Redirect::to('admin/list');
		}else{
			return Redirect::to('admin/login');
		}
	}
	//搜索用户
	public function searchU($uName){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type'])){
			
		}else{
			return Redirect::to('admin/login');
		}
	}
	//搜索管理员
	public function searchM($mName){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type'])){
			
		}else{
			return Redirect::to('admin/login');
		}
	}
	//确认为教师
	public function addTeacher($uid){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type'])){
			$user = userMain::find($uid);
			if($user->Utype){
				$user->Utype->type = 2;
				$user->Utype->save();
			}else{
				$type = new Utype();
				$type->type = 2;
				$user->Utype()->save($type);
			}
			
			return Redirect::to('admin/list');
		}else{
			return Redirect::to('admin/login');
		}
	}
	//删除教师身份
	public function delTeacher($uid){
		session_start();
		if(isset($_SESSION['admin']) && isset($_SESSION['type']) && isset($_COOKIE['admin']) && $_COOKIE['admin'] == ($_SESSION['admin'].$_SESSION['type'])){
			$user = userMain::find($uid);
			$user->Utype->type = 0;
			$user->Utype->save();
			//$user->save();
			return Redirect::to('admin/list');	
		}else{
			return Redirect::to('admin/login');
		}
	}
}

?>
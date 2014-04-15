<?php
	
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class LoginController extends BaseController{
	protected $layout = 'layouts.master';
	
	public function loginForm(){
		if(!Auth::check()){
			$result = array();
			//忘记密码处理入口地址生成
			$result['forget'] = URL::to('login/forget');
			$this->layout->content = view::make('login.login',$result);
		}else{
			return Redirect::to('mainPage');
		}
	}
	//登录用户
	public function login(){
		/* if(Input::get('remember') == 1){
			$remember = true;
		}else{
			$remember = false;
		} */
		if(Auth::attempt(array('email'=>Input::get('email'),'password'=>Input::get('password'),'vaild'=>1))){
			if(!(Security::where('userId','=',Auth::user()->id)->count())){
				return Redirect::to('register/security');
			}
			return Redirect::to('mainPage');
		}else{
			//未登录或者未激活账户，提示用户做选择
			$result['welcome'] = URL::to('mainPage');
			$result['forget'] = URL::to('login/forget');
			$this->layout->content = view::make('login.notice',$result);
			//return Redirect::to('login/form');
		}
	}
	//注销用户
	public function logout(){
		if(Auth::check()){
			Auth::logout();
			return Redirect::to('login/form');
		}else{
			return Redirect::to('mainPage');
		}
	}
	
	//验证密保问题
	
	/**
	 * @param number $operation 验证通过要执行的操作，1为修改密码，2为修改邮箱,其他值自动跳转到首页
	 */
	public function vaildSecurity($operation = 0){
		if(Auth::check()){
			//$questionId = Input::get('question');
			$answer = Input::get('answer');
			if(!empty($answer) && isset($operation)){
				if(Security::where('userId','=',Auth::user()->id)->first()->answer == $answer){
					session_start();
					switch($operation){
						case 1:$_SESSION['changePassword'] = 1;$url = 'login/chgPass';break;
						case 2:$_SESSION['changeEmail'] = 1;$url = 'login/chgEmail';break;
						default:$url = 'mainPage';
					}
					return Redirect::to($url);
				}else{
					$notice = new notice("哦哦，答案不对哦，请重新作答",URL::to('login/Vsecurity/'.$operation),"重新回答安保问题");
					$result = $notice->getMessage();
					$this->layout->content = view::make('notice.notice',$result);
				}
			}else{
				$security = Security::where('userId','=',Auth::user()->id)->first();
				$result['question'] = Uquestion::find($security->questionId)->question;
				//$result['questionId'] = $security->questionId;
				$result['operation'] = $operation;
				$this->layout->content = view::make('login.security',$result);
			}
			
		}else{
			//提示登录
			$notice = new notice("哦哦，您尚未登录，请登录后操作",URL::to('login/form'),"登录页面");
			$result = $notice->getMessage();
			$this->layout->content = view::make('notice.notice',$result);
			//$this->notice("哦哦，您尚未登录，请登录后操作",URL::to('login/form'),"登录页面");
		}
	}
	//修改密码
	function changePassword(){
		if(Auth::check()){
			session_start();
			if(isset($_SESSION['changePassword']) && $_SESSION['changePassword']){
				$oldPassword = Input::get('oldPwd');
				$newPassword = Input::get('newPwd');
				if(!empty($oldPassword) && !empty($newPassword)){
					$user = userMain::find(Auth::user()->id);
					if(Hash::check($oldPassword,$user->password)){
						$user->password = Hash::make($newPassword);
						$user->save();
						unset($_SESSION['changePassword']);
						$message = "密码修改成功";
						$url = URL::to('login/form');
						$name = "登录";
						
						//退出登录，提示用户进行重新登录
						$this->logout();
					}else{
						$message = "旧密码错误，请重新输入";
						$url = URL::to("login/chgPass");
						$name = "密码修改";
					}
					$notice = new notice($message, $url, $name);
					$result = $notice->getMessage();
					$this->layout->content = view::make('notice.notice',$result);
				}else{
					//返回修改密码表单
					$this->layout->content = view::make('login.chgPass');
				}
			}else{
				$notice = new notice("哦哦，您未回答密保问题，请回答后操作",URL::to('login/Vsecurity/1'),"回答密保问题");
				$result = $notice->getMessage();
// 				var_dump($result);
				$this->layout->content = view::make('notice.notice',$result);
			}
		}else{
			//提示用户进行登录
			$notice = new notice("哦哦，您尚未登录，请登录后操作", URL::to('login/form'), "登录页面");
			$result = $notice->getMessage();
			$this->layout->content = view::make('notice.notice',$result);
		}
	}
	//修改邮箱
	function changeEmail(){
		if(Auth::check()){
			session_start();
			if(isset($_SESSION['changeEmail']) && $_SESSION['changeEmail']){
				$newEmail = Input::get('newEmail');
				if(!empty($newEmail) && userMain::where('email','=',$newEmail)->count() < 1){
					$user = userMain::find(Auth::user()->id);
// 					$_SESSION['newEmail'] = $newEmail;
					$timestamp = time();
					$userId = substr($timestamp, strlen($timestamp)-4).($user->id).substr($timestamp, 0,3);
					$authCode = md5($user->vaildCode);
					$vaildCode = substr(md5($newEmail."homework_online"),4,10);
					$url = URL::to('login/activeNewEmail/'.$userId."/".$authCode."/".$newEmail."/".$vaildCode);
					$data['url'] = $url;
					$data['title'] = "HomeWork Online";
					$toMail = $user->email;	
					Mail::send('emails.auth.register',$data,function($message) use($toMail) {
						$message->to($toMail, 'wddqing')->subject('在线题库用户验证邮件');
					});
					unset($_SESSION['changeEmail']);
					//退出登录
					$this->logout();
					$notice = new notice("邮箱修改申请已经提交，验证邮件已经发往您的旧邮箱，在旧邮箱进行激活后就可以使用新邮箱进行登录了，未激活之前仍可用就邮箱登录！", URL::to('mainPage'), "首页");
					$result = $notice->getMessage();
					$this->layout->content = view::make('notice.notice',$result);
				}else{
					//返回修改邮箱表单
					$this->layout->content = view::make('login.chgEmail');
				}
				
			}else{

				$notice = new notice("哦哦，您未回答密保问题，请回答后操作",URL::to('login/Vsecurity/2'),"回答密保问题");
				$result = $notice->getMessage();
				// 				var_dump($result);
				$this->layout->content = view::make('notice.notice',$result);
			}
		}else{
			//提示用户进行登录
			$notice = new notice("哦哦，您尚未登录，请登录后操作", URL::to('login/form'), "登录页面");
			$result = $notice->getMessage();
			$this->layout->content = view::make('notice.notice',$result);
		}
	}
	//激活新邮箱
	public function activeNewEmail($userId,$authCode,$newEmail,$vaildCode){
		if(strlen($userId) > 7){
			$userId = substr($userId,4,strlen($userId)-7);
			$user = userMain::find($userId);
			if($user->count() > 0 && md5($user->vaildCode) == $authCode && substr(md5($newEmail."homework_online"),4,10) == $vaildCode){
				$user->email = $newEmail;
				$user->save();
				if(Auth::check()){
					Auth::logout();
				}
				$message = "新邮箱已经激活，可以使用";
				$url = URL::to('login/form');
				$urlName = "返回";
			}else{
				$message = "哦哦，这个地址似乎不对哦！";
				$url = URL::to('mainPage');
				$urlName = "首页";
			}
		}else{
			$message = "哦哦，这个地址似乎不对哦！";
			$url = URL::to('mainPage');
			$urlName = "首页";
		}
		$url = URL::to('mainPage');
		$urlName = "首页";
		$notice = new notice($message,$url,$urlName);
		$result = $notice->getMessage();
		$this->layout->content = view::make('notice.notice',$result);
	}
	
	//重置密码
	public function resetPassword($userId,$authCode){
		if(strlen($userId) > 7){
			$userId = substr($userId,4,strlen($userId)-7);
			$user = userMain::find($userId);
			if($user->count() > 0 && md5($user->vaildCode) == $authCode ){
				$randomLetter = new identifyingCode();
				$randomLetter->setLength(6);
				$randomLetter->setContent('');
				$randomLetter->get_num_letter();
				$password = $randomLetter->getContent();
				
				$user->password = Hash::make($password);
				$randomLetter->setLength(4);
				$randomLetter->setContent('');
				$randomLetter->get_num_letter();
				$user->vaildCode = $randomLetter->getContent();
				$user->save();
				if(Auth::check()){
					Auth::logout();
				}
				$message = "密码已经重置为".$password;
				$url = URL::to('login/form');
				$urlName = "登录";
			}else{
				$message = "哦哦，这个地址似乎不对哦！";
				$url = URL::to('mainPage');
				$urlName = "首页";
			}
		}else{
			$message = "哦哦，这个地址似乎不对哦！";
			$url = URL::to('mainPage');
			$urlName = "首页";
		}
		$notice = new notice($message,$url,$urlName);
		if($urlName == "登录"){
			$notice->setRedirect(0);
		}
		$result = $notice->getMessage();
		$this->layout->content = view::make('notice.notice',$result);
	}
	//忘记密码操作
	public function forgetPassword(){
		//登录邮箱
		$email = Input::get('email');
		//验证码
		$code  = Input::get('code');
		if(!empty($email) && !empty($code)){
			$user = userMain::where('email','=',$email);
			if($user->count()>0){
				$user = $user->first();
				$timestamp = time();
				$userId = substr($timestamp, strlen($timestamp)-4).($user->id).substr($timestamp, 0,3);
				$authCode = md5($user->vaildCode);
				$url = URL::to('login/reset/'.$userId."/".$authCode);
				$data['url'] = $url;
				$data['title'] = "HomeWork Online";
				$toMail = $user->email;
				Mail::send('emails.auth.reset',$data,function($message) use($toMail) {
					$message->to($toMail, 'wddqing')->subject('在线题库用户密码重置确认邮件');
				});
				$message = "确认邮件已经发出，请登录邮箱进行确认并重置密码";
				$url = URL::to('mainPage');
				$urlName = "首页";
				$notice = new notice($message,$url,$urlName);
				$result = $notice->getMessage();
				$this->layout->content = view::make('notice.notice',$result);
			}else{
				$message = "该邮箱并没有在本站进行注册哦";
				$url = URL::to('login/forget');
				$urlName = "忘记密码";
				$notice = new notice($message,$url,$urlName);
				$result = $notice->getMessage();
				$this->layout->content = view::make('notice.notice',$result);
			}
		}else{
			$result = array();
			$result['url'] = URL::to('register/code');
			$this->layout->content = view::make('login.forget',$result);
		}
	}
	/* //在用户没登陆情况下，提示信息并进行跳转
	public function notice($notice,$welcome,$urlName){
		$result['notice'] = $notice;
		$result['welcome'] = $welcome;
		$result['urlName'] = $urlName;
		$this->layout->content = view::make('notice.notice',$result);
	} */
	
	//填写或修改个人信息
	public function setProfile(){
		if(Auth::check()){
			if(empty($_POST)){
				$profile = profiles::find(Auth::user()->id);
				$result = array();
				if($profile){
	// 				$profile = $profile->get();
					$result['nickName'] = $profile->nickName;
					$result['jobId'] = $profile->jobId;
					$result['trueName'] = $profile->trueName;
				}else{
					$result['nickName'] = "";
					$result['jobId'] = "";
					$result['trueName'] = "";
				}
				$this->layout->content = view::make('login.profile',$result);
			}else{
				$profile = profiles::find(Auth::user()->id);
				if(!$profile){
					$profile = new profiles();
				}
				$profile->id = Auth::user()->id;
				$profile->nickName = Input::get('nickName');
				$profile->jobId = Input::get('jobId');
				$profile->trueName = Input::get('trueName');
				$profile->save();
				$message = "个人信息修改成功！";
				$url = URL::to('login/show');
				$urlName = "个人信息";
				$notice = new notice($message,$url,$urlName);
				$result = $notice->getMessage();
				$this->layout->content = view::make('notice.notice',$result);
			}
		}else{
			$message = "您还未登陆，不能执行该操作！";
			$url = URL::to('login/form');
			$urlName = "登陆";
			$notice = new notice($message,$url,$urlName);
			$result = $notice->getMessage();
			$this->layout->content = view::make('notice.notice',$result);
		}
	}
	//展示个人信息
	public function showProfile(){
		if(Auth::check()){
			$profile = profiles::find(Auth::user()->id);
			if($profile){
				$result['nickName'] = $profile->nickName;
				$result['jobId'] = $profile->jobId;
				$result['trueName'] = $profile->trueName;
				$this->layout->content = view::make('login.show',$result);
			}else{
				//还未填写个人信息
				$message = "您还未填写个人信息，请先填写！";
				$url = URL::to('login/profile');
				$urlName = "填写个人信息";
				$notice = new notice($message,$url,$urlName);
				$result = $notice->getMessage();
				$this->layout->content = view::make('notice.notice',$result);
			}
		}else{
			
		}
	}
}

?>
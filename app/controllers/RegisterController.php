<?php
	
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response ;
use Illuminate\Support\Facades\Response as Responses;
use Symfony\Component\CssSelector\Parser\Reader;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController{
		/*
		 * used for register 
		 * 
		 */
	
		protected $layout = 'layouts.master';
		//显示注册表单
		public function registerForm(){
			$result = array();
			$result['url'] = URL::to('register/checkEmail');
			$result['vaild'] = URL::to('register/vaild');
			$this->layout->content = view::make('register.register',$result);
		}
		
		//将用户插入数据库
		public function register(){
			session_start();
			if(userMain::where('email','=',Input::get('email'))->count() < 1){
				$user = new userMain();
				$user->email = Input::get('email');
				$password = Input::get('password');
				$user->password = Hash::make($password);
				$user->vaild = 0;
				$user->vaildCode = Input::get('identifyingCode'); 
				
				$user->save();
				$type = new Utype(array('type'=>'0'));
				$user->Utype()->save($type);
				
				//发送邮件
				$this->sendMail($user->email, $user->userId, $user->vaildCode);
				//注册完提示用户进行激活后登陆
				$result['welcome'] = URL::to('mainPage');
				$result['notice'] = "注册成功，请到邮箱激活账户并登陆";
				$result['urlName'] = "首页";
				//将用于保存验证码数值的session删除
				unset($_SESSION['code']);
				$this->layout->content = view::make('register.notice',$result);
			}else{
				return Redirect::to('register/form');
			}
		} 
		//判断用户邮箱是否已经注册过
		public function checkEmail(){
			if(userMain::where('email','=',Input::get('email'))->count() >= 1){
				return Responses::json(array('exist'=>1));
			}else{
				return Responses::json(array('exist'=>0));
			}
// 			return Input::get('email');
		}
		/**
		 * @param string $script 验证入口
		 * @param string $userId 用户编号
		 * @param string $authCode 用户验证码
		 * 产生验证连接
		 */
		public function generateVaildUrl($script,$userId,$authCode){
			$url = $script;
			$timestamp = time();
			$userId = substr($timestamp, strlen($timestamp)-4).$userId.substr($timestamp, 0,3);
			$url .= "/".$userId;
			$authCode = md5($authCode);
			$url .= "/".$authCode;
			return $url;
		}

		/**
		 * @param string $toMail 收件人
		 * @param number $userId 用户编号
		 * @param string $authCode 验证码
		 * 发送验证邮件
		 */
		public function sendMail($toMail="wddqing@gmail.com",$userId = 1,$authCode="1234"){
			$data['url'] = $this->generateVaildUrl(URL::to('register/vaildEmail'),$userId,$authCode);
			$data['title'] = "HomeWork Online";
			
			Mail::send('emails.auth.register',$data,function($message) use($toMail) {
				$message->to($toMail, 'wddqing')->subject('在线题库用户验证邮件');
			});
// 			return $data['url'];
		}
		//邮箱验证入口
		public function vaildEmail($userId,$authCode){
			$id = $userId;
			$code = $authCode;
			if(isset($id) && isset($code)){
				if(strlen($id) > 7){
					$id = substr($id,4,strlen($id)-7);
					$user = userMain::find($id);
				 	if($user->count() == 1 && $user->vaildCode == 0){
						if($code == md5($user->vaildCode)){
							$user->vaild = 1;
							$user->save();
							return "验证通过";
						}else{
							return "验证出错";
						}
					} 
				}else{
					return "error parameter!";
				}
			}else{
				return "error parameter!";
			}
		}
		//产生验证码
		public function identifyingCode(){
			$code = new identifyingCode( 60,30,4,3);
			$image = $code->generate_img(3);
			
			$res = new Response();
			$res->header('Content-Type','image/png');
			
			imagepng ( $image );
			return $res;
		}
		//验证验证码数值
		public function iCodeCheck(){
			session_start();
			if($_SESSION['code'] == Input::get('codes')){
				return Responses::json(array('vaild'=>1));
			}else{
				return Responses::json(array('vaild'=>0));
			}
		}
		
		//设置安保问题
		public function setSecurity(){
			if(Auth::check()){
				$questionId = Input::get('question');
				$answer = Input::get('answer');
				if(!empty($questionId) && !empty($answer)){
					$security = new Security();
					$security->userId = Auth::user()->id;
					$security->questionId = $questionId;
					$security->answer = $answer;
					if($security->save()){
						$result['notice'] = "密保问题设置成功";
						$result['welcome'] = URL::to('mainPage');
						$result['urlName'] = "首页";
					}else{
						$result['notice'] = "密保问题设置不成功，请重新设置";
						$result['welcome'] = URL::to('register/security');
						$result['urlName'] = "设置安保问题";
					}
					
					
					$this->layout->content = view::make('register.notice',$result);
				}else{
					$question = Uquestion::where('id','<',13)->take(12)->get();
					foreach ($question as $value){
						$result['question'][$value->id] = $value->question;
					}	
					$this->layout->content = view::make('register.security',$result);
				}
			}else{
				//提示登录
				$result['notice'] = "哦哦，您尚未登录，请登录后操作";
				$result['welcome'] = URL::to('login/form');
				$result['urlName'] = "登录页面";
				$this->layout->content = view::make('register.notice',$result);
			}
		}
	}

?>
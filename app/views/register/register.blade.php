@extends('layouts.master') 
@section('title') 注册 @stop

@section('content')
<div id="register_form">
		<?php echo Form::open(array('url'=>'register/register')); ?>
		<div id="email">
		<span>注册邮箱</span>
		<span><?php echo Form::text('email'); ?></span>
		 <span>	<label id="notice_email"></label></span>
	</div>
	<!-- end email -->
	<div id="password">
		<span>登录密码</span> <span><?php echo Form::password('password'); ?></span>
		<span><label id="notice_password"></label></span>
	</div>
	<!-- end password -->
	<div id="repeat_password">
		<span>重复密码</span> <span><?php echo Form::password('repeat_password'); ?></span>
		<span><label id="notice_repeat"></label></span>
	</div>
	<!-- end repeat_password -->
	<div id="identifyingCode">
		<span><img src="code" /></span> <span><?php echo Form::text('identifyingCode')?>
			</span> <span><label id="notice_identifyingCode"></label></span>
	</div>
	<!-- end identifyingCode -->
	<div id="submit">
		<span></span> <span><input type="submit" id="button_register" value="注册" /></span> <span><?php echo Form::reset('重置'); ?></span>
	</div>
	<!-- end submit -->
		<?php echo Form::close(); ?> 
	<!-- end register_form -->
</div>
<script type="text/javascript">
		//js for email check
		var email_vaild = false;
		$("input[name='email']").blur(function(event){
			var emails = $("input[name='email']").attr('value').toString();
			if(emails != ""){
				var patten = new RegExp(/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+(com|cn)$/);
				if(patten.test(emails)){
					$.post('{{ $url }}',{email:emails},function(response){
						if(response['exist'] == 0){
							$('#notice_email').html('该邮箱可以注册');
							email_vaild = true;
						}else{
							$('#notice_email').html('该邮箱已注册');
							email_vaild = false;
						}
					});
				}else{
					$('#notice_email').html('邮箱格式不正确');
					email_vaild = false;
				}
				
			}else{
				$('#notice_email').html('注册邮箱不能为空');
				email_vaild = false;
			}
			
		});
		$("input[name='email']").focus(function(event){
			$('#notice_email').html('');
		});
	</script>
<script type="text/javascript">
	//password check
	var password_vaild = false;
	$("input[name='password']").keyup(function(event){
		var passwords = $("input[name='password']").attr('value').toString();
		var length = passwords.length;
		
		if(length < 6){
			$('#notice_password').html("<font color='red'>不能少于6个字符</font>");
			password_vaild = false;
		}else if(length >=6 && length < 12){
			$('#notice_password').html("<font color='blue'>强度弱</font>");
			password_vaild = true;
		}else if(length >= 12 && length <=18){
			$('#notice_password').html("<font color='green'>强度合理</font>");
			password_vaild = true;
		}else if(length > 18){
			$('#notice_password').html("<font color='red'>太强了</font>");
			password_vaild = false;
		}
	});
	var password_repeat_vaild = false;
	$("input[name='repeat_password']").keyup(function(event){
		var passwords =  $("input[name='password']").attr('value').toString();
		var password_repeat =  $("input[name='repeat_password']").attr('value').toString();
		if(passwords == password_repeat){
			$('#notice_repeat').html("<font color='green'>密码一致</font>");
			password_repeat_vaild = true;
		}else{
			$('#notice_repeat').html("<font color='red'>密码不一致</font>");
			password_repeat_vaild = false;
		}
		});
	</script>
<script type="text/javascript">
	var codes_vaild = false;
	$("input[name='identifyingCode']").blur(function(event){
		var vaildCode = $("input[name='identifyingCode']").attr('value').toString();
		if(vaildCode.length > 0 && vaildCode.length < 10){
			$.post('{{ $vaild }}',{codes:vaildCode},function(response){
				if(response['vaild'] == 1){
					$('#notice_identifyingCode').html("<font color='green'>right</font>");
					codes_vaild = true;
				}else{
					$('#notice_identifyingCode').html("<font color='red'>wrong</font>");
					codes_vaild = false;
				}
			});
		}
	});
	</script>
	<script type="text/javascript">
		$("#button_register").click(function(){
			if(codes_vaild && password_repeat_vaild && password_vaild && email_vaild){
				return true;
			}else{
				return false;
			}
			
		});
	</script>
@stop

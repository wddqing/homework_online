@extends('layouts.master') 
@section('title') 重置密码 @stop
@section('content')
	<div>
		<div id="notice">
			您好，请填写好您的登录邮箱账号，我们会发送邮件到该账户的邮箱进行确认。
		</div>
		<?php echo Form::open(array('url'=>URL::to('login/forget')));?>
		<div>
			<span>登录邮箱</span>
			<span><?php echo Form::text('email');?></span>
			<span id="notice_email"></span>
		</div>
		<div>
			<span><img src="<?php echo $url;?>" /></span>
			<span><?php echo Form::text('code'); ?></span>
			<span id="notice_identifyingCode"></span>
		</div>
		<div>
			<?php echo Form::submit('确定'); ?>
		</div>
		<?php echo Form::close(); ?>
	</div>
	<script type="text/javascript">
		//js for email check
		var email_vaild = false;
		$("input[name='email']").blur(function(event){
			var emails = $("input[name='email']").attr('value').toString();
			if(emails != ""){
				var patten = new RegExp(/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+(com|cn)$/);
				if(patten.test(emails)){
					$('#notice_email').html('该邮箱格式正确');
					email_vaild = true;
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
	var codes_vaild = false;
	$("input[name='code']").blur(function(event){
		var vaildCode = $("input[name='code']").attr('value').toString();
		if(vaildCode.length > 0 && vaildCode.length < 10){
			$.post(<?php URL::to('register/vaild');?>,{codes:vaildCode},function(response){
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
@stop
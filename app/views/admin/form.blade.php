@extends('layouts.master') 
@section('title') 后台登录 @stop

@section('content')
	<div id="login_form">
	<?php echo Form::open(array('url'=>'admin/login')); ?>
		<div id="email">
			<span>邮箱</span>
			<span><?php echo Form::text('email'); ?></span>
			<span><label id="notice_email"></label></span>
		</div>
		<!-- end email -->
		<div id="password">
			<span>密码</span>
			<span><?php echo Form::password('password'); ?></span>
			<span></span>
		</div>
		<!-- end password -->
		<div id="login">
			<span><?php echo Form::submit('登录'); ?></span>
		</div>
		<!-- end login -->
	<?php echo Form::close(); ?>
<!-- end login_form -->	 
</div>	
<script type="text/javascript">
	var email_vaild = false;
	$("input[name='email']").blur(function(event){
		var emails = $("input[name='email']").attr('value').toString();
		if(emails != ""){
			var patten = new RegExp(/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+(com|cn)$/);
			if(patten.test(emails)){
				$('#notice_email').html('');
				email_vaild = true;
			}else{
				$('#notice_email').html('邮箱格式不正确');
				email_vaild = false;
			}
		}else{
			$('#notice_email').html('登录邮箱不能为空');
		}	

	});

</script>
@stop
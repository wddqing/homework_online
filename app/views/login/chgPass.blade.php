@extends('layouts.master') 
@section('title') 修改密码 @stop
@section('content')
	<div>
		<?php echo Form::open(array('url'=>'login/chgPass'));?>
			<div>
				<span>旧密码</span>
				<span><?php echo Form::password('oldPwd'); ?></span>
			</div>
			<div>
				<span>新密码</span>
				<span><?php echo Form::password('newPwd'); ?></span>
				<span id="notice_password"></span>
			</div>
			<div>
				<span>再输一遍</span>
				<span><?php echo Form::password('repPwd'); ?></span>
				<span id="notice_repeat"></span>
			</div>
			<div>
				<span><?php echo Form::submit('确定'); ?></span>
			</div>
		<?php echo Form::close();?>
	</div>
	<script type="text/javascript">
	//password check
	var password_vaild = false;
	$("input[name='newPwd']").keyup(function(event){
		var passwords = $("input[name='newPwd']").attr('value').toString();
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
	$("input[name='repPwd']").keyup(function(event){
		var passwords =  $("input[name='newPwd']").attr('value').toString();
		var password_repeat =  $("input[name='repPwd']").attr('value').toString();
		if(passwords == password_repeat){
			$('#notice_repeat').html("<font color='green'>密码一致</font>");
			password_repeat_vaild = true;
		}else{
			$('#notice_repeat').html("<font color='red'>密码不一致</font>");
			password_repeat_vaild = false;
		}
		});
	</script>
@stop
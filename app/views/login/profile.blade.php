@extends('layouts.master') 
@section('title') 修改个人信息 @stop
@section('content')
	<div>
		<?php echo Form::open(array('url'=>'login/profile'));?>
			<div>
				<span>用户昵称</span>
				<span><?php echo Form::text('nickName',$nickName);?></span>
				<span></span>
			</div>
			<div>
				<span>学号/工号</span>
				<span><?php echo Form::text('jobId',$jobId);?></span>
				<span></span>
			</div>
			<div>
				<span>真实姓名</span>
				<span><?php echo Form::text('trueName',$trueName);?></span>
				<span></span>
			</div>
			<div>
				<span><?php echo Form::submit('提交');?></span>
			</div>
		<?php echo Form::close();?>
	</div>
@stop
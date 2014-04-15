@extends('layouts.master') 
@section('title') 展示个人信息 @stop
@section('content')
	<div>
		<div>
			<span>用户昵称</span>
			<span><?php echo $nickName;?></span>
			<span></span>
		</div>
		<div>
			<span>学号/工号</span>
			<span><?php echo $jobId;?></span>
			<span></span>
		</div>
		<div>
			<span>真实姓名</span>
			<span><?php echo $trueName;?></span>
			<span></span>
		</div>
	</div>
@stop
@extends('layouts.master') 
@section('title') 设置安保问题 @stop
@section('content')
	<div id="security">
		<?php echo Form::open(array('url'=>'register/security'));?>
			<div id="question">
				<span>安保问题</span>
				<span><?php echo Form::select('question',$question);	?></span>
			</div>
			<div id="answer">
				<span>问题答案</span>
				<span><?php echo Form::text('answer'); ?></span>
			</div>
			<div id="submit">
				<?php echo Form::submit("确定答案"); ?>
			</div>
		<?php echo Form::close();?>
	</div>
@stop
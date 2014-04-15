@extends('layouts.master') 
@section('title') 回答安保问题 @stop
@section('content')
	<div>
		<?php echo Form::open(array('url'=>'login/Vsecurity/'.$operation));?>
			<div>
				<span>问题</span>
				<span><?php echo $question; ?></span>
			</div>
			<div>
				<span>回答</span>
				<span><?php echo Form::text('answer');?></span>
				<span><?php echo Form::submit('回答');?></span>
			</div>
		<?php echo Form::close(); ?>
	
	</div>
@stop
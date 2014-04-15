@extends('layouts.master') 
@section('title') 修改邮箱 @stop
@section('content')
	<div>
		<?php echo Form::open(array('url'=>'login/chgEmail'));?>
			<div>
				<span>新邮箱</span>
				<span><?php echo Form::text('newEmail'); ?></span>
				<span id="notice_email"></span>
			</div>
			<div>
				<span><?php echo Form::submit('确定'); ?></span>
			</div>
		<?php echo Form::close();?>
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
							$('#notice_email').html('该邮箱可以使用');
							email_vaild = true;
						}else{
							$('#notice_email').html('该邮箱已被使用');
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
@stop
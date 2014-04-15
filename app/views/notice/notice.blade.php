@extends('layouts.master') 
@section('title') 友情提醒 @stop
@section('content')
<?php if(isset($redirect)){
		if($redirect == 0){
			;
		}else{	
?> 
			<meta http-equiv="refresh" content="<?php echo $redirect; ?>;URL=<?php echo $welcome; ?>" />
<?php 
		}
	  }else{ 
?>
			<meta http-equiv="refresh" content="5;URL=<?php echo $welcome; ?>" />
<?php 
	  }
?>
<?php echo $notice;?>,<label id="time"><?php if(isset($redirect)){
	if($redirect == 0){
		echo "返回";
	}else{
		echo $redirect."秒后返回";
	}
}else{
	echo "5秒后返回";
}?></label><a href="<?php echo $welcome; ?>"><?php echo $urlName; ?></a>
<script type="text/javascript">
	var time;
	function showtime(){
		time = parseInt($('#time').val());
		time--;
		if(time != 0){
			$('#time').val(time)
		}else{
			//跳转到首页
			location.href = "<?php echo $welcome; ?>"
		}
	}
	window.setTimeout(showtime,1000);
	
</script>
@stop
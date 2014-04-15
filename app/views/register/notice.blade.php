@extends('layouts.master') 
@section('title') 友情提醒 @stop
@section('content')
<meta http-equiv="refresh" content="5;URL=<?php echo $welcome; ?>" />
<?php echo $notice;?>,<label id="time">5</label>秒后返回<a href="<?php echo $welcome; ?>"><?php echo $urlName; ?></a>
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
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>
			<h2><?php echo $title; ?></h2>
			<p>你好，这里是在线题库验证邮件，如您未注册本网站用户，请勿例会本邮件！如您使用该邮箱注册，请点击重置密码连接进行密码重置。</p>
			<p><a href='<?php  echo $url; ?>' target="_blank">重置密码</a></p>
			<p>本邮件由系统自动发送，请勿回复！</p>
		</p>
	</body>
</html>
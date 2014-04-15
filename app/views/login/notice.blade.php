@extends('layouts.master') 
@section('title') 登录出错了 @stop
@section('content')
哦哦，出问题了，密码错误或者未激活账户,<a href="<?php echo $welcome; ?>">返回首页</a>或者<a href="<?php echo $forget; ?>">忘记密码</a>
@stop
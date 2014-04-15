@extends('layouts.master') 
@section('title') 用户管理 @stop

@section('content')
<style>

.page li{
	float:left;
	list-style:none;
	padding:0 5px;
	margin:0;
}
</style>
<table>
  	<tr>
    	<th>用户编号</th>
    	<th>登录邮箱</th>
    	<th>是否验证</th>
    	<th>验证标志</th>
    	<th>操作</th>
  	</tr>
  	
  	@foreach($users as $user)
	<tr>
		<td>{{$user->id}}</td>
		<td>{{$user->email}}</td>
		<td>{{$user->vaild}}</td>
		<td>{{$user->vaildCode}}</td>
		<td>
			@if($type == 2)
				{{ HTML::link('admin/upToM/'.$user->id,'升为管理员') }} &nbsp;&nbsp;&nbsp;
			@endif
			{{ HTML::link('admin/delUser/'.$user->id,'删除') }} &nbsp;&nbsp;&nbsp;
			{{ HTML::link('admin/addTeacher/'.$user->id,'确认为教师') }}
		</td>
	</tr>	
	@endforeach
	<tr>
		<td></td>
		<td colspan="4" class="page">{{ $users->links() }}</td>
	</tr>
</table>
<table>
  	<tr>
    	<th>教师编号</th>
    	<th>登录邮箱</th>
    	<th>是否验证</th>
    	<th>验证标志</th>
    	<th>操作</th>
  	</tr>
  	
  	@foreach($teachers as $teacher)
	<tr>
		<td>{{$teacher->id}}</td>
		<td>{{$teacher->email}}</td>
		<td>{{$teacher->vaild}}</td>
		<td>{{$teacher->vaildCode}}</td>
		<td>
			@if($type == 2)
				{{ HTML::link('admin/upToM/'.$teacher->id,'升为管理员') }} &nbsp;&nbsp;&nbsp;
			@endif
			{{ HTML::link('admin/delUser/'.$teacher->id,'删除') }} &nbsp;&nbsp;&nbsp;
			{{ HTML::link('admin/delTeacher/'.$teacher->id,'删除教师身份') }}
		</td>
	</tr>	
	@endforeach
	<tr>
		<td></td>
		<td colspan="4" class="page">{{ $teachers->links() }}</td>
	</tr>
</table>
@if($type == 2)
	<table>
	  	<tr>
	    	<th>管理员编号</th>
	    	<th>登录邮箱</th>
	    	<th>操作</th>
	  	</tr>
	  	@foreach($admins as $admin)
		<tr>
			<td>{{$admin->id}}</td>
			<td>{{$admin->loginName}}</td>
			<td >
				{{ HTML::link('admin/downToU/'.$admin->id,'删除管理员') }}
			</td>
		</tr>	
		@endforeach
		<tr>
			<td></td>
			<td colspan="2" class="page">{{ $admins->links() }}</td>
		</tr>
	</table>
@endif
	
	
@stop
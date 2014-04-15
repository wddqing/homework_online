<!DOCTYPE HTML>
<html>
	<head>
		<title>
			@section('title')
				This is title!
			@show
		</title>
		@section('js')
			{{ HTML::script('static/js/jquery-1.7.2.js'); }}
		@show
	</head>
	<body>
		<div>
			@yield('content')
		</div>
	</body>
</html>
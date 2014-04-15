<!DOCTYPE HTML>
<html>
	<head>
		<title>
			@section('title')
				This is title!
			@show
		</title>
		@section('js')
			<script type="text/javascript" src="../../public/static/js/jquery-1.7.2.js"></script>
		@show
	</head>
	<body>
		<div>
			@yield('content')
		</div>
	</body>
</html>
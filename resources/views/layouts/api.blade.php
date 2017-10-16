<html>
<head>
	<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			overflow: hidden;
			background:  rgba(0, 0, 0, .6);
			height: 100%;
		}
		.contact-form{
			border:10px solid #464646;
			background-color: #fff;
			padding: 24px;
			box-shadow: 1px 5px 5px 0px rgba(117,117,117,1);
			-webkit-box-shadow: 1px 5px 5px 0px rgba(117,117,117,1);
			-moz-box-shadow: 1px 5px 5px 0px rgba(117,117,117,1);
		}
		.vcontainer{
			display: table;
			height: 100%;
		}
		.vrow{
			display: table-cell;
    		vertical-align: middle;
		}
	</style>
</head>
<body>
<div class="container vcontainer">
	<div class="row vrow">
		@yield('content')
	</div>
</div>

</body>
</html>
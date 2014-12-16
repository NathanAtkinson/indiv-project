<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui" />
	<title>Pizza Picker</title>
	
	<!-- Main CSS -->
	<link rel="stylesheet" href="/node_modules/normalize.css/normalize.css">
	<link rel="stylesheet" href="/bower_components/ReptileForms/dist/reptileforms.min.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	
	<!-- Bring in map API from google -->
	<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places"> </script>

	<!-- Modernizr -->
	<script src="/bower_components/modernizr/modernizr.js"></script>

	<!-- Font -->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	
</head>
<body>

	<!-- <div class="page"> -->
		<?php echo $primary_header; ?>
		<?php echo $main_content; ?>
		<?php echo $primary_footer; ?>
	<!-- </div> -->

	<!-- Include Common Scripts -->
	<script src="/bower_components/jquery/dist/jquery.js"></script>
	<script src="/bower_components/ReptileForms/dist/reptileforms.js"></script>

	<!-- Get JS -->
	<script>var app = {};app.settings=<?php echo Payload::get_settings(); ?>;</script>
	
	<!-- Main JS -->
	<script src="/js/main.js"></script>

</body>
</html>
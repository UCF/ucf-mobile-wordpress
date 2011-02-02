<!DOCTYPE html>
<html lang="en-US">
	<head>
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
		<link href="http://cdn.ucf.edu/webcom/-/css/blueprint-ie.css" rel="stylesheet" media="screen, projection">
		<![endif]-->
		
		<title></title> 
		<meta name="description" content="">
		<meta charset="utf-8">
		<link rel="shortcut icon" href="<?=PROVOST_IMG_URL?>/favicon.ico">
		<?=provost_create_stylesheet('')?>
		<?php thematic_create_stylesheet();?>
	</head>
	<!--[if IE 7 ]><body class="ie7 ie"><![endif]-->
	<!--[if IE 8 ]><body class="ie8 ie"><![endif]-->
	<!--[if IE 9 ]><body class="ie9 ie"><![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--><body><!--<![endif]-->
		<?php the_post();?>
		<div id="updates">
			<h1><?php the_title();?></h1>
			<?php the_content();?>
		</div>
		
		<!-- Footer Scripts -->
		<script src="http://universityheader.ucf.edu/bar/js/university-header.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.ucf.edu/webcom/-/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.ucf.edu/webcom/-/js/jquery-browser.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.ucf.edu/webcom/-/js/jquery-uniform.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.ucf.edu/webcom/-/js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
		<![endif]-->
		<?php ob_start();
		thematic_doctitle();
		thematic_show_description();
		thematic_show_robots();
		thematic_canonical_url();
		thematic_create_stylesheet();
		thematic_head_scripts();
		cleanup(ob_get_clean(), 2);?>
	</head>
	<?=thematic_body()?>
		<div class="container">
			<div id="header" class="span-24 last">
				<h1 class="span-12 brand"><span class="standout">UCF</span>Mobile</h1>
				<div class="span-12 last url"><a href="/home">m.ucf.edu</a></div>
			</div>
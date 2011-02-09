<!DOCTYPE html>
<html lang="en-US">
	<head>
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
		<![endif]-->
		
		<title><?php the_title()?></title>
		<?php thematic_create_contenttype();?>
		<meta name="description" content="Updates from the Office of the Provost at the University of Central Florida.">
		<link rel='stylesheet' type='text/css' href='http://universityheader.ucf.edu/bar/css/bar.css' media='all' />
		<!-- Template CSS -->
		<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/webcom-template.css' media='screen, projection' />
		<link rel="shortcut icon" href="<?=PROVOST_IMG_URL?>/favicon.ico">
		<?php thematic_create_stylesheet();?>
	</head>
	<!--[if IE 7 ]><body class="ie7 ie"><![endif]-->
	<!--[if IE 8 ]><body class="ie8 ie"><![endif]-->
	<!--[if IE 9 ]><body class="ie9 ie"><![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--><body><!--<![endif]-->
		<?php the_post();?>
		<div id="updates">
			<div id="header">
				<h1>Provost&#146;s Update</h1>
				<div class="date"><?=date('l, F j, Y', strtotime($post->post_date))?></div>
				<div class="end"><!-- --></div>
			</div>
			
			<div id="content">
				<?php the_content();?>
			</div>
			
			<div id="sidebar">
				<div id="tony-waldrop">
					<img src="<?=PROVOST_IMG_URL?>/tony-waldrop.jpg" alt="Tony Waldrop">
					<div class="name">Tony G. Waldrop, Ph.D.</div>
					<div class="title">Provost and Vice President for Academic Affairs</div>
				</div>
				<div id="feedback">
					<h2>Contact&nbsp;the&nbsp;Provost</h2>
					<a href="#">For questions or comments</a>
				</div>
			</div>
			<div class="end"><!-- --></div>
			
			<div id="footer">
				<ul>
					<li class="first">University of Central Florida</li>
					<li>&bull; 4000 Central Florida Blvd</li>
					<li>&bull; Orlando, FL 32816-0065</li>
				</ul>
				<div class="end"><!-- --></div>
				<a href="http://provost.ucf.edu">http://provost.ucf.edu</a>
			</div>
		</div>
		
		<!-- Footer Scripts -->
		<script src="http://universityheader.ucf.edu/bar/js/university-header.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
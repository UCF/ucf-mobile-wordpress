<?php disallow_direct_load('footer.php');?>
		</div>
		
		<?php
		// action hook for placing content above the footer
		thematic_abovefooter();
		?>
		<div class="span-24 last" id="footer">
			<div class="span-24 last">
				<?=preg_replace(
					'/<li[^>]*>([^<]*<[^>]+>[^<]+<[^>]+>)<\/li>[\s]*<\/ul>/',
					'<li class="last">$1</ul>',
					wp_nav_menu(array('container_class' => 'menu', 'echo' => False,))
				)?>
			</div>
			<div class="span-12">
				<a id="ucf-logo" href="http://www.ucf.edu"><img src="<?=PROVOST_IMG_URL?>/sfo-stacked.jpg" alt="ucf" /></a>
			</div>
			<div class="span-12 last text">
				<p>Site Maintained by the Office of the Provost and Vice President for<br />Academic Affairs.</p>
				<p>&copy; University of Central Florida
			</div>
		</div>
		<?php
			// action hook for placing content below the footer
			thematic_belowfooter();
		?>
	</div>
	<?php
		// action hook for placing content before closing the BODY tag
		thematic_after();
	?>
</body>
</html>
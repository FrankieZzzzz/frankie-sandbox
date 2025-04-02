<?php
	global
	$stylesheet_directory_uri,
	$back_to_top,
	$site_social_share,
	$site_super_footer_option,
	$site_social_media_option,
	$site_copyright_year_option,
	$site_copyright_option,
	$site_copyright_radii_option,
	$site_footer_disclaimer;

?>

<footer id="site-footer">
	<?php
		// Enable Super Footer
		if (isset($site_super_footer_option) && $site_super_footer_option){
			get_template_part('super-footer');
		}
	?>
	<div class="bottom-footer">
		<div class="container-lg">
			<div class="row">
				<div class="col-md-8 bottom-footer__left d-md-flex justify-content-md-start">
					<p class="bottom-footer__left__copyright">
						<?php if (isset($site_copyright_year_option) && $site_copyright_year_option) : ?>
							&copy; <?php echo date("Y "); ?>
						<?php endif; ?>
						<?php echo $site_copyright_option;?>
						<?php if (isset($site_copyright_radii_option) && $site_copyright_radii_option) : ?>
							<span class="bottom-footer__left__brand"> Designed &amp; developed by <a href="https://innermost.digital/" title="innermost digital" target="_blank">innermost.digital</a></span>
						<?php endif; ?>
					</p>
				</div>
				<div class="col-md-4 bottom-footer__right">					
					<?php
						echo '<div class="justify-content-md-end d-md-flex">';
						if (isset($site_social_media_option) && in_array('bottomfooter', $site_social_media_option)) {
							// see site_social_media.php
							echo do_shortcode('[social_media_bar]');
						}
						if(has_nav_menu( 'footer-menu' )) {
							echo '<div class="navbar-expand justify-content-md-end d-flex">';
							$footer_nav_array = array(
								'theme_location' => 'footer-menu',
								'container' => 'nav',
								'container_class' => 'bottom-footer__right__menu navbar-collapse collapse',
								'container_aria_label' => 'Footer Menu',
								'menu_class' => 'navbar-nav',
								'depth' => 1,
								'walker' => new BootstrapWalker()
							);
							wp_nav_menu( $footer_nav_array );
							echo '</div>';
						}
						echo '</div>';
						if (isset($site_footer_disclaimer) && $site_footer_disclaimer) {
							echo '<div class="justify-content-md-end d-md-flex"><p class="bottom-footer__right__disclaimer">' . $site_footer_disclaimer . '</p></div>';
						}
					?>
				</div>
			</div><!-- .row -->

		</div>
	</div>

    <?php get_template_part('searchform-modal'); ?>

</footer><!-- #site-footer -->

</div><!-- end of #site-content -->

</main><!-- end of main#main-content.site-body -->

<?php // Enable Social Share Sidebar
	if (isset($site_social_share) && $site_social_share){
		get_template_part('functions/theme_social_share');
	}
?>

<?php // Back to top option
	if (isset($back_to_top) && $back_to_top) :?>
	<a href="#top" id="back-to-top" class="btn" title="Back to top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
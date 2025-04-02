<?php
	global
	$stylesheet_directory_uri,
	$back_to_top,
	$site_super_footer_option,
	$site_social_media_option,
	$site_copyright_year_option,
	$site_copyright_option,
	$site_copyright_radii_option,
	$site_footer_disclaimer;

?>
</div><!-- end of site-body -->

<div class="mobile-menu-overlay"></div>

<footer id="site-footer">
	<?php
		// Enable Super Footer
		if (isset($site_super_footer_option) && $site_super_footer_option) {
			get_template_part('super-footer');
		}
	?>
	<div class="bottom-footer">
		<div class="container-lg">
			<div class="row">
				<div class="col">
					<?php if (isset($site_copyright_year_option) && $site_copyright_year_option) : ?>
						&copy; <?php echo date("Y "); ?>
					<?php endif; ?>
					<?php echo $site_copyright_option;?>
					<?php if (isset($site_copyright_radii_option) && $site_copyright_radii_option) : ?>
						<span class="bottom-footer__left__brand"> Designed &amp; developed by <a href="https://innermost.digital/" title="innermost digital" target="_blank">innermost.digital</a></span>
					<?php endif; ?>
				</div>
			</div><!-- .row -->

		</div>
	</div>
</footer><!-- #site-footer -->

</div><!-- #site-body -->

<?php if (isset($back_to_top) && $back_to_top) :?>
	<a href="#top" id="back-to-top" class="btn" title="Back to top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
<?php endif; ?>

<div id="privacy-popup"> 
    <div class="consent-info">
        <div>
            <p>We use cookies and other technologies to understand how you use our site and to improve your experience and provide you with valuable content. By continuing on this website, you consent to the use of these cookies. For more information and to opt-out of cookies, visit the cookie section of our <a href="/privacy-policy/">privacy policy</a>.</p>
            <button id="privacy-btn" class="vc_btn3 vc_btn3-color-white">Close</button>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
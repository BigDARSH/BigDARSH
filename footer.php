<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage DGI_Builder
 * @since DGI Builder 1.0
 */
?>
	</div><!-- .site-content -->		
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php //if ( is_home() && ! is_front_page() || is_single() || is_page()){ ?>
		<div class="footer-top">
			<?php
				if(function_exists('dgibuilder_contact')){
					dgibuilder_contact();
				}
			?>
		</div><!--.footer-top-->
		<?php //} ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="site-info">
				<?php 
					$copyright_content = get_theme_mod('copyright_content','(C) 2019, All Rights Reserved. Designed & Developed by <a href="#">Template.net</a>');
						if(!empty($copyright_content)) { ?>								
								<?php echo $copyright_content; ?>								
				<?php } ?>
				</div>
			</div>
		</div><!--.footer-bottom-->
	</footer><!-- .site-footer -->
	<a href="#" id="back-to-top" title="Back to top">&uarr;</a>
</div><!-- .site -->
<div class="overlay"></div>
<?php wp_footer(); ?>
</body>
</html>

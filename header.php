<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage DGI_Builder
 * @since DGI Builder 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" style ="">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) :?>
        <?php if (!empty(get_theme_mod('site_icon'))): ?>
            <link rel="shortcut icon" href="<?php echo esc_url(str_replace(array('http:', 'https:'), '', get_theme_mod('site_icon'))); ?>" type="image/x-icon" />
        <?php endif; ?>    	
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<?php
	$body_font = get_theme_mod('google_font_body','Playfair Display');
	if($body_font){
		$body_font = explode(":",$body_font)[0];
	}
?>
<body <?php body_class(); ?> style="font-family: '<?php echo $body_font ?>'">
<div id="page" class="site">
	<div class="site-inner">
		<?php
		$hd_font = get_theme_mod('google_font_header','Poppins');
			if($hd_font){
				$hd_font = explode(":",$hd_font)[0];
			}
	?>
		<header id="masthead" class="site-header" style="font-family: '<?php echo $hd_font ?>'">
			<div class="site-header-main">
				<div class="container">
					<div class="row">
						<div class="site-branding col-3">
							<?php 
								if(function_exists('get_header_logo')){
									get_header_logo();
								}
							?>
						</div><!-- .site-branding -->

						<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) ) : ?>
							

							<div id="site-header-menu" class="site-header-menu col-9">
								<div id="menu-toggle" class="menu-toggle" >									
									<i class="fa fab fa-bars"></i>
								</div> 
								<?php if ( has_nav_menu( 'primary' ) ) : ?>
									<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'dgibuilder' ); ?>">
										<div class="main-menu-container">
											<h3 class="menu-title">Menu</h3>
											<div class="close-menu-mobile">
												<i class="fa fal fa-times"></i>
											</div>
											<?php
												wp_nav_menu(
													array(
														'theme_location' => 'primary',
														'menu_class' => 'primary-menu',
													)
												);
											?>
										</div>
									</nav><!-- .main-navigation -->
								<?php endif; ?>								
							</div><!-- .site-header-menu -->
						<?php endif; ?>
					</div>
				</div><!-- .site-header-main -->
			</div>
			<div class="banner-top"> 				
				<?php if(is_front_page()){ ?>
					<?php
						if(function_exists('dgibuilder_home_banner')){
							dgibuilder_home_banner();
						}
					?>
															
				<?php } //else{?>
					<?php
						// if(function_exists('dgibuilder_get_header_banner')){
							// dgibuilder_get_header_banner();
						// }
					//}?>
			</div>
				
		</header><!-- .site-header -->
	</div>
	<div id="content" class="site-content">

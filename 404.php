<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage DGI_Builder
 * @since DGI Builder 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">
				<section class="error-404 not-found">
					<header class="page-header">
						
						<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'dgibuilder' ); ?></h1>
						<h1 class="text-num">404</h1>
					</header><!-- .page-header -->
					<div class="page-content">
						<p><?php _e( 'We are sorry, but the page you request was not found', 'dgibuilder' ); ?></p>					
					</div><!-- .page-content -->
					<div class="search-form">
						<?php get_search_form(); ?>
					</div>
				</section><!-- .error-404 -->
			</div>
		</main><!-- .site-main -->

		<?php get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

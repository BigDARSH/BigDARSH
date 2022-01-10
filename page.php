<?php get_header(); ?>
<div id="primary" class="content-area">
	<div class="container">

		<?php 
				// global $post;			
				$current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
				$args = array(
					'posts_per_page'   => get_option( 'posts_per_page' ),
					'orderby'          => 'date',
					'order'            => 'DESC',
					'post_type'        => 'post',
					'post_mime_type'   => '',
					'author'       => '',
					'author_name'      => '',
					'post_status'      => 'publish',
					'suppress_filters' => true ,
					'paged'            => $current_page,
				);
				$wp_query = new WP_Query( $args );
			?>
		<div class="top-blog">
			<?php if (get_theme_mod('blog_page_title','Blog Articles')) : ?>
			<h1 class="page-title">
				<?php echo get_theme_mod('blog_page_title','Blog Articles'); ?>
			</h1>
			<?php endif; ?>
		</div>
		<?php if ( $wp_query->have_posts() ) : ?>
		<div class="load-item_v1 blog-post-list">
			<?php
					while ($wp_query->have_posts()) : $wp_query->the_post();
						get_template_part( 'template-parts/content', '' );
					endwhile; ?>
		</div>
		<?php
			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
			<?php
				$makeupartists_show_loadmore = get_theme_mod('show_loadmore_blog','no');   
			?>
			<?php if ($makeupartists_show_loadmore == 'yes'): ?>
			<?php 
				if ($wp_query->max_num_pages > 1) : ?>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 load-more-container">
					<?php if (get_next_posts_link()) { ?>
					<div class="load-more">
						<div class="load_more_button">
							<p data-paged="<?php echo esc_attr($current_page) ?>" data-totalpage="<?php echo esc_attr($wp_query->max_num_pages) ?>">
								<?php echo get_next_posts_link(__('Load more', 'makeupartists')); ?>
							</p>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php endif; ?>
			<?php else:?>
			<div class="pagination-content text-center">
				<?php makeupartists_pagination(); ?>
			</div>
			<?php endif; ?>
			<?php 
				wp_reset_postdata(); 
				wp_reset_query();
			?>
	</div>
</div>
<!-- End primary -->
<?php get_footer(); ?>
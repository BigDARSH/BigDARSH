<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage DGI_Builder
 * @since DGI Builder 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'single' ); ?>
		<?php endwhile; // End of the loop. ?>
		<div class="col-12">
			<?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                //comments_template();
            }
            ?>
				<div class="author-info-wrapper d-flex">
					<div class="author-avatar">
						<img src="<?php echo get_avatar_url(get_the_author_meta('ID'),array('size'=>152));?>" />
					</div>
					<div class="author_info">
						<p class="written_by">
							<?php _e('Article Written by');?>
						</p>
						<h2>
							<?php
                        if(!empty(get_the_author_meta('first_name')) || !empty(get_the_author_meta('last_name'))){
                            echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name');
                        }else{
                            echo get_the_author_meta('display_name');
                        }?>
						</h2>
						<p class="desc">
							<?php echo get_the_author_meta('description');?>
						</p>
						<ul class="list-social-author-profile">
							<li><a href="<?php echo get_user_meta(get_the_author_meta('ID'),'twitter',true);?>"><i class="fab fa-twitter-square"></i></a></li>
							<li><a href="<?php echo get_user_meta(get_the_author_meta('ID'),'facebook',true);?>"><i class="fab fa-facebook-square"></i></a></li>
							<li><a href="<?php echo get_user_meta(get_the_author_meta('ID'),'instagram',true);?>"><i class="fab fa-instagram"></i></a></li>
							<li><a href="<?php echo get_user_meta(get_the_author_meta('ID'),'google',true);?>"><i class="fab fa-google-plus"></i></a></li>
							<li><a href="<?php echo get_user_meta(get_the_author_meta('ID'),'linkedin',true);?>"><i class="fab fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
		</div>
		<?php
        if(function_exists('barlounge_get_relatedpost')){
            barlounge_get_relatedpost();
        }
        ?>
	</div>

</div>
<!-- End primary -->
<?php get_footer(); ?>
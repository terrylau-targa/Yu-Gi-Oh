<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package NewsAnchor
 */

get_header(); ?>
<div id="primary" class="content-area col-md-9">
	
	<!--Main Article-->
	<article class="main">
		<div class="header-wrapper">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php endwhile; // end of the loop. ?>
			<div class="feature-img">
				<?php 
					if(has_post_thumbnail()){
						the_post_thumbnail('large'); 
					}
				?>
			</div>
		</div>
		<div class="content-wrapper">
			<!-- If plugin exist -->
			<?php if ( class_exists( 'ACF' ) ) : ?>
				<?php 
				
				$counter = 1;

				while ( have_rows('header_and_content') ) :
					the_row();
					// Get the row layout.
					$layout = get_row_layout();

					if ( $layout == 'content_block' ):
						$heading = get_sub_field('heading');
						$paragraph = get_sub_field('paragraph');

						echo '<h2>' . $heading . '</h2>';
                        echo '<p>' . $paragraph . '</p>';
					endif;

				endwhile;

				?>
			<?php endif; ?>
		</div>
	</article>

</div><!-- #primary -->
<?php get_footer(); ?>
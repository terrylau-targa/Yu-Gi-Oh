<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package NewsAnchor
 */

get_header(); ?>
<div id="primary" class="content-area col-md-9">
	
	<!--Main Article-->
	<article class="main">
		<div class="header-wrapper">
			<div>
				<?php get_template_part( 'template-parts/content', 'picksSection' ); ?>
			</div>
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
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
		</div>
	</article>

</div><!-- #primary -->
<?php get_footer(); ?>

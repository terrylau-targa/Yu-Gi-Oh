<?php
/**
 * Carousel template
 *
 * @package NewsAnchor
 */

	//Template
	if ( ! function_exists( 'newsanchor_carousel' ) ) {
		function newsanchor_carousel() {
		    if ( ( get_theme_mod('carousel_display_front', '1') && is_front_page() ) || ( get_theme_mod('carousel_display_archives', '1') && ( is_home() || is_archive() ) ) || ( ( get_theme_mod('carousel_display_singular') && is_singular() ) ) ) {

		       	//Get the user choices
		        $number     = ( ! empty( $number ) ) ? intval( $number ) : 6;
		        $cat        = ( ! empty( $cat ) ) ? intval( $cat ) : '';
		        $speed 		= ( ! empty( $speed ) ) ? absint( $speed ) : '4000';

				$args = array(
					'posts_per_page'		=> $number,
					'post_status'   		=> 'publish',
		            'cat'                   => $cat,
		            'ignore_sticky_posts'   => true
				);
				$query = new WP_Query( $args );	
				if ( $query->have_posts() ) {
				?>
				<div class="roll-posts-carousel col-md-12" id="carousel" data-items="<?php echo absint($number); ?>" data-speed="<?php echo absint($speed); ?>">
					<div class="owl-carousel">
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							    <div class="item">
									<div class="thumb-wrapper">
										<?php if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-carousel'); ?></a>
										<?php else : ?>
											<a href="<?php the_permalink(); ?>"><?php echo '<img src="' . get_stylesheet_directory_uri() . '/images/placeholder.png"/>'; ?></a>
										<?php endif; ?>
									</div>
								    <div class="content-text">
										<div class="meta-wrapper">
											<div class="carousel-category"><?php get_primary_category(); ?></div>
											<div class="carousel-date"><?php echo get_the_date('d M Y'); ?></div>
										</div>
										<?php // the_title( sprintf( '<h4 class="carousel-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
										<h4 class="carousel-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo post_title_teaser(); ?></a></h4>
									</div>
							    </div>
						<?php endwhile; ?>
					</div>
				</div>

				<?php }
				wp_reset_postdata();
			}
		}
	}
<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package NewsAnchor
 */
?>

<!-- If plugin exist -->
<?php
if ( class_exists( 'ACF' ) ) :

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

endif; 
?>
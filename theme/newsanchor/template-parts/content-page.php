<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package NewsAnchor
 */
?>

<!-- If plugin exist -->
<div class="toc">
	<?php 
		if ( class_exists( 'ACF' ) ) :
			$counter = 0;

			while ( have_rows('header_and_content') ) :
				the_row();
				$counter++;

				if ($counter > 0) :
				endif;

				// Get the row layout.
				$layout = get_row_layout();
		
				if ( $layout == 'content_block' ):
					$heading = get_sub_field('heading');
					echo '<div class="toc-item"><span>' . $counter . '</span><p>' . $heading . '</p></div>';
				endif;
			endwhile;
		
		endif; 
	?>
</div>

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
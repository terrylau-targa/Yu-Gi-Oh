<?php

class NewsAnchor_Recent_Posts extends WP_Widget {

// constructor
	function __construct() {
		$widget_ops = array('classname' => 'newsanchor_recent_posts_widget', 'description' => __( 'Display your site&#8217;s recent posts with thumbnails.', 'newsanchor') );
        parent::__construct(false, $name = __('NewsAnchor: Recent Posts', 'newsanchor'), $widget_ops);
		$this->alt_option_name = 'newsanchor_recent_posts_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
	?>

	<p>
	<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e('Title', 'newsanchor'); ?></label>
	<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'newsanchor' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

	<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'newsanchor' ); ?></label></p>
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['newsanchor_Recent_Posts']) )
			delete_option('newsanchor_Recent_Posts');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('newsanchor_Recent_Posts', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'newsanchor_Recent_Posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'newsanchor' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<div class="recent-post clearfix">
					<?php if ( has_post_thumbnail()) : ?>
						<div class="thumb col-md-4">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
						</div>
					<?php endif; ?>
					<?php if ( has_post_thumbnail()) : ?>
						<?php echo '<div class="col-md-8">'; ?>
					<?php else : ?>
						<?php echo '<div class="col-md-12">'; ?>
					<?php endif; ?>
					<h3><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
					<?php if ( $show_date ) : ?>
						<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date(); ?></span></div>
					<?php else : ?>
						<?php echo '</div>'; ?>
					<?php endif; ?>
				</div>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
	<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'newsanchor_Recent_Posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}
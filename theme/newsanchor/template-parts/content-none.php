<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package NewsAnchor
 */
?>

<section class="no-results not-found">
	<div class="content">
			<div class="section ad-section">
				<?php if (function_exists ('adinserter')) echo adinserter (3); ?>
			</div>

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'newsanchor' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<div class="page-header">
				<div class="breadcrumb">
					<a href="/">Home</a>
					<span class="breadcrumb-span"></span>
					<span>Search Results</span>
				</div>
				<h2 class="page-title search-title"><?php printf( esc_html__( 'Search Results for: %s', 'newsanchor' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				<p><?php esc_html_e( 'Sorry, no content matched your criteria. Need a new search?', 'newsanchor' ); ?></p>
			</div>

			<?php custom_search_from(); ?>

			<div class="section ad-section">
				<?php if (function_exists ('adinserter')) echo adinserter (3); ?>
			</div>

			<div class="section our-picks">
				<div class="section-title"><span>Our Picks</span></div>
				<?php rand_post(8); ?>
			</div>

		<?php else : ?>

			<div class="page-header">
				<div class="breadcrumb">
					<a href="/">Home</a>
					<span class="breadcrumb-span"></span>
					<span>Not Found</span>
				</div>
				<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'newsanchor' ); ?></h2>
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'newsanchor' ); ?></p>
			</div><!-- .page-header -->

			<?php custom_search_from(); ?>

			<div class="section ad-section">
				<?php if (function_exists ('adinserter')) echo adinserter (3); ?>
			</div>

			<div class="section our-picks">
				<div class="section-title"><span>Our Picks</span></div>
				<?php rand_post(8); ?>
			</div>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
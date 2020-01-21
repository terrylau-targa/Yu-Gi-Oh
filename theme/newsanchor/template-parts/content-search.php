<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package NewsAnchor
 */
?>

<div class="article">
    <div class="content">
        <div class="thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail('thumb-carousel'); ?>
                <?php else : ?>
                <?php echo '<img src="' . get_stylesheet_directory_uri() . '/images/placeholder.png"/>'; ?>
                <?php endif; ?>
            </a>
        </div>

        <div class="data">
            <div class="article-meta">
                <?php get_primary_category(); ?>
                <div class="published">
                    <?php the_date(); ?>
                </div>
            </div>
            <div class="article-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @package NewsAnchor
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-info">
        <p class="post-date"></p>
        <h1 class="post-title"><?php the_title(); ?></h1>
    </div>
    <div class="promote-wrapper">
        <!-- If plugin exist -->
        <?php if ( class_exists( 'ACF' ) ) : ?>
        
        <?php if (have_rows('product_name_and_content')) : ?>

        <!-- Promote product -->
        <div class="promote-product">
            <div id="pre-picks" class="picks-btn" style="display: none;"><</div>
            <!-- Check custom group -->
            <?php 
            while ( have_rows('product_name_and_content') ):
                the_row();

                $picks = get_sub_field_object('ranking_label');
                $picks_value = $picks['value'];
                $picks_label = $picks['choices'][$picks_value];

                // if product have ranking value
                if ( $picks_value != null ) :
                    $name = get_sub_field('product_name');
                    $images = get_sub_field('product_image');
                    $link = get_sub_field('product_link');
                    $ranking = get_sub_field('ranking_stars');

                    //Display item HTML
                    ?>
                    <div class="item">
                        <div class="promo-label">
                            <svg width="25" class="svg-inline--fa fa-crown fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5.4 5.1.8 7.7.8 26.5 0 48-21.5 48-48s-21.5-48-48-48z"></path></svg>
                            <p><?php echo $picks_label; ?></p>
                        </div>
                        <div class="product-image"><?php echo '<img src="' . esc_url($images[0]['sizes']['thumb-large']) . '" alt="' . esc_url($images[0]['alt']) . '" />'; ?></div>
                        <h2 class="product-name"><?php echo $name; ?></p>
                        <div class="star">
                            <?php 
                            for ($i = 0; $i < $ranking; $i++) :
                                echo '<i class="fas fa-star"></i>';
                            endfor;
                            ?>
                        </div>
                        <a href="<?php echo $link; ?>">
                            <div class="check-price">Check Latest price<i class="fas fa-arrow-right"></i></div>
                        </a>
                    </div>
                    <?php
                endif;

            endwhile;
            ?>
            <div id="next-picks" class="picks-btn" style="display: none;">></div>
            
            <?php endif; ?>
        </div>

        <!-- End if plugin -->
        <?php endif; ?>

        <section class="post-footer">
            <p class="post-author"><?php the_author(); ?> </p>
            <aside class="social-media"><?php echo social_platform(); ?></aside>
        </section>
    </div>

    <section class="post-contents">
        <div id="content-btn" class="close">Show Contents<i class="fas fa-chevron-down"></i></div>
        <div class="contents-block" id="contents-block">
            <div>Contents</div>
            <div class="contents-wrapper">
                <ul>
                    <!-- Check custom group -->
                    <?php
                    $counter = 0;
                    while ( have_rows('product_name_and_content') ):
                        the_row();
                        $name = get_sub_field('product_name');
                        echo '<li><span>' . $counter .'</span><span class="product-name">' . $name . '</span></li>';
                        $counter++;
                    endwhile;
                ?>
                </ul>
            </div>
        </div>
    </section>

    <div class="entry-content">
    <?php if ( class_exists( 'ACF' ) ) :
    $counter = 1;

    if ( have_rows('product_name_and_content') || have_rows('header_and_content') ) :
        while ( have_rows('product_name_and_content') || have_rows('header_and_content') ) :
            the_row();
            // Get the row layout.
            $layout = get_row_layout();

            //Check if product row
            if ( $layout == 'product_detail' ):
                $name = get_sub_field('product_name');
                $images = get_sub_field('product_image');
                $link = get_sub_field('product_link');
                $pro_contents = get_sub_field('product_content');
                ?>

                <div class="product-paragraph" data-link="<?php echo $link ?>">
                    <div class="product-header">
                        <div class="number"><?php echo $counter; ?></div>
                        <h2 class="product-name"><?php echo $name; ?></h2>

                        <?php if ( $images ): ?>
                        <span class="carousel-counter" data-productid="<?php echo $counter; ?>"></span>
                        <?php endif; ?>
                    </div>
                    <?php

                    $picks = get_sub_field_object('promotion');
                    $picks_value = $picks['value'];
                    $picks_label = $picks['choices'][$picks_value];

                    if ( $images ):
                        echo '<div class="product-images">';
                                    
                            // if product have promotion value
                            if ( $picks_value != null ) :
                                //Display item HTML
                                ?>
                                <div class="promo-label">
                                    <svg width="25" class="svg-inline--fa fa-crown fa-w-20" role="img" viewBox="0 0 640 512">
                                        <path fill="currentColor"
                                            d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5.4 5.1.8 7.7.8 26.5 0 48-21.5 48-48s-21.5-48-48-48z">
                                        </path>
                                    </svg>
                                    <p><?php echo $picks_label; ?></p>
                                </div>
                                <?php
                            endif;

                            echo '<div class="filter-mask"><a href="' . $link .'"><div>See More</div></a></div>';

                            echo '<div class="owl-carousel product-carousel" id="product-' . $counter .'">';
                            foreach ( $images as $image ) :
                                echo '<div class="items">';
                                    echo '<img src="' . esc_url($image['sizes']['product-preview']) . '" class="product-gallery-image" alt="' . esc_url($image['alt']) . '" />';
                                echo '</div>';
                            endforeach;
                            echo '</div>';
                        echo '</div>';
                    endif;

                    echo '<div class="check-price-wrapper"><a href="' .$link .'"><div class="check-price">Check Latest price<i class="fas fa-arrow-right"></i></div></a></div>';

                    if ( $pro_contents ) :
                        while ( have_rows('product_content') ) :
                            the_row();
                            $title = get_sub_field('product_content_title');
                            $content = get_sub_field('product_content_text');
                                    
                            if ( $title != '') :
                                echo '<h3>' . $title . '</h3>';
                            endif;
                            echo $content;
                        endwhile;
                    endif;

                ?>
                </div>

                <?php
                $counter++;

            //Check if content row
            elseif ( $layout == 'header_and_content' ) :
                $title = get_sub_field('heading');
                $content = get_sub_field('paragraph');

                if ( $title != '') :
                    echo '<h2>' . $title . '</h2>';
                endif;
                echo $content;
            endif;
                    
        endwhile;

        the_content();

    else :
        the_content();
    endif;
endif; ?>
    </div>
</article><!-- #post-## -->
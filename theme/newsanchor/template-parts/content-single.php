<?php
/**
 * @package NewsAnchor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-header">
		
		<?php 
			$category = get_the_category();
			$parent = get_ancestors($category[0]->term_id,'category');

			if (empty($parent)) {
				$parent[] = array($category[0]->term_id);
			}

			$parent = array_pop($parent);
			$parent = get_category($parent); 

			$categoriesChild = get_categories(
				array( 'parent' => $parent->term_id )
			);
				
			if (!is_wp_error($parent)) {
				// echo $parent->name;
			} else {
				echo $parent->get_error_message();
			}
		?>
		<div class="breadcrumb">
			<a href="/">Home</a>
			<span class="breadcrumb-span"></span>
			<?php 
			if ( $parent && $parent->name != 'Uncategorized' ) {
				?>
				<a class="parent-cat" href="<?php echo get_category_link($parent->term_id); ?>"><?php echo $parent->name; ?></a>
				<span class="breadcrumb-span"></span>
				<a class="primary-cat" href="<?php echo get_category_link($category[0]->term_id); ?>"><?php echo $category[0]->name; ?></a>
				<?php
			} else {
				?>
				<a class="primary-cat" href="<?php echo get_category_link($category[0]->term_id); ?>"><?php echo $category[0]->name; ?></a>
				<?php
			}
			?>
		</div>

		<?php 
			if (!is_front_page()) {
				the_title( '<h1 class="single-title">', '</h1>' ); 
				//echo '<h1 class="single-title">'  . post_title_teaser() . '</h1>';
			}
		?>

		<?php
		$fname = get_the_author_meta('user_firstname');
		$lname = get_the_author_meta('user_lastname');
		$dn = get_the_author_meta('display_name');
		$full_name = '';

		if( ! empty($fname) ){
			$full_name = $fname;
		} elseif ( ! empty($lname) ){
			$full_name = $lname;
		} elseif( empty($lname) && empty($fname) ) {
			$full_name = $dn;
		} else {
			//both first name and last name are present
			$full_name = "{$fname} {$lname}";
		}
		$authorID = get_the_author_meta( 'ID' );
		?>
		
		<div class="author-section-post">
			
			<div class="author-icon">
			<img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?> " class="avatar" alt="<?php echo get_the_author_meta( 'display_name' ); ?>" />
			</div>
			<div class="author-name-date">
				<div class="author-name">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo $full_name;?></a>
				</div>
				<div class="date"><p><?php echo get_the_date('d M Y'); ?></p></div>
			</div>
		</div>

		<?php if (get_theme_mod('hide_meta_single') != 1 ) : ?>
		<!-- <div class="meta-post">
			<?php newsanchor_posted_on(); ?>
		</div> -->
		<?php endif; ?>		
	</div><!-- .entry-header -->

	<div class="row">
		<div class="entry-content col-md-9" id="contents">
			
			<?php if (!wp_is_mobile()) : ?>
			<div class="share-floating">
				<div class="media_icon">
					<?php social_media_white(); ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="feature-img">
				<?php 
					if(has_post_thumbnail()){
						the_post_thumbnail(); 
					}
				?>
			</div>

			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newsanchor' ),
					'after'  => '</div>',
				) );
			?>

			<div class="content-wrap-flex">
		
				<?php if ( class_exists( 'ACF' ) ) {

					// check if the flexible content field has rows of data
					if( have_rows('title_&_content_draggable') ):
						?>
						<div id="toc">
							<div class="toc-nav">
								<div class="toc-title">Table of Contents</div>
								<div class="toc-toggle"></div>
							</div>
							<div class="contents-menu" id="toc_item">
								<?php
									$toc_item = 0;
									while ( have_rows('title_&_content_draggable') ) : the_row();

										if( get_row_layout() == 'title_&_description'):
											if (get_sub_field('title') != "") :
												$toc_item += 1;
												if ($toc_item < 10) :
												?>
													<div class="item">
														<div class="title-link" data-title="<?php echo $toc_item; ?>">
															<span>0<?php echo $toc_item; ?></span>
															<?php echo get_sub_field('title'); ?>
														</div>
													</div>
												<?php
												else :
												?>
													<div class="item">
														<div class="title-link" data-title="<?php echo $toc_item; ?>">
															<span><?php echo $toc_item; ?></span>
															<?php echo get_sub_field('title'); ?>
														</div>
													</div>
												<?php
												endif;
											endif;
										endif;

									endwhile;
								?>
							</div>
						</div>
						<?php
						$title_count = 0;

						// loop through the rows of data
						while ( have_rows('title_&_content_draggable') ) : the_row();

							if( get_row_layout() == 'title_&_description' ):
								$title_count += 1; ?>
								<div class="single-title-desc-wrap">
									<h2 class='content-title' id='title-<?php echo $title_count; ?>'><?php echo the_sub_field('title'); ?></h2>
									
									<?php
										/* filter unexpected string */
										$arr = array(
											'<img id="hzDownscaled" style="position: absolute; top: -10000px;" />' => "",
											"<img id=\"hzDownscaled\" style=\"position: absolute; top: -10000px;\" />" => '',
										);
										
										$editorStr = strtr(get_sub_field('editor'),$arr) ;

										echo $editorStr;

									?>
									<?php //the_sub_field('editor'); ?>

								</div>

							<?php elseif( get_row_layout() == 'video' ):  ?>
								<div class="single-video-wrap">
									<iframe width="420" height="315" src="https://www.youtube.com/embed/<?php echo the_sub_field('youtube_id'); ?>"> </iframe>
								</div>
							<?php elseif( get_row_layout() == 'tabs' ): 

								if( have_rows('tab_article') ):

									?>
									<div class="tabs"><div class="tabs-nav">
									<?php
									$count = 0;
									// loop through the rows of data
									while ( have_rows('tab_article') ) : the_row();
										$count+=1;
										// display a sub field value
										?>
											<div class="tabs-link" data-tab="tab-<?php echo $count; ?>">
												<div class="tab-item" id="tab-item">
													<div><?php echo the_sub_field('title_tab'); ?></div>
												</div>
											</div>
										<?php
					
									endwhile;
					
									?></div><div class="tabs-stage"><?php
					
									$count2 = 0;
									while ( have_rows('tab_article') ) : the_row();
										$count2+=1;
										// display a sub field value
										?>
										<div id="tab-<?php echo $count2; ?>">
											<?php
											$editorStr = get_sub_field('content_tab');
												
											$editorStr = preg_replace('/(<img src="https:\/\/web.archive.org\/[^>]+\/>)/', '', $editorStr);
											$editorStr = preg_replace('/(<img class="no-display appear" src="https:\/\/old.facts.net\/[^>]+\/>)/', '', $editorStr);	
		
											echo $editorStr;
											?>
									
											<?php //echo the_sub_field('content_tab'); ?>
										</div>
										<?php
					
									endwhile;
					
									?></div></div>
		
									<?php

									
					
								else :
					
								// no rows found
					
								endif;

							endif;

						endwhile;

					else :

						// no layouts found

					endif;
					}
				?>
			</div>
			<div class="share-action">
				<p>Share this Fact: </p>
				<div class="media_icon">
					<?php social_media_white(); ?>
				</div>
			</div>
			
			<?php echo do_shortcode( '[adinserter name="After content"]' ); ?>

			<div class="view-comment" id="view_comment">View Comment</div>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

			<?php 
			//the_post_navigation(); 
			$next_post_url = get_permalink( get_adjacent_post(false,'',false)->ID );
			$previous_post_url = get_permalink( get_adjacent_post(false,'',true)->ID );	
			?>
			<div class="next-prev">
				<span class="prev">
					<a href="<?php echo $previous_post_url; ?>">Previous</a>
				</span>
				<span class="line"></span>
				<span class="next">
					<a href="<?php echo $next_post_url; ?>">Next</a>
				</span>
			</div>
		</div><!-- .entry-content -->
		<aside class="content-sidebar col-md-3">
			<?php 
				// related_post(); 
				// echo do_shortcode('[mailpoet_form id="1"]');
				 echo do_shortcode('[wpb_most_commented]'); 
			?>
		</aside>
	</div>

</article><!-- #post-## -->
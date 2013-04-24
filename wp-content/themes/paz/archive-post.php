			<?php if ( ! ajax () ) get_header () ; ?>				
            <div id="body-metadata" <?php body_class (); ?> data-title="<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?>" ></div>
				<div id="news-container">
					<?php query_posts(array('post_type'=>'post','posts_per_page'=>'4','paged' => get_query_var('paged'))); ?>
					<?php	while (have_posts() ) : the_post();
							?>
							<div class="single-new ">
								<div class="news-img float-left">
									<?php the_post_thumbnail('news-thumb'); ?>
								</div>
								<div class="news-txt float-left">
									<a href="<?php the_permalink()?>">
									<div class="news-title orange uppercase">
										<?php the_title(); ?>
									</div>
									</a>
									<div class="news-date">
										<?php echo get_the_date('d/m/Y'); ?>
									</div>
									<div class="news-excerpt museo-sans-300">
										<?php the_excerpt(); ?>	
									</div>
										<br />
									<a href="<?php the_permalink()?>">
									<div class="white txt-middle txt-center news-link uppercase">
										Leer más
									</div>
									</a>
								</div>
								<div class="clear"></div>
								<div class="news-borders">	
									<div class="orange-border float-left"></div>
									<div class="black-border float-left"></div>
									<div class="clear"></div>
								</div>
							</div>
						<?php endwhile;?>
						<?php wp_reset_query(); ?>
						
					<div class="news-navigation float-left">
						<div class="pagination-links float-left">
							<!--Pagination-->
							<?php 
								getCustomPagination();
							?>
						</div>
						<div class="page-arrows">
							<div class="next-page float-right"><?php next_posts_link('>>') ?></div>
							<div class="prev-page float-right"><?php previous_posts_link('<<') ?></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div><!-- #news-container -->
			<?php if ( ! ajax () ) get_footer() ; ?>
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
				<div id="single-news">
					<div id="single-news-txt" class="float-left">
							<?php if ( have_posts () ) : ?>
								<?php the_post () ; ?>
									<div class="single-news-title orange uppercase" >
										<?php the_title( );?>
									</div> 
									<div class="single-news-date">
										<?php echo get_the_date('d/m/Y'); ?>
									</div>
									<div class="single-news-content museo-sans-300">
										<?php the_content ( $post->ID ) ; ?>
										<br>
									</div>									
								  	<div id="single-news-navigator" >
										<div class="float-right">
											<?php next_post_link('%link', '<div class="single-news-next orange float-right">>></div> SIGUIENTE ENTRADA <div class="clear"></div>'); ?>
										</div>
										<div class="float-left">
											<?php previous_post_link('%link', '<div class="single-news-prev orange float-left"><<</div>ENTRADA ANTERIOR <div class="clear"></div>'); ?>
										</div>
										<div id="single-news-all">
											<a href="<?php echo get_post_type_archive_link( 'noticia' ); ?>">
												VER TODAS LAS ENTRADAS
											</a>	
										</div>
										<div class="clear"></div>
								  	</div>
							<?php endif ; ?>
						</div>
				  	</div>
				  	<div class="clear"></div>
			<?php if ( ! ajax () ) get_footer () ; ?>	
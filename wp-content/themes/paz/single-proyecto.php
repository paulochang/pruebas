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
				<div id="project-content" class="opened">
					<nav id="project-navigator" class="txt-center uppercase margin-center">
						<ul>
							<li data-slug="all" class="home-selector project-option inline-block txt-middle selected-project white pointer"> inicio</li>
							<?php getImageTypes(); ?>
						</ul>
					</nav>
					<div id="project-txt" class="float-left transition-width">
						<div id="slide-helper" >
							<?php if ( have_posts () ) : ?>
								<?php the_post () ; ?>
									<div class="project-title orange uppercase" ><?php the_title( );?>
									</div> 
									<br>
									<?php the_content ( $post->ID ) ; ?>
									<br>
									<div id="project-fields" class="museo-sans-300" >
										<?php
											$custom_fields = get_post_meta( $post->ID );
											foreach ( $custom_fields as $key => $value ) {
												$keyt = trim($key);
											    	if ( '_' == $keyt{0} )
											    	continue;
													echo '<p class="inline">'.$keyt . ': <div class="inline orange">' . $value[0] . '</div></p>';	
											}
											
										?>
									</div>
							<?php endif ; ?>
						</div>
				  	</div>
				  	<div id="project-slideshow" class="transition-width">	
				  		<div id="image-helper">
					  		<?php postimage('proyecto-slide',-1); ?>				  		
					  		<img class="next-arrow absolute pointer" src="<?php echo theme_url ( 'img/project/next.png' ); ?>">
					  		<img class="prev-arrow absolute pointer" src="<?php echo theme_url ( 'img/project/previous.png' ); ?>">
				  		</div>
				  	</div>
				  	<div class="clear"></div>
				</div>
			<?php if ( ! ajax () ) get_footer () ; ?>	
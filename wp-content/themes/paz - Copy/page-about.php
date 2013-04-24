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
			<div id="about-container">

						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div id="about-txt-content">
						<?php the_content() ?>
					</div>
					<div id="about-image">
						<?php the_post_thumbnail() ?>
					</div>	

						<?php endwhile; else: ?>
						<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
						<?php endif; ?>
					<div class="clear"></div>
			</div>
			<?php if ( ! ajax () ) get_footer() ; ?>
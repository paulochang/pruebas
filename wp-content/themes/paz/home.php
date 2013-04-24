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
				<div id="home-image-grid">
					<div id="home-image-container">
						<a class="filter-proyects" data-tax="nuevos" href="<?php echo home_url (); ?>"><div class="no-repeat pointer absolute transition-background-image" id="home-logo" ></div></a>
						<a href="<?php echo get_post_type_archive_link( 'proyecto' ); ?>" class="filter-proyects" data-tax="comercial"><div class="no-repeat pointer absolute transition-background-image" id="home-comercial"> </div></a>
						<a href="<?php echo get_post_type_archive_link( 'proyecto' ); ?>" class="filter-proyects" data-tax="encuentro"><div class="no-repeat pointer absolute transition-background-image" id="home-encuentro"> </div></a>
						<a href="<?php echo get_post_type_archive_link( 'proyecto' ); ?>" class="filter-proyects" data-tax="institucional"><div class="no-repeat pointer absolute transition-background-image" id="home-institucional"> </div></a>	
						<a href="<?php echo get_post_type_archive_link( 'proyecto' ); ?>" class="filter-proyects" data-tax="residencial"><div class="no-repeat pointer absolute transition-background-image" id="home-residencial"> </div></a>
						<a href="<?php get_starred_proyect(); ?>" data-tax="destacado"><div class="no-repeat pointer absolute transition-background-image" id="home-destacado"> </div></a>
						<a href="<?php echo get_post_type_archive_link( 'post' ); ?>"><div class="no-repeat pointer absolute transition-background-image" id="home-blog"> </div></a>
						<a href="<?php echo get_post_type_archive_link( 'noticia' ); ?>"><div class="no-repeat pointer absolute transition-background-image"  id="home-noticias"> </div></a>
						<a href="<?php echo home_url ('contact'); ?>"><div class="no-repeat pointer absolute transition-background-image" id="home-contacto"> </div></a>
					</div>
				</div>
			<?php if ( ! ajax () ) get_footer() ; ?>	
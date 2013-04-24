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
				<div id="team-container">
					<div class="member">
						<div class="member-container">
							<div class="member-info inline-block">
								<div class="member-title uppercase">
									Alejandro paz								
								</div>
								<br>
								<div class="member-text museo-sans-300">
									(Ciudad de Guatemala 1975) es arquitecto graduado de la Universidad Francisco Marroquín de Guatemala (2003). Ha incursionado en el campo de la arquitectura y el diseño trabajando proyectos en Guatemala, Centro América y USA. En el campo del arte se ha caracterizado por su trabajo de corte conceptual, el cual reflexiona sobre aspectos sociales y políticos de la construcción identitaria, tanto del individuo como de grupos sociales. Ha participado en diversas exposiciones individuales y colectivas.
								</div>
							</div> 
							<div id="photo-ale" class="member-photo inline-block"></div>
							<div class="mail-border inline-block relative"></div>
							<div class="mail-info inline-block">
								<div class="mail-txt museo-sans-300">
									alejandro@pazarquitectura.com
								</div>								
								<a href="mailto:alejandro@pazarquitectura.com">
								<div class="mail-icon">
								</div> <!-- mail-icon -->
							</a>
							</div><!-- mail-info -->
						</div><!-- member -->					
						<div class="member-border"></div>
					</div>
					<div class="member">
						<div class="member-container">
							<div class="member-info inline-block">
								<div class="member-title uppercase">
									CAMILA VIZCAINO									
								</div>
								<br>
								<div class="member-text museo-sans-300">
									(Ciudad de Guatemala 1982) Arquitecta graduada con honores de la Universidad Francisco Marroquín de Guatemala (2007). Continuó sus estudios en la Scuola Politecnica di Design en Milán, Italia, con la maestría de Diseño Visual, interesada en la fusión que existe entre los mundos del diseño y del arte dentro de la comunicación visual. Con esta nueva rama de diseño busca intervenir y complementar la aquitectura, y así fusionar diferentes tipos de diseño en un sólo lenguaje.
								</div>
							</div> 
							<div id="photo-cam" class="member-photo inline-block"></div>
							<div class="mail-border inline-block relative"></div>
							<div class="mail-info inline-block">
								<div class="mail-txt museo-sans-300">
									camila@pazarquitectura.com
								</div>								
								<a href="mailto:camila@pazarquitectura.com">
								<div class="mail-icon">
								</div> <!-- mail-icon -->								
								</a>
							</div><!-- mail-info -->
						</div><!-- member -->					
						<div class="member-border"></div>
					</div>
					<div class="member">
						<div class="member-container">
							<div class="member-info inline-block">
								<div class="member-title uppercase">
									Gabriel Rodriguez								
								</div>
								<br>
								<div class="member-text museo-sans-300">
									(Guatemala noviembre de 1984). Inicio sus estudios de arte en el año 2000 como autodidacta. En 2004 inicia sus estudios de arquitectura en la Universidad Rafael Landívar en Guatemala. En el año 2006 comienza a hacer intervenciones y acciones en las calles de la ciudad de Guatemala. En el año 2008 ingresa al taller Paz Arquitectura. Actualmente divide su tiempo entre el arte y la arquitectura.
								</div>
							</div> 
							<div id="photo-gab" class="member-photo inline-block"></div>
							<div class="mail-border inline-block relative"></div>
							<div class="mail-info inline-block">
								<div class="mail-txt museo-sans-300">
									gabriel@pazarquitectura.com
								</div>
								<a href="mailto:gabriel@pazarquitectura.com">
								<div class="mail-icon">
								</div> <!-- mail-icon -->
								</a>
							</div><!-- mail-info -->
						</div><!-- member -->					
						<div class="member-border"></div>
					</div>
					<div class="member">
						<div class="member-container">
							<div class="member-info inline-block">
								<div class="member-title uppercase">
									Daniel Escobar								
								</div>
								<br>
								<div class="member-text museo-sans-300">
									Graduado de Arquitecto por la Universidad Rafael Landívar,  trabajó con el  Arq. Antonio Prado, en distintos proyectos de Arquitectura  y con los Arquitectos Olivero, Bland, y Gularte en Ilustración y arquitectura; actualmente estudia  la Maestría de Planificación, Manejo y Diseño Ambiental con el propósito de ampliar su conciencia ambiental y mejorar sus proyectos siendo respetuoso al medio ambiente, alternándolo con la arquitectura y la ilustración; su vida es un trabajo en  proceso.
								</div>
							</div> 
							<div id="photo-dan" class="member-photo inline-block"></div>
							<div class="mail-border inline-block relative"></div>
							<div class="mail-info inline-block">
								<div class="mail-txt museo-sans-300">
									daniel@pazarquitectura.com
								</div>
								<a href="mailto:daniel@pazarquitectura.com">
								<div class="mail-icon">
								</div> <!-- mail-icon -->
								</a>
							</div><!-- mail-info -->
						</div><!-- member -->					
						<div class="member-border"></div>
					</div>
				</div>
			<?php if ( ! ajax () ) get_footer () ; ?>	
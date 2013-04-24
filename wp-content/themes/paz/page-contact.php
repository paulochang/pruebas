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
				<?php 
							//If the form is submitted
				if(isset($_POST['submitted'])) {
					$emailTo = 'info@pazarquitectura.com';
					$subject = 'Contact Form Submission from '.$name;
					$body = "Name: $name nnEmail: $email nnComments: $comments";
					$headers = 'From: My Site <'.$emailTo.'>' . "rn" . 'Reply-To: ' . $email;
					wp_mail( $emailTo, $subject, $body, $headers);
				} ?>
				<div id="contact-container">
					<div id="contact-left" class="float-left">
						<div id="contact-txt-content">
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
								<?php the_content() ?>
							<?php endwhile; else: ?>
							<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
							<?php endif; ?>
						</div>
						<div id="contact-field-container">
							<form id="contact-form" method="post" action="<?php the_permalink(); ?>"> 
								<p>NOMBRE</p>
								<input type="text" class="contact-txt contact-field" id="name" name="name" placeholder="Nombre y apellido" 
								required tabindex="2" /> 
								<p>EMAIL</p>
								<input type="email" class="contact-txt contact-field" id="email" name="email" placeholder="nombre@dominio.com" 
								required tabindex="3" /> 
								<p>MENSAJE</p>
								<textarea name="comment" class="contact-txt contact-field block" id="comment" tabindex="4"></textarea> 

								<input class="contact-txt block contact-btn pointer" name="submit" type="submit" id="submit" tabindex="4" value="Enviar Mensaje" /> 

							</form> 
						</div>						
					</div>
					<div id="contact-right" class="float-right">	
						<div class="contactos" id="contactos">
                       
                       		<p>
                       			Paz Arquitectura<br>
												<br>
							 	23 ave 7-28 zona 15<br>
								Vista Hermosa I	<br>
								Ciudad de Guatemala,<br>
										Guatemala.<br>
												<br>
                                                <br>
								Tel. (502) 2369 1616<br>
								Fax. (502) 2369 4543<br>
												<br>
                                                <br>
								Email: <a href="mailto:info@pazarquitectura.com">info@pazarquitectura.com<br></a>
							</p>                        
  						</div>
					</div>
					<div class="clear"></div>
				</div>
				<?php if ( ! ajax () ) get_footer() ; ?>
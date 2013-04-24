				<div id="thumbnail-section">
					<div id="thumbnail-menu-bar" class="uppercase">
						<div id="thumbnail-selected-option">
						<img src="<?php echo theme_url ( 'img/thumb/footer-arrow.png' ); ?>">
						<span id="thumbnail-option-txt">
						<?php
							if( isset( $_POST['taxonomy']) && ( $_POST['taxonomy']!='all') && ( $_POST['taxonomy']!='nuevos')) {
						 		echo $_POST["taxonomy"];
							} elseif ($_POST['taxonomy']=='all') {
								echo "Archivo";
							} else {
								echo "proyectos nuevos";
							}
						 ?>
						 </span>
						 <img src="<?php echo theme_url ( 'img/thumb/footer-arrow.png' ); ?>">
						</div>
						<div id="thumbnail-menu" class="pointer">
							<div id="thumbnail-menu-txt">
							ordenar por:
							</div>
							<div id="collapsible-menu" class="transition-all">	
								<ul>
									<li class="filter-proyects" data-tax="nuevos"> nuevos </li>
									<?php 
										$terms = get_terms("tipo");
										$count = count($terms);
										if ( $count > 1 ){
											foreach ( $terms as $term ) {
												if (($term->slug!='destacado')&&($term->slug!='archivo'))
												echo'<li class="filter-proyects" data-tax="'. $term->slug .'">' . $term->name . '</li>';
											}
										}
									?>
									<li class="filter-proyects" data-tax="all">archivo</li> 
								</ul> 
							</div>
						</div>
					</div>
					<div id="thumbnail-container">
					<?php 

					$query = 'post_type=proyecto';	

					if( isset( $_POST['taxonomy']) && ( $_POST['taxonomy']!='all') && ( $_POST['taxonomy']!='nuevos')) {
						$query .= '&tipo=' . $_POST["taxonomy"];
					} 

					if( $_POST['taxonomy']=='all') {
						$query .= '&posts_per_page=-1&orderby=title&order=ASC';
					} else {
						$query .= '&posts_per_page=8&orderby=title&order=ASC';
					}

					$recent_projects = new WP_Query ( $query ) ; 
					?>
				    <?php while ( $recent_projects->have_posts () ) : ?>
				      <?php $recent_projects->the_post () ; ?>
				      <?php load_template ( get_template_directory () . '/home-page-item.php', false ) ; ?>
				    <?php endwhile ; ?>
				    	<div class="clear">
				    	</div>
					</div>
				</div>
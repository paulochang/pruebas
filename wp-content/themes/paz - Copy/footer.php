            </div>
                <div id="template-container">
                <?php load_template ( get_template_directory () . '/thumb-template.php', false ) ; ?>
                </div>
            <footer id="main-footer">
               
                 <nav id="footer-navigation" class="uppercase block">
                    <div id="footer-link-wrapper" class="relative txt-center txt-middle">
                        <img id="footer-logo" class="txt-left absolute block" src="<?php echo theme_url ( 'img/logo-down.jpg' ); ?>">
                        <ul >
                            <li class="filter-proyects" data-tax="nuevos"><a href="<?php echo home_url (); ?>">Inicio</a></li>
                            <li><a href="<?php echo home_url ('about'); ?>">Acerca de</a></li>
                            <li><a href="<?php echo get_post_type_archive_link( 'proyecto' ); ?>">Proyectos</a></li>
                            <li><a href="<?php echo home_url ('team'); ?>">Equipo</a></li>
                            <li><a href="<?php echo get_post_type_archive_link( 'noticia' ); ?>">Noticias</a></li>
                            <li><a href="<?php echo get_post_type_archive_link( 'post' ); ?>">Blog</a></li>
                            <li><a href="<?php echo home_url ('contact'); ?>">Contacto</a></li>
                        </ul>
                    </div>
                </nav>
            </footer>
        <script>    
            console.log('añadir analytics')
        </script>
        </div>
        <div id="ad-ambush" class="uppercase margin-center txt-right">
          <a href="http://ambushstudio.com" target="_blank">A.D. Ambush</a>
        </div>
        <?php wp_footer (); ?>
    </body>
</html>

<!DOCTYPE html>
<html <?php language_attributes (); ?>>
    <head>
        <meta charset="<?php bloginfo ( 'charset' ); ?>" /> <!-- configura el conjunto de caracteres -->
        <meta name="viewport" content="width=1024, initial-scale=1, maximum-scale=1" /> <!-- configura el ancho de la pantalla -->
        <title><?php
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

            ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo ( 'pingback_url' ); ?>" />
        <link rel="icon" type="image/ico" href="<?php echo theme_url ( 'img/favAlejandro.ico' ); ?>">
        <?php wp_head (); ?>
        <script type="text/javascript">
          var Server = Server || { } ;
        // Misc Data
        Server.debug = true ;
        // Wordpress based URL's
        Server.url = { } ;
        Server.url.titulo = '<?php wp_title ( '|', true, 'right' ); ?>' ;
        Server.url.site = '<?php echo site_url (); ?>' ;
        Server.url.home = '<?php echo home_url (); ?>' ;
        Server.url.theme = '<?php echo theme_url (); ?>' ;
        Server.url.admin = '<?php echo admin_url (); ?>' ;
        Server.url.ajax = '<?php echo admin_url ( 'admin-ajax.php' ); ?>' ;
        var im0 = new Image();
        im0.src = "<?php echo theme_url ( 'img/home-rollovers/blog.jpg' ); ?>";
        var im1 = new Image();
        im1.src = "<?php echo theme_url ( 'img/home-rollovers/comercial.jpg' ); ?>";
        var im2 = new Image();
        im2.src = "<?php echo theme_url ( 'img/home-rollovers/contacto.jpg' ); ?>";
        var im3 = new Image();
        im3.src = "<?php echo theme_url ( 'img/home-rollovers/destacado.jpg' ); ?>";
        var im4 = new Image();
        im4.src = "<?php echo theme_url ( 'img/home-rollovers/encuentro.jpg' ); ?>";
        var im5 = new Image();
        im5.src = "<?php echo theme_url ( 'img/home-rollovers/institucional.jpg' ); ?>";
        var im6 = new Image();
        im6.src = "<?php echo theme_url ( 'img/home-rollovers/logo.jpg' ); ?>";
        var im7 = new Image();
        im7.src = "<?php echo theme_url ( 'img/home-rollovers/noticias.jpg' ); ?>";
        var im8 = new Image();
        im8.src = "<?php echo theme_url ( 'img/home-rollovers/residencial.jpg' ); ?>";
        </script>
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body <?php body_class (); ?> data-language="<?php bloginfo ( 'language' ); ?>">

        <div id="content-wrap" class="museo-sans">
            <a class="filter-proyects" data-tax="nuevos" href="<?php echo home_url (); ?>"><img id="header-logo" src="<?php echo theme_url ( 'img/logo.png' ); ?>"/></a>
            <header>                
                <nav id="main-navigation" class="uppercase">
                    <div id="link-wrapper" class="float-right">
                        <ul >
                            <li class="filter-proyects" data-tax="nuevos"><a href="<?php echo home_url (); ?>">Inicio</a></li>
                            <li><a href="<?php echo home_url ('about'); ?>">Acerca de</a></li>
                            <li id="project-header" class="pointer"><a href="<?php echo get_post_type_archive_link( 'proyecto' ); ?>">Proyectos
                                <div id="header-collapsible-menu" class="transition-all">  
                                <ul>
                                    <li class="filter-proyects" data-tax="nuevos"> Nuevos </li>
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
                                    <li class="filter-proyects" data-tax="all"> archivo </li>
                                </ul>                           
                            </div>
                            </a>
                            </li>

                            <li><a href="<?php echo home_url ('team'); ?>">Equipo</a></li>
                            <li><a href="<?php echo get_post_type_archive_link( 'noticia' ); ?>">Noticias</a></li>
                            <li><a href="<?php echo get_post_type_archive_link ( 'post' ); ?>">Blog</a></li>
                            <li ><a id="last-nav-link" href="<?php echo home_url ('contact'); ?>">Contacto</a></li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div id="content">
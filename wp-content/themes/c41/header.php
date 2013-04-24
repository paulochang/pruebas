<!DOCTYPE html>
<html <?php language_attributes (); ?>>
  <head>
    <meta charset="<?php bloginfo ( 'charset' ); ?>" />
    <meta name="viewport" content="width=1024, initial-scale=1, maximum-scale=1" />
    <title><?php wp_title ( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo ( 'pingback_url' ); ?>" />
    <link rel="icon" type="image/png" href="<?php echo theme_url ( 'images/favicon.png' ); ?>">
    <?php wp_head (); ?>
    <script type="text/javascript">
      var Server = Server || { } ;
      // Misc Data
      Server.debug = true ;
      // Wordpress based URL's
      Server.url = { } ;
      Server.url.site = '<?php echo site_url (); ?>' ;
      Server.url.home = '<?php echo home_url (); ?>' ;
      Server.url.theme = '<?php echo theme_url (); ?>' ;
      Server.url.admin = '<?php echo admin_url (); ?>' ;
      Server.url.ajax = '<?php echo admin_url ( 'admin-ajax.php' ); ?>' ;
    </script>
  </head>

  <body <?php body_class (); ?> data-language="<?php bloginfo ( 'language' ); ?>">
    <div id="fb-root"></div>
    <div class="no-display">
      <img src="<?php echo theme_url ( 'images/spinner.gif' ) ?>"/>
    </div>
    <div id="content-wrap" class="relative no-repeat <?php echo 'background-' . rand ( 1, 3 ); ?>">
      <div id="left-block">
        <div class="inner-block no-repeat relative">
          <div class="opacity-background absolute"></div>
          <div id="main-menu" class="relative">
            <a class="logo uppercase no-repeat block txt-right" href="<?php echo home_url (); ?>">
              <img src="<?php echo theme_url ( 'images/c41.png' ); ?>"/>
            </a>
            <div class="section border-top txt-right">
              <a class="no-repeat uppercase line-through txt-right inline-block language-selector language-en" href="?lan=en">ENG</a>
              <span class="inline-block">&#47;</span>
              <a class="no-repeat uppercase line-through txt-right inline-block language-selector language-es" href="?lan=es">ESP</a>
            </div>
            <div class="section border-top">
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo home_url ( 'concepcion-41' ); ?>">&#47;<?php _e ( 'Concepción 41', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo home_url ( 'now' ); ?>">&#47;<?php _e ( 'Now', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo get_post_type_archive_link ( 'project' ); ?>">&#47;<?php _e ( 'Projects', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo get_post_type_archive_link ( 'event' ); ?>">&#47;<?php _e ( 'Archive', 'c41' ); ?>&#47;</a>
            </div>
            <div class="section border-top">
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo home_url ( 'people' ); ?>">&#47;<?php _e ( 'People', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo get_post_type_archive_link ( 'post' ); ?>">&#47;<?php _e ( 'Co-Blog', 'c41' ); ?>&#47;</a>
            </div>
            <div class="section border-top">
              <a class="no-repeat uppercase line-through txt-right block relative" href="<?php echo home_url ( 'press' ); ?>">&#47;<?php _e ( 'Press', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block relative" href="<?php echo home_url ( 'links' ); ?>">&#47;<?php _e ( 'Links', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block" href="<?php echo home_url ( 'contact' ); ?>">&#47;<?php _e ( 'Contact', 'c41' ); ?>&#47;</a>
            </div>
            <div class="section border-top">
              <a class="no-repeat uppercase line-through txt-right block relative" href="https://www.facebook.com/concepcion.cuarentauno" target="_blank">&#47;<?php _e ( 'Facebook', 'c41' ); ?>&#47;</a>
              <a class="no-repeat uppercase line-through txt-right block relative">&#47;<?php _e ( 'Twitter', 'c41' ); ?>&#47;<div class="coming-soon absolute txt-center"><?php _e ( 'Coming Soon', 'c41' ); ?></div></a>
              <a class="no-repeat uppercase line-through txt-right block relative">&#47;<?php _e ( 'Instagram', 'c41' ); ?>&#47;<div class="coming-soon absolute txt-center"><?php _e ( 'Coming Soon', 'c41' ); ?></div></a>
            </div>
          </div>
          <div id="contact-bottom-left" class="border-top txt-right absolute">
            4a Calle Oriente no. 41<br/>
            La Antigua, Guatemala.<br/>
            <a class="line-through" href="mailto:info@c-41.org">info@c-41.org</a><br/>
            (502)&nbsp;4157&nbsp;9535<br/>
            <br/>
            <span>&copy; copyright 2012<br/>concepción 41</span>
          </div>
        </div>
      </div>
      <div id="right-block">
        <div class="inner-block transition-opacity">
          <form id="search-form" class="block relative" action="<?php echo home_url (); ?>" method="get">
            <label for="search-input" class="block uppercase">&#47;<?php _e ( 'Search', 'c41' ); ?>&#47;</label>
            <input type="text" id="search-input" name="s" value="" class="border-all block"/>
          </form>
          <form id="newsletter-form" class="block relative" action="<?php echo home_url (); ?>" method="get" data-action="c41_newsletter_submit">
            <label for="newsletter-input" class="block uppercase">&#47;<?php _e ( 'Email', 'c41' ); ?>&#47;<?php _e ( 'Newsletter', 'c41' ); ?>&#47;</label>
            <input type="text" id="newsletter-input" name="mail" value="" class="border-all block"/>
          </form>
          <div id="archive" class="">
            <?php $about = get_page_by_path ( 'concepcion-41' ); ?>
            <a class="block border-top" href="<?php echo home_url ( 'concepcion-41' ); ?>">
              <?php echo get_the_post_thumbnail ( $about -> ID, 'side-bar' ); ?>
              <h4><?php language_the_title ( $about -> ID ); ?></h4>
              <?php language_the_excerpt ( $about -> ID, 9, '...' ); ?>
            </a>
            <a class="more-info block uppercase line-through" href="<?php echo home_url ( 'about-c41' ); ?>"><?php _e ( 'Read More', 'c41' ); ?></a>

            <?php $now = c41_lastest_project (); ?>
            <a class="block border-top" href="<?php echo get_permalink ( $now[ 'ID' ] ) ?>">
              <?php c41_project_front( $now['ID'], true ); ?>
              <?php //echo get_the_post_thumbnail ( $now[ 'ID' ], 'side-bar' ); ?>
              <h4><?php language_the_title ( $now[ 'ID' ] ); ?></h4>
              <?php language_the_excerpt ( $now[ 'ID' ], 9, '...' ); ?>
            </a>
            <a class="more-info block uppercase line-through" href="<?php echo get_post_type_archive_link ( 'project' ); ?>"><?php _e ( 'See All Projects', 'c41' ); ?></a>

            <?php $blog = c41_latest_post (); ?>
            <a class="block border-top" href="<?php echo get_permalink ( $blog[ 'ID' ] ) ?>">
              <?php c41_post_front( $blog['ID'], true ); ?>
              <?php //echo get_the_post_thumbnail ( $blog[ 'ID' ], 'side-bar' ); ?>
              <h4><?php echo get_the_title ( $blog[ 'ID' ] ); ?></h4>
              <?php language_the_excerpt ( $blog[ 'ID' ], 9, '...' ); ?>
            </a>
            <a class="more-info block uppercase border-bottom line-through" href="<?php echo get_post_type_archive_link ( 'post' ); ?>"><?php _e ( 'Go To Blog', 'c41' ); ?></a>
          </div>

          <div id="blog-sidebar" class="border-top transition-opacity transition-height">
            <div class="date-archive txt-right uppercase">
              <p><?php _e ( 'Archive', 'c41' ); ?>:</p>
              <?php c41_date_archive (); ?> 
            </div>
            <div class="tag-archive border-top txt-right uppercase">
              <p><?php _e ( 'Etiquetas', 'c41' ); ?>:</p>
              <?php echo c41_tag_archive (); ?>
            </div>
          </div>
        </div>
      </div>
      <div id="content-main">
        <div id="content-size">
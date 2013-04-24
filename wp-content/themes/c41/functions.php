<?php

function c41_init () {
  
}

add_action ( 'init', 'c41_init' ) ;

/**
 * @param array $public_query_vars
 * @return string 
 */
function add_public_query_vars ( $public_query_vars ) {
  $public_query_vars[ ] = 'ajax' ;
  return $public_query_vars ;

}

add_filter ( 'query_vars', 'add_public_query_vars' ) ;

/**
 * Setup Pagination
 * @param type $wp
 * @return type
 */
function ci_paging_request ( $wp ) {
  //We don't want to mess with the admin panel.
  if ( is_admin () ) {
    return ;
  }

}

add_action ( 'pre_get_posts', 'ci_paging_request' ) ;

/**
 * Extends Post Types
 */
function c41_extend_post_types () {

  register_post_type ( 'post', array (
    'publicly_queryable' => true,
    'query_var' => true,
    'hierarchical' => false,
    'has_archive' => true,
    'rewrite' => array ( 'slug' => 'co-blog' )
  ) ) ;

  /*
   * Create "Project" Post Type
   */
  $labels = array (
    'name' => 'Projects',
    'singular_name' => 'Project',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Project',
    'edit_item' => 'Edit Project',
    'new_item' => 'New Project',
    'all_items' => 'All Projects',
    'view_item' => 'View Project',
    'search_items' => 'Search Projects',
    'not_found' => 'No projects found',
    'not_found_in_trash' => 'No projects found in Trash',
    'parent_item_colon' => '',
    'menu_name' => 'Projects'
      ) ;

  $args = array (
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array ( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
      ) ;

  register_post_type ( 'project', $args ) ;

  /*
   * Create "Event" Post Type
   */
  $labels = array (
    'name' => 'Archive',
    'singular_name' => 'Event',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Event',
    'edit_item' => 'Edit Event',
    'new_item' => 'New Event',
    'all_items' => 'All Event',
    'view_item' => 'View Event',
    'search_items' => 'Search Event',
    'not_found' => 'No events found',
    'not_found_in_trash' => 'No events found in Trash',
    'parent_item_colon' => '',
    'menu_name' => 'Archive'
      ) ;

  $args = array (
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'rewrite' => array ( 'slug' => 'archive' ),
    'supports' => array ( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
      ) ;

  register_post_type ( 'event', $args ) ;

}

add_action ( 'init', 'c41_extend_post_types', 0 ) ;

/**
 * Initializes the C41 Theme
 */
function c41_setup () {
  load_theme_textdomain ( 'c41', get_template_directory () . '/languages' ) ;

  // This theme uses a custom image size for featured images, displayed on "standard" posts.
  add_theme_support ( 'post-thumbnails' ) ;

  // Theme specific image sizes
  add_image_size ( 'side-bar', 160, 100, false ) ;
  add_image_size ( 'page-gallery', 624, 400, false ) ;
  add_image_size ( 'event-thumbnail', 100, 100, true ) ;

}

add_action ( 'after_setup_theme', 'c41_setup' ) ;

/**
 * Enqueues scripts and styles for front-end.
 */
function c41_scripts_styles () {

  wp_enqueue_script ( 'mootools-core', get_template_directory_uri () . '/js/mootools-core-1.4.5.js', array ( ), '1.4.5', false ) ;
  wp_enqueue_script ( 'mootools-more', get_template_directory_uri () . '/js/mootools-more-1.4.0.1.js', array ( 'mootools-core' ), '1.4.0.1', false ) ;
  wp_enqueue_script ( 'c41-script', get_template_directory_uri () . '/js/c41.js', array ( 'mootools-more' ), '1.0', false ) ;
  wp_enqueue_style ( 'c41-style', get_stylesheet_uri () ) ;

}

add_action ( 'wp_enqueue_scripts', 'c41_scripts_styles' ) ;

function c41_text_content_shortcode ( $atts, $content = null ) {
  return '<div class="txt-content">' . $content . '</div>' ;

}

add_shortcode ( 'txt', 'c41_text_content_shortcode' ) ;

function c41_people_shortcode ( $atts, $content = null ) {
  $classes = array ( 'txt-content' ) ;
  if ( isset ( $atts[ 'border' ] ) ) {
    $classes[ ] = 'border-bottom' ;
  }
  return '<div class="' . join ( ' ', $classes ) . '">' . $content . '</div>' ;

}

add_shortcode ( 'people', 'c41_people_shortcode' ) ;

function c41_press_shortcode ( $atts, $content = null ) {
  return '<div class="border-top press-divider"></div>' ;

}

add_shortcode ( 'press_divider', 'c41_press_shortcode' ) ;

function c41_gallery_shortcode ( $atts ) {
  $post = get_post () ;

  static $instance = 0 ;
  $instance ++ ;

  if ( ! empty ( $attr[ 'ids' ] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty ( $attr[ 'orderby' ] ) )
      $attr[ 'orderby' ] = 'post__in' ;
    $attr[ 'include' ] = $attr[ 'ids' ] ;
  }

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters ( 'post_gallery', '', $attr ) ;
  if ( $output != '' )
    return $output ;

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset ( $attr[ 'orderby' ] ) ) {
    $attr[ 'orderby' ] = sanitize_sql_orderby ( $attr[ 'orderby' ] ) ;
    if ( ! $attr[ 'orderby' ] )
      unset ( $attr[ 'orderby' ] ) ;
  }

  extract ( shortcode_atts ( array (
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
          ), $attr ) ) ;

  $id = intval ( $id ) ;
  if ( 'RAND' == $order )
    $orderby = 'none' ;

  if ( ! empty ( $include ) ) {
    $_attachments = get_posts ( array ( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) ) ;

    $attachments = array ( ) ;
    foreach ( $_attachments as $key => $val ) {
      $attachments[ $val->ID ] = $_attachments[ $key ] ;
    }
  } elseif ( ! empty ( $exclude ) ) {
    $attachments = get_children ( array ( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) ) ;
  } else {
    $attachments = get_children ( array ( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) ) ;
  }

  if ( empty ( $attachments ) ) {
    return '' ;
  }

  $html = '<div class="gallery page-gallery relative">' ;
  foreach ( $attachments as $att_id => $attachment ) {
    $html .= wp_get_attachment_image ( $att_id, 'page-gallery', false, array ( 'class' => 'image absolute' ) ) ;
  }
  $html .= '<div class="next no-repeat absolute pointer"></div>' ;
  $html .= '<div class="prev no-repeat absolute pointer"></div>' ;
  $html .= '<div class="selectors absolute">' ;
  foreach ( $attachments as $att_id => $attachment ) {
    $html .= '<div class="selector float-right transition-background-color pointer" data-att="' . $att_id . '"></div>' ;
  }
  $html .= '<div class="clear"></div></div></div>' ;

  return $html ;

}

add_shortcode ( 'gallery', 'c41_gallery_shortcode' ) ;

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function c41_wp_title ( $title, $sep ) {
  global $paged, $page ;

  if ( is_feed () )
    return $title ;

  // Add the site name.
  $title .= get_bloginfo ( 'name' ) ;

  // Add the site description for the home/front page.
  $site_description = get_bloginfo ( 'description', 'display' ) ;
  if ( $site_description && ( is_home () || is_front_page () ) )
    $title = "$title $sep $site_description" ;

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 )
    $title = "$title $sep " . sprintf ( __ ( 'Page %s', 'c41' ), max ( $paged, $page ) ) ;

  return $title ;

}

add_filter ( 'wp_title', 'c41_wp_title', 10, 2 ) ;

function c41_body_class ( $classes ) {
  global $wp_query ;
  // filter available but not implemented yet...

  $classes[ ] = 'language-' . $wp_query->query_vars[ 'lan' ] ;
  $classes[ ] = 'relative' ;
  $classes[ ] = 'andale-mono' ;
  $classes[ ] = 'background-white' ;
  $classes[ ] = 'body-class' ;
  return $classes ;

}

add_filter ( 'body_class', 'c41_body_class' ) ;

function theme_url ( $path = '' ) {
  $url = get_template_directory_uri () ;

  if ( ! empty ( $path ) && is_string ( $path ) && strpos ( $path, '..' ) === false )
    $url .= '/' . ltrim ( $path, '/' ) ;

  return $url ;

}

function get_page_attachments ( $page ) {

  $gallery = get_posts ( array (
    'post_parent' => $page->ID,
    'numberposts' => -1,
    'posts_per_page' => -1,
    'posts_per_archive_page' => -1,
    'post_status' => 'inherit',
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'order' => 'ASC',
    'orderby' => 'menu_order ID'
      ) ) ;

  $atts = array ( ) ;

  if ( is_array ( $gallery ) ) {
    foreach ( $gallery as $att ) {
      $atts[ ] = $att ;
    }
  }

  return $atts ;

}

function c41_pagination ( $post_type = 'post' ) {
  $total_pages = ceil ( wp_count_posts ( $post_type )->publish / 3 ) ;
  $current_page = max ( 1, get_query_var ( 'page' ) ) ;
  $previous_page = max ( 0, $current_page - 1 ) ;
  $next_page = $current_page < $total_pages ? $current_page + 1 : 0 ;

  $start = $current_page - 3 ;
  $end = $current_page + 3 ;
  $k = $current_page + 1 ;
  $pages = array ( ) ;

  while ( $start < $current_page ) {
    $pages[ ] = max ( 0, $start ++  ) ;
  }

  $pages[ ] = $current_page ;

  while ( $k <= $end ) {
    $pages[ ] = $k <= $total_pages ? $k : 0 ;
    $k ++ ;
  }

  include get_template_directory () . '/template-pagination.php' ;

}

function get_co_blog_archive () {

  $archive = new WP_Query ( array (
    'posts_per_page' => 3,
    'paged' => max ( 1, get_query_var ( 'page' ) ),
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish'
      ) ) ;

  return $archive ;

}

function get_project_archive () {

  $archive = new WP_Query ( array (
    'posts_per_page' => 3,
    'paged' => max ( 1, get_query_var ( 'page' ) ),
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'project',
    'post_status' => 'publish'
      ) ) ;

  return $archive ;

}

function get_event_archive () {

  $archive = new WP_Query ( array (
    'posts_per_page' => 3,
    'paged' => max ( 1, get_query_var ( 'page' ) ),
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'event',
    'post_status' => 'publish'
      ) ) ;

  return $archive ;

}

function c41_date_archive () {
  wp_get_archives ( array (
    'type' => 'monthly',
    'format' => 'html',
    'show_post_count' => true,
    'echo' => 1,
    'order' => 'DESC'
  ) ) ;

}

/**
 * @param string $filename
 * @return string 
 */
function make_filename_hash ( $filename ) {
  $info = pathinfo ( $filename ) ;
  $ext = empty ( $info[ 'extension' ] ) ? '' : '.' . $info[ 'extension' ] ;
  $name = basename ( $filename, $ext ) ;
  return md5 ( $name . time () ) . $ext ;

}

// Add filter to sanitize file names after upload: make_filename_hash()
add_filter ( 'sanitize_file_name', 'make_filename_hash', 10 ) ;

/**
 * @return boolean 
 */
function ajax () {
  return ( ! ! get_query_var ( 'ajax' )) || isset ( $_POST[ 'post' ] ) ;

}

function c41_tag_archive () {
  $tags = get_tags ( array (
    'number' => 35
      ) ) ;
  $j = count ( $tags ) ;
  $html = '<p>' ;
  foreach ( $tags as $tag ) {
    $tag_link = get_tag_link ( $tag->term_id ) ;

    $html .= '<a href="' . $tag_link . '" title="' . $tag->name . ' Tag" class="line-through">' ;
    $html .= $tag->name . '</a>' ;

    if ( -- $j ) {
      $html .= ', ' ;
    }
  }
  $html .= '</p>' ;
  echo $html ;

}

function c41_now_permalink () {
  $recent = c41_lastest_project () ;

  if ( $recent != null ) {
    echo get_permalink ( $recent[ "ID" ] ) ;
  }

}

function c41_lastest_project () {
  $recent = wp_get_recent_posts ( array (
    'numberposts' => 1,
    'post_type' => 'project'
      ) ) ;

  return ( ! empty ( $recent ) ) ? $recent[ 0 ] : null ;

}

function c41_latest_post () {
  $recent = wp_get_recent_posts ( array (
    'numberposts' => 1,
    'post_type' => 'post',
    'post_status' => 'publish'
      ) ) ;

  return ( ! empty ( $recent ) ) ? $recent[ 0 ] : null ;

}

function c41_post_excerpt ( $post, $length = 25, $more = '[...]' ) {
  $text = $post->post_content ;
  $excerpt_length = apply_filters ( 'excerpt_length', $length ) ;
  $excerpt_more = apply_filters ( 'excerpt_more', ' ' . $more ) ;
  $trimmed = wp_trim_words ( $text, $excerpt_length, $excerpt_more ) ;
  echo str_replace ( '[txt]', '', $trimmed ) ;

}

add_action ( 'wp_ajax_c41_contact_submit', 'c41_contact_submit' ) ; // ajax for logged in users
add_action ( 'wp_ajax_nopriv_c41_contact_submit', 'c41_contact_submit' ) ; // ajax for not logged in users

function c41_contact_submit () {

  $name = $_POST[ 'name' ] ;
  $mail = $_POST[ 'mail' ] ;
  $message = $_POST[ 'message' ] ;

  if ( trim ( $name ) !== '' && trim ( $mail ) !== '' && trim ( $message ) !== '' ) {
    $body = $name . ' has submitted a message from the C-41.org Website:' . "\n\n" ;
    $body .= $message . "\n\n" ;
    $body .= $name . '. ' . $mail ;
    $body .= "\n" ;

    wp_mail ( 'info@c-41.org', 'Message Received From C-41.org', $body ) ;

    echo __ ( 'Message Submitted Succesfully!', 'c41' ) ;
  } else {
    echo __ ( 'All fields are required to send a message. Please recheck your information and try again.', 'c41' ) ;
  }
  die();
}

add_action ( 'wp_ajax_c41_newsletter_submit', 'c41_newsletter_submit' ) ; // ajax for logged in users
add_action ( 'wp_ajax_nopriv_c41_newsletter_submit', 'c41_newsletter_submit' ) ; // ajax for not logged in users

function c41_newsletter_submit () {

  $mail = $_POST[ 'mail' ] ;

  $body = $mail . ' has suscribed to the C-41.org Newsletter:' . "\n\n" ;
  wp_mail ( 'info@c-41.org', 'Newsletter Subscription Received From C-41.org', $body ) ;

  echo __ ( 'Message Submitted Succesfully!', 'c41' ) ;
  die();
}

function admin_favicon () {
  echo '<link rel="icon" type="image/png" href="' . theme_url ( 'images/favicon.png' ) . '">' ;

}

add_action ( 'admin_head', 'admin_favicon' ) ;

function c41_post_front ( $post_id, $small = false ) {
  $youtube_url = trim ( get_post_meta ( $post_id, '_videothumb_input', true ) ) ;
  if ( $youtube_url !== '' ) {
    c41_video_from_url ( $youtube_url, $small ) ;
  } else {
    echo get_the_post_thumbnail ( $post_id, $small ? 'side-bar' : 'page-gallery', array ( 'class' => 'image' ) ) ;
  }

}

function c41_project_front ( $post_id, $small = false ) {
  $youtube_url = get_post_meta ( $post_id, '_videothumb_input', true ) ;
  if ( $youtube_url !== '' ) {
    c41_video_from_url ( $youtube_url, $small ) ;
  } else {
    echo get_the_post_thumbnail ( $post_id, $small ? 'side-bar' : 'page-gallery', array ( 'class' => 'image' ) ) ;
  }

}

function c41_video_from_url ( $youtube_url, $small = false ) {
  if ( $small ) {
    echo '<iframe width="156" height="100" ' ;
  } else {
    echo '<iframe width="624" height="400" ' ;
  }

  echo 'src="' . str_replace ( 'http://youtu.be/', 'http://www.youtube.com/embed/', $youtube_url ) . '" frameborder="0" controls="0" showinfo="0" allowfullscreen></iframe>' ;

}

/**
 * Adds a metabox in the post edit page
 */
function videothumb_add_metabox () {
  $post_types = array ( 'post' ) ;
  foreach ( $post_types as $type ) {
    add_meta_box ( 'videothumb_metabox', __ ( 'Featured Video', 'c41' ), 'videothumb_create_metabox', $type ) ;
  }

}

// hook the add_meta_boxes action: videothumb_add_metabox()
add_action ( 'add_meta_boxes', 'videothumb_add_metabox' ) ;

/**
 * Renders the text editor in the language metabox
 * @param stdClass $post 
 */
function videothumb_create_metabox ( $post ) {
  $videothumb_url = get_post_meta ( $post->ID, '_videothumb_input', true ) ;

  echo '<div>' ;

  if ( $videothumb_url !== '' ) {
    c41_video_from_url ( $videothumb_url, true ) ;
  }


  echo '<input type="text" name="videothumbinput" size="30" value="' . esc_attr ( htmlspecialchars ( $videothumb_url ) ) . '" id="videothumbinput" autocomplete="off">' ;
  echo '</div>' ;

}

function videothumb_filter_handler ( $data, $postarr ) {
  global $post ;
  if ( isset ( $postarr[ 'videothumbinput' ] ) ) {
    update_post_meta ( $post->ID, '_videothumb_input', $postarr[ 'videothumbinput' ] ) ;
  }
  return $data ;

}

// hook the post edit/create/update action: language_filter_handler()
add_filter ( 'wp_insert_post_data', 'videothumb_filter_handler', '99', 2 ) ;

function my_insert_custom_image_sizes ( $sizes ) {
  global $_wp_additional_image_sizes ;
  if ( empty ( $_wp_additional_image_sizes ) )
    return $sizes ;

  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    if ( ! isset ( $sizes[ $id ] ) )
      $sizes[ $id ] = ucfirst ( str_replace ( '-', ' ', $id ) ) ;
  }

  return $sizes ;

}

add_filter ( 'image_size_names_choose', 'my_insert_custom_image_sizes' ) ;

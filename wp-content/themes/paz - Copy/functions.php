<?php
add_theme_support( "post-thumbnails" );

function paz_init () {

  /* 
  * Registrar tamaño de imagen
  */
  add_image_size( 'proyecto-thumb', 236, 172, true );
  add_image_size( 'proyecto-slide', 821, 548, true );

  /*
   * Makes normal post queryable
   */
    register_post_type ( 'post', array (
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => false,
    'show_in_menu' => false,
    'query_var' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'rewrite' => array ( 'slug' => 'blog' )
  ) ) ;


   /*
   * Create "Proyecto" Post Type
   */
  $labels = array (
    'name' => 'Proyectos',
    'singular_name' => 'Proyecto',
    'add_new' => 'Agregar Nuevo',
    'add_new_item' => 'Agregar Nuevo Proyecto',
    'edit_item' => 'Editar Proyecto',
    'new_item' => 'Nuevo Proyecto',
    'all_items' => 'Todos los proyectos',
    'view_item' => 'Ver Proyecto',
    'search_items' => 'Buscar Proyectos',
    'not_found' => 'No se encontraron proyectos',
    'not_found_in_trash' => 'No se encontraron proyectos en la papelera',
    'parent_item_colon' => '',
    'menu_name' => 'Proyectos'
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
  register_post_type ( 'proyecto', $args ) ;

  
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
      'name'                => _x( 'Tipos de Construcción', 'taxonomy general name' ),
      'singular_name'       => _x( 'Tipo de Construcción', 'taxonomy singular name' ),
      'search_items'        => __( 'Buscar Tipos' ),
      'all_items'           => __( 'Todos los tipos' ),
      'parent_item'         => __( 'Tipo Padre' ),
      'parent_item_colon'   => __( 'Tipo Padre:' ),
      'edit_item'           => __( 'Editar Tipo' ), 
      'update_item'         => __( 'Actualizar Tipo' ),
      'add_new_item'        => __( 'Añadir nuevo tipo' ),
      'new_item_name'       => __( 'Nuevo nombre de tipo' ),
      'menu_name'           => __( 'Tipos' )
    );  

    $args = array(
      'hierarchical'        => true,
      'labels'              => $labels,
      'show_ui'             => true,
      'show_admin_column'   => true,
      'query_var'           => true,
      'rewrite'             => array( 'slug' => 'tipo' )
    );
  register_taxonomy( 'tipo', array( 'proyecto' ), $args );

  /* 
  * Registrar tamaño de imagen
  */
  add_image_size( 'news-thumb', 360, 172, true );

  function custom_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

   /*
   * Create "Noticias" Post Type
   */
  $labels = array (
    'name' => 'Noticias',
    'singular_name' => 'Noticia',
    'add_new' => 'Agregar Nueva',
    'add_new_item' => 'Agregar Nueva Noticia',
    'edit_item' => 'Editar Noticia',
    'new_item' => 'Nueva Noticia',
    'all_items' => 'Todas las noticias',
    'view_item' => 'Ver Noticia',
    'search_items' => 'Buscar Noticias',
    'not_found' => 'No se encontraron noticias',
    'not_found_in_trash' => 'No se encontraron noticias en la papelera',
    'parent_item_colon' => '',
    'menu_name' => 'Noticias'
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
    'supports' => array ( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
      ) ;  
  register_post_type ( 'noticia', $args ) ;
}

add_action ( 'init', 'paz_init' ) ;

function custom_home_pagesize( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;

        // Change default post number to 4
        $query->set( 'posts_per_page', 4 );
        return;
}
add_action( 'pre_get_posts', 'custom_home_pagesize', 1 );

function theme_url ( $path = '' ) {
  $url = get_template_directory_uri () ;

  if ( ! empty ( $path ) && is_string ( $path ) && strpos ( $path, '..' ) === false )
    $url .= '/' . ltrim ( $path, '/' ) ;

  return $url ;

}

/**
 * Serves as an indicator for knowing if the current request was 
 * triggered by an ajax call from the client.
 * 
 * @return boolean <code>true</code> if the current request is 
 * ajax-driven and <code>false</code> otherwise;
 */
function ajax () {
  return ( ! empty ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest') ||
      ! empty ( $_REQUEST[ 'action' ] ) || ! empty ( $_REQUEST[ 'ajax' ] ) ;

}

/**
 * Includes the Wordpress Header Template if the current request is not 
 * ajax oriented.
 * 
 */
function require_header ( $name = null ) {
  if ( ! ajax () ) {
    get_header ( $name ) ;
  }

}

/**
 * Includes the Wordpress Footer Template if the current request is not 
 * ajax oriented.
 * 
 */
function require_footer ( $name = null ) {
  if ( ! ajax () ) {
    get_footer ( $name ) ;
  }

}

/**
 * Echoes a DIV DOM Element with information about the current requested resource such as
 * Body Class or other data.
 * 
 * @param String $class classes to add to the metadata DOM Element.
 */
function body_metadata ( $class = '' ) {
  echo '<div id="body-metadata" class="' . join ( ' ', get_body_class ( $class ) ) . '"></div>' ;

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
 * Enqueues scripts and styles for front-end.
 */
function paz_scripts_styles () {

  wp_enqueue_script ( 'mootools-core', get_template_directory_uri () . '/js/vendor/mootools-core-1.4.5.js', array ( ), '1.4.5', false ) ;
  wp_enqueue_script ( 'mootools-more', get_template_directory_uri () . '/js/vendor/mootools-more-1.4.0.1.js', array ('mootools-core'), '1.4.0.1', false ) ;
  wp_enqueue_script ( 'paz-script', get_template_directory_uri () . '/js/main.js', array ('mootools-more'), false, false ) ;
  wp_enqueue_script ( 'slide-script', get_template_directory_uri () . '/js/slide.js', array ('paz-script'), false, false ) ;
  wp_enqueue_style ( 'paz-style', get_stylesheet_uri () ) ;

}

add_action ( 'wp_enqueue_scripts', 'paz_scripts_styles' ) ;

/**
 * Sets a shortcut for orange texts
 * @return string 
 */
function orange_shortcode( $atts, $content = null ) {
   return '<div class="orange">' . $content . '</div>';
}
add_shortcode( 'orange', 'orange_shortcode' );


$ImageTerms = array();
/**
 * @param string $size thumbnail-size
 * @param int $qty thumbnail-quantity
 * @return string with image
 */
function postimage( $size, $qty) {
  global $ImageTerms;

  foreach (array(get_term_by('slug','imagenes','attachment_category'),get_term_by('slug','proceso','attachment_category'),get_term_by('slug','plano','attachment_category')) as $term) {
    $args = array( 
    'post_parent' => get_the_ID(),
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page'=>-1
    );
    $images  = get_posts($args);
    foreach ($images as $image) {    
      if (has_term( $term, "attachment_category", $image )) {
        $attachmenturl=wp_get_attachment_url($image->ID);
        $attr = array(
          'class' => "slide absolute transition-margin-left transition-width",
          'data-type' => $term->slug
        );
        echo wp_get_attachment_image( $image->ID, $size, False, $attr );
        //echo '<img class="slide absolute transition-margin-left transition-width" data-type="'.$term->slug.'" src="'.$attachmenturl.'"></img>' . "\n";
      }
    }
  }  
}

function getImageTypes() {
  global $ImageTerms;

  $ImageTerms = array();

  foreach (array(get_term_by('slug','imagenes','attachment_category'),get_term_by('slug','proceso','attachment_category'),get_term_by('slug','plano','attachment_category')) as $term) {
    $args = array( 
    'post_parent' => get_the_ID(),
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page'=>-1
    );
    $images  = get_posts($args);
    $found = false;
    foreach ($images as $image) {    
      if (!$found && has_term( $term, "attachment_category", $image )) {

        $found = true;
        $ImageTerms[] = $term; 
        echo '<li data-slug="'.$term->slug.'" class="project-option inline-block txt-middle selector white pointer">'.$term->name.'</li>';
      }
    }
  }  
}

/**
 * Creates a custom pagination for archives
 */
function getCustomPagination() {
  global $wp_query;  
  
  $total_pages = $wp_query->max_num_pages;
  if ($total_pages > 1){
    $current_page = max(1, get_query_var('paged'));
    echo '<div class="orange page-index float-left">';
    echo "PAG ". max(1, get_query_var('paged'))." de ".$total_pages."</div>";
    echo '<div class="news-numbering float-left">';
    echo paginate_links(array(  
        'base' => get_pagenum_link(1) . '%_%',  
        'format' => 'page/%#%',  
        'current' => $current_page,  
        'total' => $total_pages,
        'mid_size' => 1,
        'prev_next'    => false
      ));
    echo '</div>';
  }
}  

add_action('wp_ajax_my_action', 'get_thumb_action');
add_action('wp_ajax_nopriv_my_action', 'get_thumb_action');

function get_thumb_action() {  
  load_template( get_template_directory() . '/thumb-template.php' );
  die();
}

function get_starred_proyect() {
    $args = array( 
    'tipo'=>'destacado',
    'post_type' => 'proyecto'
    );

    $proyectos  = get_posts($args);
        echo (get_post_permalink( $proyectos[0]->ID));
   
}


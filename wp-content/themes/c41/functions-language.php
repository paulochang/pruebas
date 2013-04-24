<?php

/**
 * @return string the url variable for the language
 */
function get_lan () {
  $vars = get_bloginfo ( 'language' ) == 'es-ES' ? '?lan=es' : '';
  return $vars;
}

/**
 * Echoes the url variable for the language
 */
function lan () {
  echo get_lan ();
}

/**
 * Adds a metabox in the post edit page
 */
function language_add_metabox () {
  $post_types = array ( 'page', 'project' );
  foreach ( $post_types as $type ) {
    add_meta_box ( 'language_metabox', __ ( 'Español', 'c41' ), 'language_create_metabox', $type );
  }
}

// hook the add_meta_boxes action: language_add_metabox()
add_action ( 'add_meta_boxes', 'language_add_metabox' );

/**
 * Renders the text editor in the language metabox
 * @param stdClass $post 
 */
function language_create_metabox ( $post ) {
  $language_content = get_post_meta ( $post -> ID, '_language_input', true );
  $language_title = get_post_meta ( $post -> ID, '_language_title_input', true );

  echo '<div>';
  echo '<input type="text" name="languagetitleinput" size="30" value="' . esc_attr ( htmlspecialchars ( $language_title ) ) . '" id="languagetitleinput" autocomplete="off">';
  echo '</div>';

  wp_editor ( $language_content, 'languageinput', array (
    'media_buttons' => false,
  ) );
}

/**
 * Saves the language info as a metadata value of the post
 * @global stdClass $post
 * @param array $data
 * @param array $postarr
 * @return array 
 */
function language_filter_handler ( $data, $postarr ) {
  global $post;
  if ( isset ( $postarr[ 'languagetitleinput' ] ) ) {
    update_post_meta ( $post -> ID, '_language_title_input', $postarr[ 'languagetitleinput' ] );
  }
  if ( isset ( $postarr[ 'languageinput' ] ) ) {
    update_post_meta ( $post -> ID, '_language_input', $postarr[ 'languageinput' ] );
  }
  return $data;
}

// hook the post edit/create/update action: language_filter_handler()
add_filter ( 'wp_insert_post_data', 'language_filter_handler', '99', 2 );

/**
 * Filters the excerpt from the current language. Returns it.
 * @param type $post_id
 * @return type 
 */
function language_get_the_excerpt ( $post_id = null, $length = 25, $more = '[...]' ) {
  $text = language_get_the_content ( $post_id );
  $excerpt_length = apply_filters ( 'excerpt_length', $length );
  $excerpt_more = apply_filters ( 'excerpt_more', ' ' . $more );
  $text = wp_trim_words ( $text, $excerpt_length, $excerpt_more );
  return $text;
}

/**
 * Echoes the posts excerpt in current language.
 * @param int $post_id 
 */
function language_the_excerpt ( $post_id = null, $length = 25, $more = '[...]' ) {
  echo language_get_the_excerpt ( $post_id, $length, $more );
}

/**
 *
 * @param type $post_id
 * @return type 
 */
function language_get_the_content ( $post_id = null ) {
  $post_id = ( null === $post_id ) ? get_the_ID () : $post_id;
  $language = get_bloginfo ( 'language' );

  if ( $language == 'es-ES' ) {
    $content = get_post_meta ( $post_id, '_language_input', true );
  } else {
    $content_post = get_post ( $post_id );
    $content = $content_post -> post_content;
  }

  return apply_filters ( 'the_content', $content );
}

/**
 *
 * @param int $post_id 
 */
function language_the_content ( $post_id ) {
  echo language_get_the_content ( $post_id );
}

function language_get_taxonomy_content ( $term ) {
  $language = get_bloginfo ( 'language' );

  if ( $language == 'es-ES' ) {
    $content = get_term_meta ( $term -> term_id, '_language_input', true );
  } else {
    $content = $term -> description;
  }

  return apply_filters ( 'the_content', $content );
}

function language_the_taxonomy_content ( $term ) {
  echo language_get_taxonomy_content ( $term );
}

function language_get_the_title ( $post_id = null ) {
  $post_id = ( null === $post_id ) ? get_the_ID () : $post_id;
  $language = get_bloginfo ( 'language' );

  $title_post = get_post ( $post_id );
  $title = $title_post -> post_title;

  if ( $language == 'es-ES' ) {
    $language_title = get_post_meta ( $post_id, '_language_title_input', true );
    $title = trim ( $language_title ) == '' ? $title : $language_title;
  }

  return apply_filters ( 'the_title', $title );
}

function language_the_title ( $post_id = null ) {
  echo language_get_the_title ( $post_id );
}

/**
 * Add the query var to the allowed variables in wp
 * @param array $public_query_vars
 * @return array 
 */
function language_query_vars ( $public_query_vars ) {
  $public_query_vars[ ] = 'lan';
  return $public_query_vars;
}

// hook the query_vars hook: language_query_vars
add_filter ( 'query_vars', 'language_query_vars' );

function language_taxonomy_add_language ( $term ) {
  $content = get_term_meta ( $term -> term_id, '_language_input', true );
  ?>
  <tr class="form-field">
    <th scope="row" valign="top">
      <label for="languagenput">EspaÃ±ol</label>
    </th>
    <td>
      <textarea name="languageinput" id="languageinput" rows="5" cols="50" class="large-text"><?php echo $content; ?></textarea>
      <br />
      <span class="description"><?php _e ( 'The description is not prominent by default, however some themes may show it.' ); ?></span>
    </td>
  </tr>
  <?php
  //echo '<div id="help-me-out">hola coca cola</div>';
  //return apply_filters ( 'the_content', $content );
}

// taxonomy term add language fields:
add_action ( 'region_edit_form_fields', 'language_taxonomy_add_language' );

function language_taxonomy_post_filter ( $term_id ) {
  $content = '';
  if ( isset ( $_POST[ 'languageinput' ] ) ) {
    $content = $_POST[ 'languageinput' ];
  }
  update_term_meta ( $term_id, '_language_input', $content );
}

//
add_action ( 'edited_region', 'language_taxonomy_post_filter', 10, 2 );

function language_attachment_caption ( $attachment_id ) {
  echo language_get_attachment_caption ( $attachment_id );
}

function language_get_attachment_caption ( $attachment_id ) {
  $attachment = get_post ( $attachment_id );
  $language = get_bloginfo ( 'language' );
  $caption = '';
  switch ( $language ) {
    case 'es-ES':
      $caption = empty ( $attachment -> post_content ) ? $attachment -> post_excerpt : $attachment -> post_content;
      break;
    default:
      $caption = empty ( $attachment -> post_excerpt ) ? $attachment -> post_content : $attachment -> post_excerpt;
      break;
  }

  return trim ( strip_tags ( $caption ) );
}
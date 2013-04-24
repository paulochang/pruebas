<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class (); ?>></div>

<h1 id="press-title" class="margin-center uppercase txt-center border-bottom">&#47;<?php _e ( 'Press', 'c41' ); ?>&#47;</h1>

<div id="press-content" class="margin-center fixed-width txt-center">
  <?php echo language_the_content ( get_queried_object_id () ); ?>

  <div class="fb-like margin-center" data-href="<?php the_permalink (); ?>" data-send="false" data-width="450" data-show-faces="false"></div>
</div>

<?php
if ( ! ajax () )
  get_footer (); ?>
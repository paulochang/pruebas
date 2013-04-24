<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class (); ?>></div>

<h1 id="people-title" class="margin-center uppercase txt-center border-bottom">&#47;<?php _e ( 'People', 'c41' ); ?>&#47;</h1>

<div id="contact-info" class="margin-center fixed-width">
  <?php echo language_the_content ( get_queried_object_id () ); ?>
</div>

<div class="margin-center fixed-width">
  <div class="fb-like" data-href="<?php the_permalink (); ?>" data-send="false" data-width="450" data-show-faces="false"></div>
</div>

<?php
if ( ! ajax () )
  get_footer (); ?>
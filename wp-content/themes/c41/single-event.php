<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class (); ?>></div>

<h1 id="event-title" class="margin-center uppercase txt-center border-bottom">&#47;<?php _e ( 'Archive', 'c41' ); ?>&#47;</h1>


<div class="archive-layout fixed-width margin-center">
  <?php if ( have_posts () ) : ?>
    <?php the_post (); ?>
    <div class="event-item margin-center event-<?php echo $post -> ID ?>">
      <h2 class="margin-center uppercase"><?php the_title (); ?></h2>
      <?php the_content ( ); ?>

      <div class="fb-like" data-href="<?php the_permalink (); ?>" data-send="false" data-width="450" data-show-faces="false"></div>

    </div>
  <?php endif; ?>
  <a class="back-to-archive uppercase block fixed-width margin-center line-through" href="<?php echo get_post_type_archive_link ( 'event' ) ?>">&#47;<?php _e ( 'Back To Archive', 'c41' ); ?>&#47;</a>
</div>

<?php
if ( ! ajax () )
  get_footer (); ?>
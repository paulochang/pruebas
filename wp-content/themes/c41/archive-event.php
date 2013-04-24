<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class (); ?>></div>

<?php $archive = get_event_archive (); ?>

<h1 id="event-title" class="margin-center uppercase txt-center border-bottom">&#47;<?php _e ( 'Archive', 'c41' ); ?>&#47;</h1>

<div class="margin-center">
  <?php while ( $archive -> have_posts () ) : ?>
    <?php $archive -> the_post (); ?>
    <a class="pointer block event-item fixed-width margin-center post-<?php echo $post -> ID ?>" href="<?php the_permalink (); ?>">
      <div class="thumbnail float-left">
        <?php the_post_thumbnail ( 'event-thumbnail' ); ?>
      </div>
      <div class="excerpt float-left">
        <h2 class="uppercase"><?php the_title () ?></h2>
      </div>
      <div class="float-right relative block">
        <?php the_date(); ?>
        <?php //echo apply_filters ( 'the_excerpt', $post -> post_excerpt ); ?>
        <span class="uppercase block absolute txt-center transition-left transition-background-color"><?php _e ( 'View Images', 'c41' ); ?></span>
      </div>
      <div class="clear"></div>
    </a>
  <?php endwhile; ?>
  <?php c41_pagination ( 'event' ); ?>
</div>

<?php if ( ! ajax () ) get_footer (); ?>

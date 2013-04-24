<?php if ( ! ajax () ) get_header () ; ?>

<div <?php body_class () ; ?>></div>

<?php $now = c41_lastest_project (); ?>

<a id="home-tag" class="block margin-center relative" href="<?php echo home_url ( 'now' ) ; ?>">
  <div class="absolute background-white opacity-background"></div>
  <div class="absolute txt-center uppercase">
    <h2>V&#47;<?php _e ( 'Now', 'c41' ) ; ?>&#47;<?php _e ( 'Now', 'c41' ) ; ?>&#47;<?php _e ( 'Now', 'c41' ) ; ?>&#47;V</h2>
    <?php language_the_title ( $now[ 'ID' ] ) ; ?>
  </div>
</a>

<?php if ( ! ajax () ) get_footer () ; ?>

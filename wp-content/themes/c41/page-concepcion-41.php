<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class (); ?>></div>

<!--<div class="gallery page-gallery margin-center relative">
  <?php foreach ( array ( 93, 92, 91, 90 ) as $attachment ) : ?>
    <?php echo wp_get_attachment_image ( $attachment, 'page-gallery', false, array ( 'class' => 'image absolute' ) ); ?>
  <?php endforeach; ?>
  <div class="next no-repeat absolute pointer"></div>
  <div class="prev no-repeat absolute pointer"></div>
  <div class="selectors absolute">
    <?php foreach ( array ( 93, 92, 91, 90 ) as $attachment ) : ?>
      <div class="selector float-right transition-background-color pointer" data-att="<?php echo $attachment; ?>"></div>
    <?php endforeach; ?>
    <div class="clear"></div>
  </div>
</div>-->
<div class="margin-center fixed-width">
  <?php echo language_get_the_content ( $page -> ID ); ?>
</div>

<div class="margin-center fixed-width">
  <div class="fb-like" data-href="<?php the_permalink (); ?>" data-send="false" data-width="450" data-show-faces="false"></div>
</div>
<?php if ( ! ajax () ) get_footer (); ?>

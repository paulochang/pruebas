<div class="gallery page-gallery margin-center relative">
  <?php foreach ( $attachment_ids as $attachment ) : ?>
    <?php echo wp_get_attachment_image ( $attachment, 'page-gallery', false, array ( 'class' => 'image absolute' ) ); ?>
  <?php endforeach; ?>
  <div class="next no-repeat absolute pointer"></div>
  <div class="prev no-repeat absolute pointer"></div>
  <div class="selectors absolute">
    <?php foreach ( $attachment_ids as $attachment ) : ?>
      <div class="selector float-right transition-background-color pointer" data-att="<?php echo $attachment; ?>"></div>
    <?php endforeach; ?>
    <div class="clear"></div>
  </div>
</div>
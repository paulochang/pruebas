<div class="pagination-links margin-center txt-middle">
  <?php if ( $previous_page ) : ?>
    <a class="prev page-numbers block txt-center float-left line-through" href="<?php echo get_post_type_archive_link ( $post_type ) . '?page=' . $previous_page; ?>">&#47;<?php _e ( 'Newer Entries', 'c41' ) ?>&#47;</a>
  <?php else: ?>
    <span class="prev page-numbers block txt-center float-left line-through"></span>
  <?php endif; ?>

  <?php foreach ( $pages as $page ) : ?>
    <?php if ( $page === 0 ) : ?>
      <span class="page-numbers block txt-center float-left"></span>
    <?php elseif ( $page === $current_page ): ?>
      <span class="page-numbers current block txt-center float-left"><?php echo $page; ?></span>
    <?php else: ?>
      <a class="page-numbers block txt-center float-left line-through" href="<?php echo get_post_type_archive_link ( $post_type ) . '?page=' . $page; ?>"><?php echo $page; ?></a>
    <?php endif; ?>
  <?php endforeach; ?>

  <?php if ( $next_page ) : ?>
    <a class="next page-numbers block txt-center float-right line-through" href="<?php echo get_post_type_archive_link ( $post_type ) . '?page=' . $next_page; ?>">&#47;<?php _e ( 'Older Entries', 'c41' ) ?>&#47;</a>
  <?php else: ?>
    <span class="next page-numbers block txt-center float-right"></span>
  <?php endif; ?>
  <div class="clear"></div>
</div>
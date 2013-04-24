<?php if ( ! ajax () ) get_header (); ?>

<div <?php body_class ( ); ?>></div>

<div id="blog-header" class="border-bottom margin-center">
  <h1 class=" float-left border-right uppercase txt-right">&#47;CO-BLOG&#47;<span class="inline-block"></span></h1>
  <div class="float-right">
    <div class="blog-text">
      <?php $text = get_page_by_path ( 'co-blog-text' ); ?>
      <?php echo language_the_content ( $text -> ID ); ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="archive-layout margin-center">
  <?php if ( have_posts () ) : ?>
    <?php the_post (); ?>
    <div class="co-blog-item margin-center post-<?php echo $post -> ID ?>">
      <h3 class="margin-center uppercase">
        <a class="line-through" href="<?php echo get_author_posts_url ( $post -> post_author, get_the_author_meta ( 'user_nicename', $post -> post_author ) ); ?>">
          Blogger: <?php echo the_author_meta ( 'display_name', $post -> post_author ); ?>
        </a>
      </h3>
      <h2 class="margin-center uppercase">
        <a class="line-through" href="<?php the_permalink (); ?>">
          <?php the_title (); ?>
        </a>
      </h2>

      <?php echo apply_filters ( 'the_content', apply_filters ( 'the_excerpt', $post -> post_content ) ); ?>

      <div class="txt-content">
      <p class="footer uppercase">  
        <a href="<?php echo get_author_posts_url ( $post -> post_author, get_the_author_meta ( 'user_nicename', $post -> post_author ) ); ?>">
          Posted By: <?php echo the_author_meta ( 'display_name', $post -> post_author ); ?>
        </a>
        <br/>
        <?php the_date (); ?>
        <br/>
        TAGS:
        <?php foreach ( wp_get_post_tags ( $post -> ID ) as $tag ) : ?>
          <a class="line-through" href="<?php echo get_tag_link ( $tag -> term_id ); ?>">
            <?php echo $tag -> name; ?>,</a>
          <?php endforeach; ?>
      </p>
      </div>
      
      <div class="fb-like" data-href="<?php the_permalink (); ?>" data-send="false" data-width="450" data-show-faces="false"></div>
      
    </div>
  <?php endif; ?>
  <a class="back-to-archive uppercase block fixed-width margin-center line-through" href="<?php echo get_post_type_archive_link ( 'post' ) ?>">&#47;<?php _e ( 'Back To Co-Blog', 'c41' ); ?>&#47;</a>
</div>

<?php if ( ! ajax () ) get_footer (); ?>
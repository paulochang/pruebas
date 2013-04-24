<?php if ( ! ajax () ) get_header () ; ?>

<div <?php body_class ( 'co-blog-archive' ) ; ?>></div>

<?php $archive = get_co_blog_archive () ; ?>
<div id="blog-header" class="border-bottom margin-center">
  <h1 class="float-left border-right uppercase txt-right">&#47;CO-BLOG&#47;<span class="inline-block"></span></h1>
  <div class=" float-right">
    <div class="blog-text">
      <?php $text = get_page_by_path ( 'co-blog-text' ) ; ?>
      <?php echo language_the_content ( $text->ID ) ; ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="margin-center">
  <?php $l = 0 ; ?>
  <?php while ( $archive->have_posts () ) : ?>
    <?php $archive->the_post () ; ?>
    <div class="co-blog-item margin-center post-<?php echo $post->ID ?>">
      <h3 class="margin-center uppercase">
        <a class="line-through" href="<?php echo get_author_posts_url ( $post->post_author, get_the_author_meta ( 'user_nicename', $post->post_author ) ) ; ?>">
          Blogger: <?php echo the_author_meta ( 'display_name', $post->post_author ) ; ?>
        </a>
      </h3>
      <h2 class="margin-center uppercase">
        <a class="line-through" href="<?php the_permalink () ; ?>">
          <?php the_title () ; ?>
        </a>
      </h2>
      <?php c41_post_front ( $post->ID ) ; ?>
      <?php //the_post_thumbnail ( 'page-gallery', false, array ( 'class' => 'image' ) ); ?>

      <div class="txt-content">
        <p>        
          <?php c41_post_excerpt ( $post, 55 ) ; ?>
        </p>
      </div>

      <div class="txt-content">
        <p class="footer uppercase">  
          <a href="<?php echo get_author_posts_url ( $post->post_author, get_the_author_meta ( 'user_nicename', $post->post_author ) ) ; ?>">
            <?php _e ( 'Posted By', 'c41' ) ; ?>:
            <?php echo the_author_meta ( 'display_name', $post->post_author ) ; ?>
          </a>
          <br/>
          <?php the_date () ; ?>
          <br/>
          <?php _e ( 'Etiquetas', 'c41' ) ; ?>:
          <?php foreach ( wp_get_post_tags ( $post->ID ) as $tag ) : ?>
            <a class="line-through" href="<?php echo get_tag_link ( $tag->term_id ) ; ?>">
              <?php echo $tag->name ; ?>,</a>
          <?php endforeach ; ?>
        </p>
      </div>

      <a class="more-info block pointer line-through uppercase border-all txt-center" href="<?php the_permalink () ; ?>"><?php _e ( 'Read More', 'c41' ) ; ?></a>

      <div class="fb-like" data-href="<?php the_permalink () ; ?>" data-send="false" data-width="450" data-show-faces="false"></div>
      <?php if ( $l ++ < 2 ) : ?> 
        <div class="border-bottom"></div>
      <?php endif ; ?>
    </div>
  <?php endwhile ; ?>
</div>
<?php c41_pagination () ; ?>

<?php if ( ! ajax () ) get_footer () ; ?>

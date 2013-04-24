<?php if ( ! ajax () ) get_header () ; ?>

<div <?php body_class () ; ?>></div>

<h1 id="project-title" class="margin-center uppercase txt-center border-bottom">&#47;<?php _e ( 'Projects', 'c41' ) ; ?>&#47;</h1>


<div class="archive-layout fixed-width margin-center">
  <?php if ( have_posts () ) : ?>
    <?php the_post () ; ?>
    <div class="project-item margin-center project-<?php echo $post->ID ?>">
      <h2 class="margin-center uppercase"><?php language_the_title ( $post->ID ) ; ?></h2>
      <?php language_the_content ( $post->ID ) ; ?>
      <p class="footer uppercase no-display">  
        <a href="<?php echo get_author_posts_url ( $post->post_author, get_the_author_meta ( 'user_nicename', $post->post_author ) ) ; ?>">
          Posted By: <?php echo the_author_meta ( 'display_name', $post->post_author ) ; ?>
        </a>
        <br/>
        <?php the_date () ; ?>
      </p>

      <div class="fb-like" data-href="<?php the_permalink () ; ?>" data-send="false" data-width="450" data-show-faces="false"></div>

    </div>
  <?php endif ; ?>
  <a class="back-to-archive uppercase block fixed-width margin-center line-through" href="<?php echo get_post_type_archive_link ( 'project' ) ?>">&#47;<?php _e ( 'Back To Projects', 'c41' ) ; ?>&#47;</a>
</div>

<?php
if ( ! ajax () )
  get_footer () ; ?>
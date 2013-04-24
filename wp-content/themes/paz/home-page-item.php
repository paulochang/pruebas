<a href="<?php the_permalink() ?>" class="block relative thumb-a" >
	<?php the_post_thumbnail( 'proyecto-thumb' ) ?>
	<div class="absolute transition-opacity thumb-hover opacity-hidden opacity-background-hover uppercase" > 
		<p><?php the_title()?></p>
	</div>
</a>
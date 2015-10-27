<?php /*

Peek Theme
-------------

content.php

Default post template	

*/


$extra_post_classes = array();
if (!is_single())
	$extra_post_classes[] = 'listed'; 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($extra_post_classes); ?>>

	<?php
	$featured_image = peek_featured_image();
	if ($featured_image) :
	?>
	<div class="featured-image">
		<img src="<?php echo $featured_image['url']; ?>" width="<?php echo $featured_image['width']; ?>" height="<?php echo $featured_image['height']; ?>" />
	</div>
	<?php endif; ?>

	<div class="content">
		<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
		?>
		<?php if (!is_singular()) : ?>

		<?php the_excerpt(); ?>
		<p class="more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Keep reading<span class="meta-nav">&hellip;</span>', 'peek' ); ?></a></p>

		<?php else : ?>

		<?php the_content(); ?>

		<?php wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'peek' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		?>
		<?php endif; ?>
	</div><!-- .content -->

</article><!-- #post-## -->

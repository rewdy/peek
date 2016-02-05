<?php /*

Peek Theme
-------------

content.php

Default post template

*/

// set up classes
$extra_post_classes = array();
if (!is_single())
	$extra_post_classes[] = 'listed';

if (get_the_post_thumbnail() != '') {
	// get the URL of the featured image
	$header_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'featured-image-small');
	$featured_image['url'] = $header_image[0];
	$featured_image['width'] = $header_image[1];
	$featured_image['height'] = $header_image[2];
} else {
	$featured_image = false;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($extra_post_classes); ?>>

	<div class="content">
		<?php
			peek_the_post_title();
		?>
		<?php if (!is_singular()) : ?>

		<?php if ($featured_image) : ?>
		<div class="featured-image">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $featured_image['url']; ?>" width="<?php echo $featured_image['width']; ?>" height="<?php echo $featured_image['height']; ?>" alt="" /></a>
		</div>
		<?php endif; ?>

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

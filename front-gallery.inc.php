<?php /*

Peek Theme
-------------

front-gallery.php

Template - Front page gallery

*/
// Vars
$peek_thumbnail_style = 'height-gallery-thumbnail';
$peek_large_style = 'large'; // built-in style
$peek_full_style = 'full'; // built-in style

$gallery_id = peek_front_gallery();
if ($gallery_id) :

	$args = array(
		'post_type'			=> 'gallery',
		'post_status'		=> 'publish',
		'id'				=> $gallery_id,
		'posts_per_page'	=> 1,
	);
	$gallery_query = new WP_Query( $args );
	
	$gllr_options = get_option( 'gllr_options' );
	
	if ( $gallery_query->have_posts() ) :
	?>
	
	<div id="gallery-splash">
		
	<?php while ( $gallery_query->have_posts() ) : $gallery_query->the_post();

		$images_id = get_post_meta( $post->ID, '_gallery_images', true );
		// image query
		$image_args = array(
			"showposts"			=>	-1,
			"what_to_show"		=>	"posts",
			"post_status"		=>	"inherit",
			"post_type"			=>	"attachment",
			"orderby"			=>	$gllr_options['order_by'],
			"order"				=>	$gllr_options['order'],
			"post_mime_type"	=>	"image/jpeg,image/gif,image/jpg,image/png",
			'post__in'			=> explode( ',', $images_id ),
			'meta_key'			=> '_gallery_order_' . $post->ID
		);
		$image_query = new WP_Query( $image_args );

		if ( $image_query->have_posts() ) {
			$count_image_block = 0; 
		?>

		<div class="photo-grid-horizontal">
		<?php while ( $image_query->have_posts() ) : $image_query->the_post();
		$attachment = $post;
		$key = "gllr_image_text";
		// $link_key = "gllr_link_url";
		$alt_tag_key = "gllr_image_alt_tag";
		$image_attributes = wp_get_attachment_image_src( $attachment->ID, $peek_thumbnail_style );
		$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, $peek_large_style );
		$image_attributes_full = wp_get_attachment_image_src( $attachment->ID, $peek_full_style );
		?>

			<div class="photo-item" style="width:<?php echo $image_attributes[1] . 'px'; ?>; height:<?php echo $image_attributes[2] . 'px'; ?>; background-image:url(<?php echo $image_attributes[0]; ?>);">
				<!-- Image set with inline style -->
			</div><!-- .photo-item -->
		<?php $count_image_block++;
		endwhile;  ?>
		</div><!-- .photo-grid-horizontal -->
		<?php } ?>
	<?php endwhile; 
		
	?>
	
	</div> <!-- close #gallery-splash -->
	
<?php endif;
endif;


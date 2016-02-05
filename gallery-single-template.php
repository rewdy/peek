<?php /*

Peek Theme
-------------

gallery-single-template.php

Template - Gallery post
From the Gallery plugin

*/

// Vars
$peek_thumbnail_style = 'square-gallery-thumbnail';
$peek_large_style = 'large'; // built-in style
$peek_full_style = 'full'; // built-in style

<?php get_header(); ?>

	<article id="gallery-post-<?php the_ID(); ?>" <?php post_class($extra_post_classes); ?>>

		<?php global $post, $wp_query;
		$args = array(
			'post_type'				=> 'gallery',
			'post_status'			=> 'publish',
			'name'					=> $wp_query->query_vars['name'],
			'posts_per_page'		=> 1
		);
		$second_query = new WP_Query( $args );
		$gllr_options = get_option( 'gllr_options' );
		$gllr_download_link_title = addslashes( __( 'Download high resolution image', 'gallery-plugin' ) );
		if ( $second_query->have_posts() ) {
			while ( $second_query->have_posts() ) : $second_query->the_post(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<div class="gallery-box-single entry-content">
					<?php if ( ! post_password_required() ) {
						the_content();

						$images_id = get_post_meta( $post->ID, '_gallery_images', true );

						$posts = get_posts( array(
							"showposts"			=>	-1,
							"what_to_show"		=>	"posts",
							"post_status"		=>	"inherit",
							"post_type"			=>	"attachment",
							"orderby"			=>	$gllr_options['order_by'],
							"order"				=>	$gllr_options['order'],
							"post_mime_type"	=>	"image/jpeg,image/gif,image/jpg,image/png",
							'post__in'			=> explode( ',', $images_id ),
							'meta_key'			=> '_gallery_order_' . $post->ID
						));

						if ( count( $posts ) > 0 ) {
							$count_image_block = 0; ?>

							<div id="photo-grid" class="row">
							<?php foreach ( $posts as $attachment ) {
								$key = "gllr_image_text";
								$link_key = "gllr_link_url";
								$alt_tag_key = "gllr_image_alt_tag";

								$image_attributes = wp_get_attachment_image_src( $attachment->ID, $peek_thumbnail_style );

								$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, $peek_large_style );

								$image_attributes_full = wp_get_attachment_image_src( $attachment->ID, $peek_full_style );

								// get number of images per row
								$peek_img_per_row = $gllr_options['custom_image_row_count'];
								// if doable, set the class properly. otherwise it's 3 per row.
								switch ($peek_img_per_row) {
									case 1:
										$peek_gllr_gclass = 'g12';
										break;
									case 2:
										$peek_gllr_gclass = 'g6';
										break;
									case 3:
										$peek_gllr_gclass = 'g4';
										break;
									case 4:
										$peek_gllr_gclass = 'g3';
										break;
									case 6:
										$peek_gllr_gclass = 'g2';
										break;
									default:
										$peek_gllr_gclass = 'g4';
								}

								?>
								<div class="photo-item ripple <?php echo $peek_gllr_gclass ?>">
									<?php if ( ( $url_for_link = get_post_meta( $attachment->ID, $link_key, true ) ) != "" ) { ?>
										<a href="<?php echo $url_for_link; ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>">
											<?php if (peek_lazy_load_enabled()) : ?>
											<img alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo peek_lazy_load_holder_src(); ?>" data-src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
											<?php else : ?>
											<img alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
											<?php endif; ?>
										</a>
									<?php } else { ?>
									<a rel="gallery_fancybox<?php if ( 0 == $gllr_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>" href="<?php echo $image_attributes_large[0]; ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" >
										<?php if (peek_lazy_load_enabled()) : ?>
										<img alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo peek_lazy_load_holder_src(); ?>" data-src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
										<?php else : ?>
										<img alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
										<?php endif; ?>
									</a>
									<?php } ?>
									<?php if ( 1 == $gllr_options["image_text"] ) { ?>
										<div class="photo-item-text"><?php echo get_post_meta( $attachment->ID, $key, true ); ?></div>
									<?php } ?>
								</div><!-- .photo-item -->
								<?php $count_image_block++;
							}  ?>
							</div><!-- #photo-grid.row -->
						<?php } ?>
					<?php } else { ?>
						<p><?php echo get_the_password_form(); ?></p>
					<?php }
				endwhile;
			if ( 1 == $gllr_options['return_link'] ) {
				if ( 'gallery_template_url' == $gllr_options["return_link_page"] ) {
					global $wpdb;
					$parent = $wpdb->get_var( "SELECT $wpdb->posts.ID FROM $wpdb->posts, $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value = 'gallery-template.php' AND (post_status = 'publish' OR post_status = 'private') AND $wpdb->posts.ID = $wpdb->postmeta.post_id" );	?>
					<div class="return_link"><a href="<?php echo ( !empty( $parent ) ? get_permalink( $parent ) : '' ); ?>"><?php echo $gllr_options['return_link_text']; ?></a></div>
				<?php } else { ?>
					<div class="return_link"><a href="<?php echo $gllr_options["return_link_url"]; ?>"><?php echo $gllr_options['return_link_text']; ?></a></div>
				<?php }
			} ?>
			</div><!-- .gallery-box-single -->
		<?php } else { ?>
			<div class="gallery-box-single">
				<p class="not_found"><?php _e( 'Sorry, nothing found.', 'gallery-plugin' ); ?></p>
			</div><!-- .gallery-box-single -->
		<?php } ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if (comments_open() || get_comments_number()) :
			 comments_template();
		endif;
		?>

	</article><!-- article -->

	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$("a[rel=gallery_fancybox<?php if ( 0 == $gllr_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>]").fancybox({
					'transitionIn'			: 'elastic',
					'transitionOut'			: 'elastic',
					'titlePosition' 		: 'inside',
					'speedIn'				:	500,
					'speedOut'				:	300,
					'titleFormat'			: function( title, currentArray, currentIndex, currentOpts ) {
						return '<div id="fancybox-title-inside">' + ( title.length ? '<span id="bws_gallery_image_title">' + title + '</span><br />' : '' ) + '<span id="bws_gallery_image_counter"><?php _e( "Image", "gallery-plugin" ); ?> ' + ( currentIndex + 1 ) + ' / ' + currentArray.length + '</span></div><?php if( get_post_meta( $post->ID, 'gllr_download_link', true ) != '' ){?><a id="bws_gallery_download_link" href="' + $( currentOpts.orig ).attr('rel') + '" target="_blank"><?php echo $gllr_download_link_title; ?> </a><?php } ?>';
					}<?php if ( $gllr_options['start_slideshow'] == 1 ) { ?>,
					'onComplete':	function() {
						clearTimeout( jQuery.fancybox.slider );
						jQuery.fancybox.slider = setTimeout("jQuery.fancybox.next()",<?php echo $gllr_options['slideshow_interval']; ?>);
					}<?php } ?>
				});
			});
		})(jQuery);
	</script>
<?php get_footer(); ?>
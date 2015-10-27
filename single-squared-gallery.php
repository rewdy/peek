<?php /*

Peek Theme
-------------

single.php

WP Post Template: Squared image gallery

*/

?>
<?php get_header(); ?>

							<?php /* Start the Loop */ ?>
							<?php while (have_posts()) : the_post(); ?>

							<?php get_template_part('content/content', get_post_type()); ?>
							
							<?php 
							$galleryimages = get_attachments_gallery('square');
							if ($galleryimages) :
							
							/*
							
							ADD JS HERE TO INITIALIZE; USE PHP TO GET ARRAY OF ITEMS;
							// if photoswipe should be enabled
							if (jQuery('.pswp-triggers').length) {
								// pswp element
								var pswpElement = document.querySelectorAll('.pswp')[0];
								
								var items 
							}
							*/
							
							?>
							<div id="photo-grid" class="pswp-triggers row">
							<?php foreach($galleryimages as $image) : ?>
								
								<div class="photo-item ripple g3">
									<?php print $image; ?>
								
								</div>
								
							<?php endforeach; ?>
							</div>
							<?php endif; ?>
							
							<?php // If comments are open or we have at least one comment, load up the comment template.
								if (comments_open() || get_comments_number()) :
									 comments_template();
								endif;
								
								// Previous/next post navigation.
								the_post_navigation(array(
									'next_text' => '<span class="meta-nav nav-next">' . __('Next post', 'peek') . ': %title</span>',
									'prev_text' => '<span class="meta-nav nav-previous">' . __('Previous post', 'peek') . ': %title</span>',
								));
							?>
							
							<?php endwhile; ?>

<?php get_footer(); ?>
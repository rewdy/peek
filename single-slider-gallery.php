<?php /*

Peek Theme
-------------

single.php

WP Post Template: Slider gallery

*/

?>
<?php get_header(); ?>

							<?php /* Start the Loop */ ?>
							<?php while (have_posts()) : the_post(); ?>

							<?php get_template_part('content/content', get_post_type()); ?>
							
							<?php 
							$galleryimages = get_attachments_gallery('full', false);
							if ($galleryimages) :
							
							// pull in Flexslider
							wp_enqueue_script('flexslider', get_template_directory_uri() . '/lib/flexslider/jquery.flexslider-min.js', 'jquery', '2.5.0', true);
							
							?>
							<div id="photo-slider" class="flexslider">
								<ul class="slides">
							<?php foreach($galleryimages as $image) : ?>
								
									<li class="photo-item">
										<?php print $image; ?>
									</li>
							<?php endforeach; ?>
							
								</ul>
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
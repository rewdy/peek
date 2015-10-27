<?php /*

Peek Theme
-------------

index.php

Main template file	

*/

?>
<?php get_header(); ?>

							<?php /* Start the Loop */ ?>
							<?php while (have_posts()) : the_post(); ?>

							<?php get_template_part('content/content', get_post_type()); ?>

							<?php endwhile; ?>

							<?php if (!is_singular()) : ?>

							<div class="directional-links pagination">
								<?php if (get_next_posts_link() != '') :?>
								<div class="nav-previous"><?php next_posts_link('<i class="fa fa-angle-left"></i> <span class="text">Older posts</span>'); ?></div>
								<?php endif; ?>
								<?php if (get_previous_posts_link() != '') :?>
								<div class="nav-next"><?php previous_posts_link('<span class="text">Newer posts</span> <i class="fa fa-angle-right"></i>'); ?></div>
								<?php endif; ?>
							</div>

							<?php endif; ?>

<?php get_footer(); ?>
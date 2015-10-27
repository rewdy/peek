<?php /*

Peek Theme
-------------

footer.php

Footer template file	

*/

?>
					</div>
				</div> <!-- close .grid.row -->
			</div> <!-- close #content-body -->

			<footer id="site-footer">
				<div class="grid">
					<?php get_sidebar('footer'); ?>

					<div class="g12 text-center border">
						<div class="lined">
							<p>&copy; <?php echo date('Y'); ?> All rights reserved. | <a href="<?php echo site_url(); ?>">Home</a> | <a href="#top">Top</a></p>
						</div>
					</div>
				</div> <!-- close .grid -->
			</footer> <!-- close footer#site-footer -->

		</div> <!-- close #content-wrapper -->

		<?php
		if (is_single()) {
			include 'includes/photoswipe_element.php'; 
		} 
		?>

		<?php wp_footer(); ?>

	</body>
</html>
<?php /*

Readium Theme
-------------

sidebar-drawer.php

Sidebar drawer template file

*/

?>
<div id="drawer">
	<div class="drawer-closer"><a href="#close-drawer" class="drawer-link"><i class="fa fa-arrow-left"></i> Close</a></div>
	<?php if (is_active_sidebar('drawer-widgets')) : ?>

	<div id="drawer-widgets">
		<?php dynamic_sidebar('drawer-widgets'); ?>

	</div>
	<?php endif; ?>
</div>
				
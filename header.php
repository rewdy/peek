<?php /*

Peek Theme
-------------

header.php

Header template file

*/

$body_class = array();
if (is_front_page()) {
	$body_class[] = 'front';
}
if (is_admin_bar_showing()) {
	$body_class[] = 'admin-bar';
}
if (is_active_sidebar('splash') && is_front_page()) {
	$body_class[] = 'splash';
} else {
	$body_class[] = 'no-splash';
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />

		<title><?php (wp_title('', false) != '') ? wp_title('&#8226;', true, 'right') : ''; ?><?php bloginfo('name'); ?></title>

		<!-- Meta -->
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- Links -->
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<!-- Stylesheets -->
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<?php
		// Stylesheets
		wp_enqueue_style('peek_style', get_template_directory_uri() . '/style.css', array(), '1.0', 'screen');
		wp_enqueue_style('brick_karla', '//brick.a.ssl.fastly.net/Karla:400,700,400i,700i', array(), '1.0', 'screen');
		if (is_single()) {
			wp_enqueue_style('photoswipe', get_template_directory_uri() . '/lib/photoswipe/photoswipe.css', array(), false, 'screen');
			wp_enqueue_style('photoswipe_ui', get_template_directory_uri() . '/lib/photoswipe/default-skin/default-skin.css', array(), false, 'screen');
		}

		// Javascript

		// pull in the jQuery
		wp_enqueue_script('jquery');

		// pull in the site js
		wp_enqueue_script('peek_interactions', get_template_directory_uri() . '/js/peek-interactions.js', 'jquery', false, true);
		wp_enqueue_script('peek_animations', get_template_directory_uri() . '/js/peek-animations.js', 'jquery', false, true);

		if (is_single()) {
			wp_enqueue_script('photoswipe_js', get_template_directory_uri() . '/lib/photoswipe/photoswipe.min.js', array(), false, true);
			wp_enqueue_script('photoswipe_ui_js', get_template_directory_uri() . '/lib/photoswipe/photoswipe-ui-default.min.js', array(), false, true);
		}

		// comment script
		if (is_singular() && get_option('thread_comments')) :
			wp_enqueue_script('comment-reply');
		endif;
		?>

		<?php
		// Wordpress header content
		wp_head(); ?>

	</head>
	<body class="<?php echo implode(' ', $body_class); ?>">

		<header id="site-header">
			<div class="grid">
				<div class="g12">
					<nav id="nav-holder" role="navigation">
						<div class="assistive-text">Main menu</div>
						<?php
							$menu_args = array(
								'theme_location' => 'primary',
								'container' => false,
								'menu_class' => 'menu',
							);
						?>
						<?php wp_nav_menu($menu_args); ?>
					</nav>
					<div id="drawer-link"><a href="#drawer" class="drawer-link"><i class="fa fa-bars"></i><span class="text">Menu</span></a></div>
					<?php $title_tag = (!is_single()) ? 'h1' : 'div'; ?>
					<<?php echo $title_tag; ?> id="site-title"><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></<?php echo $title_tag; ?>>
				</div>
			</div> <!-- close .grid -->
		</header> <!-- close header#site-header -->

		<?php if (is_active_sidebar('splash') && is_front_page()) : ?>
		<div id="splash-holder">

			<?php dynamic_sidebar('splash'); ?>
			
		</div>
		<?php endif; ?>

		<div id="content-wrapper">
			<div id="content-body">
				<div class="grid">

					<div class="g12 listing">
<?php /*

Peek Theme
-------------

functions.php

Functions file

*/

/**
 * Initiating settings
 */

// Add automatic feed links
add_theme_support('automatic-feed-links');

// Enable post thumbnails
add_theme_support('post-thumbnails');

// Add some image sizes for featured images
add_image_size('featured-image', 1600, 800, true);
add_image_size('featured-image-small', 900, 450, true);
// Add images sizes for gallery thumbnails
add_image_size('proportional-gallery-thumbnail', 600, 1800); // 600px wide, up to 3 times as tall. No crop so should be like only setting the width
add_image_size('square-gallery-thumbnail', 600, 600, true);
add_image_size('full-gallery-thumbnail', 1600, 1040, true);

// Add menus
if (function_exists('register_nav_menu')) {
	register_nav_menu('primary', 'Main Menu');
	register_nav_menu('footer', 'Footer Menu');
}

// Content width
if (!isset($content_width)) {
	$content_width = 724;
}

/**
 * Setup Widget Areas
 */
function peek_widget_init() {
	// Register drawer widgets
	register_sidebar(
		array(
			'name' => __('Drawer'),
			'desc' => __('Place widgets in the "drawer" below the slide out menu.'),
			'id' => 'drawer-widgets',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);

	// Register footer widgets
	register_sidebar(
		array(
			'name' => __('Footer'),
			'desc' => __('Place widgets in the site footer. These look best in multiples of three (3, 6, etc).'),
			'id' => 'footer-widgets',
			'before_widget' => '<div id="%1$s" class="g4 widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'peek_widget_init');


/**
 * Custom Settings
 */
class Peek_Customize {
	public static function register($wp_customize) {
		// add the sections
		$wp_customize->add_section('peek_options',
			array(
				'title'			=> __('Peek Theme Options', 'peek'),
				'priority'		=> 55,
				'capability'	=> 'edit_theme_options',
				'description' 	=> __('Enable certain features of the theme.', 'peek')
			)
		);

		// Lazy load setting
		$wp_customize->add_setting('peek_use_lazy_load',
			array(
				'default' 	=> 1,
				'type'		=> 'option',
				'capability'=> 'edit_theme_options',
				'transport'	=> 'refresh',
			)
		);
		// Lazy load control
		$wp_customize->add_control('peek_use_lazy_load',
			array(
				'label'   => 'Use lazy loading for galleries?',
				'description' => __('This setting makes it so gallery images only load after the user scrolls to them on the page. This speeds up page load times and reduces bandwidth usage.'),
				'section' => 'peek_options',
				'type'    => 'radio',
				'choices'    => array(
					1 => 'Yes',
					0 => 'No',
				),
			)
		);

		// Show home page title setting
		$wp_customize->add_setting('peek_show_home_title',
			array(
				'default' 	=> 0,
				'type'		=> 'option',
				'capability'=> 'edit_theme_options',
				'transport'	=> 'refresh',
			)
		);
		// Show home page title control
		$wp_customize->add_control('peek_show_home_title',
			array(
				'label'   => 'Show the page title on the home page?',
				'description' => __('When a static page is set as the home page, the title is hidden unless this option is set to "yes".'),
				'section' => 'peek_options',
				'type'    => 'radio',
				'choices'    => array(
					1 => 'Yes',
					0 => 'No',
				),
			)
		);
		
		if (is_plugin_active('gallery-plugin/gallery-plugin.php')) {
			
			// Show front page gallery setting
			$wp_customize->add_setting('peek_show_front_gallery',
				array(
					'default' 	=> 0,
					'type'		=> 'option',
					'capability'=> 'edit_theme_options',
					'transport'	=> 'refresh',
				)
			);
			// Show front page gallery control
			$wp_customize->add_control('peek_show_front_gallery',
				array(
					'label'   => 'Should a gallery be shown on the front page?',
					'description' => __('If you would like to display a Gallery Plugin gallery on the front page, select "Yes".'),
					'section' => 'peek_options',
					'type'    => 'radio',
					'choices'    => array(
						1 => 'Yes',
						0 => 'No',
					),
				)
			);
			
			// Show front page gallery setting
			$wp_customize->add_setting('peek_front_gallery_id',
				array(
					'default' 	=> 0,
					'type'		=> 'option',
					'capability'=> 'edit_theme_options',
					'transport'	=> 'refresh',
				)
			);
			// Show front page gallery control
			$args = array(
				'post_type'				=> 'gallery',
				'post_status'			=> 'publish',
				'posts_per_page'		=> -1
			);
			// run a query to get the gallery options
			$galleries_query = new WP_Query( $args );
			if ( $galleries_query->have_posts() ) {
				$gallery_choices = array();
				while ( $galleries_query->have_posts() ) : $galleries_query->the_post();
					$gallery_choices[get_the_id()] = get_the_title();
				endwhile;
			} else {
				$gallery_choices = array(
					'0' => 'None available',
				);
			}
			$wp_customize->add_control('peek_front_gallery_id',
				array(
					'label'   => 'Select a gallery',
					'description' => __('Select a gallery. If a new gallery is needed, create it then return to this page to select it.'),
					'section' => 'peek_options',
					'type'    => 'select',
					'choices'    => $gallery_choices,
				)
			);
			
		}
	}
}
add_action('customize_register', array('Peek_Customize', 'register'));

/**
 * function to return the feature image
 */
function peek_featured_image() {
	$image = array();

	// Only check if singular
	if (is_singular()) {
		if (get_the_post_thumbnail() != '') {
			// get the URL of the featured image
			$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'featured-image');
			$image['url'] = $featured_image[0];
			$image['width'] = $featured_image[1];
			$image['height'] = $featured_image[2];
		}
	}

	return (!empty($image)) ? $image : false;
}

/**
 * Function to get the post title
 */
function peek_get_post_title() {
	$title = get_the_title();
	$output = false;
	if ( !is_singular() ) {
		// if listed
		$permalink = get_permalink();
		$output = '<h2 class="entry-title"><a href="' . $permalink . '" rel="bookmark">' . $title . '</a></h2>';
	}
	else if (is_front_page()) {
		// if front page
		if (peek_show_home_title()) {
			$output = '<h1 class="entry-title">' . $title . '</h1>';
		}
	}
	else if (!peek_featured_image()) {
		// if is singular
		// if not the front page
		// if not featured image
		$output = '<h1 class="entry-title">' . $title . '</h1>';
	}

	return $output;
}
function peek_the_post_title() {
	echo peek_get_post_title();
}

/**
 * Functions to return values to the theme
 */
function peek_lazy_load_enabled() {
	return get_option('peek_use_lazy_load');
}
function peek_lazy_load_holder_src() {
	return get_template_directory_uri() . '/img/loader.gif';
}
function peek_show_home_title() {
	return get_option('peek_show_home_title');
}

/**
 * Front Page Gallery Functions
 */
function peek_front_gallery() {
	$enabled = get_option('peek_show_front_gallery');
	$gallery_id = get_option('peek_front_gallery_id');
	// check if enabled and if gallery id is not 0.
	if ($enabled && $gallery_id) {
		// return the id
		return $gallery_id;
	} else {
		// if the gallery is disabled or no gallery is selected, return false
		return false;
	}
}

/**
 * Comment mods because the defaults here suck
 */
function peek_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		$args['avatar_size'] = 32;
		$args['reply_text'] = '<i class="fa fa-comments-o"></i><span class="text">'.__('Reply').'</span>';
?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?>>

			<article class="comment">

				<?php if ($comment->comment_approved == '0') : ?>
				<p class="comment-awaiting-moderation box-help"><?php _e('Your comment is awaiting moderation.') ?></p>
				<?php endif; ?>

				<?php comment_text() ?>

				<div class="links">
					<ul class="link-list">
						<li><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></li>
						<li><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" title="Permalink"><i class="fa fa-link"></i><span class="text">
							Comment permalink</span></a></li>
						<?php edit_comment_link('<i class="fa fa-pencil"></i><span class="text">Edit</span>','<li>','</li>'); ?>
					</ul>
				</div>
				<div class="details">
					<span class="avatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></span>
					<span class="comment-author vcard"><?php printf(__('<span class="says">Posted by</span> <cite class="fn">%s</cite>'), get_comment_author_link()) ?></span> &bullet;
					<span class="comment-date"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?></a></span>
				</div>

			</article>
		</li>
<?php
}

/**
 * The default Wordpress comment form
 * leaves a lot to be desired. Here is
 * a version that has more markup and is
 * easier to style.
 */
function peek_comment_form() {
	// define fields
	$fields = array(
		'author' => '<p class="form-item label-inline comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<span class="input-holder"><input id="author" name="author" type="text" class="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></span></p>',
		'email'  => '<p class="form-item label-inline comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<span class="input-holder"><input id="email" name="email" type="text" class="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></span></p>',
		'url'	=> '<p class="form-item label-inline comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		'<span class="input-holder"><input id="url" name="url" type="text" class="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></p>',
	);

	// build our new defaults array (based off of default defaults. customized values noted.
	$defaults = array(
		'fields'			=> apply_filters('comment_form_default_fields', $fields ), /* customized */
		'comment_field'		=> '<p class="form-item comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><span class="input-holder"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></span></p>', /* customized */
		'must_log_in'			=> '<p class="must-log-in help">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'			=> '<p class="logged-in-as help">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before'	=> '<p class="comment-notes help">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'	=> '<p class="some-html-allowed help small">' . sprintf(__('Some <abbr title="Hyper Text Markup Language">HTML</abbr> allowed: <code>%s</code>'), allowed_tags()) . '</p>', /* customized */
		'id_form'				=> 'commentform',
		'id_submit'				=> 'submit',
		'title_reply'			=> __( 'Leave a Comment' ),
		'title_reply_to'		=> __( 'Leave a Reply to %s' ),
		'cancel_reply_link'		=> __( 'Cancel Comment' ),
		'label_submit'			=> __( 'Post Comment' )
	);

	// send them back out! Bam!
	return $defaults;
}
add_filter('comment_form_defaults', 'peek_comment_form');

/**
 * Functions available in templates
*/

// Function to get attachement images array
function get_attachments_gallery($thumb_type = 'proportional', $include_link = true) {
	// set image style
	$image_size = $thumb_type . '-gallery-thumbnail';

	// get the attachements
	global $post;
	$images = get_children(array(
		'post_parent' => $post->ID,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
	));

	// make the gallery image array
	$galleryimages = array();
	if ($images) {
		foreach ($images as $image) {
			$image_thumb = wp_get_attachment_image($image->ID, $image_size);
			if ($include_link) {
				$image_src = wp_get_attachment_image_src($image->ID, 'large');
				$galleryimages[] = '<a href="' . $image_src[0] . '">' . $image_thumb . '</a>';
			} else {
				$galleryimages[] = $image_thumb;
			}
		}
	}

	// send it back
	return $galleryimages;
}

// Fuction to get the author posts link (the only built-in function echos it).
if (!function_exists('get_author_posts_link')) {
	// must be called from within the loop
	function get_author_posts_link() {
		$the_author = get_the_author();
		$author_url = get_author_posts_url(get_the_author_meta('ID'));
		return '<a href="' . $author_url . '">' . $the_author . '</a>';
	}
}

// Function(s) to generate a list of links for sharing
function get_share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	if (isset($url) && isset($title)) {
		$url = urlencode($url);
		$title = urlencode($title);

		$services['facebook'] = array(
			'label' => 'Facebook',
			'url'	=> 'http://www.facebook.com/sharer.php?s=100&amp;p[title]={{title}}&amp;p[url]={{url}}',
			'icon'	=> 'facebook',
		);
		$services['twitter'] = array(
			'label' => 'Twitter',
			'url'	=> 'https://twitter.com/intent/tweet?url={{url}}&amp;text={{title}}',
			'icon'	=> 'twitter',
		);
		$services['pinterest'] = array(
			'label'	=> 'Pinterest',
			'url'	=> 'http://www.pinterest.com/pin/create/bookmarklet/?url={{url}}&description={{title}}',
			'icon'	=> 'pinterest',
		);
		$services['tumblr'] = array(
			'label'	=> 'Tumblr',
			'url'	=> 'http://www.tumblr.com/share/?url={{url}}&description={{title}}',
			'icon'	=> 'tumblr',
		);
		$services['gplus'] = array(
			'label'	=> 'Google +',
			'url'	=> 'https://plus.google.com/share?url={{url}}',
			'icon'	=> 'google-plus',
		);
		$services['email']	= array(
			'label'	=> 'Email',
			'url'	=> 'mailto:?&amp;Subject={{title}}&amp;Body={{url}}',
			'icon'	=> 'envelope',
		);

		// build the output
		$output = '<ul class="' . $class . '">' . "\n";
		foreach ($services as $key => $service) {
			$extra = (isset($service['extra'])) ? ' '.$service['extra'] : '';
			$output .= "\t" . '<li><a href="'.$service[url].'" class="'.$key.'"'.$extra.'><i class="{{icon_prefix}}'.$service[icon].'"></i> <span class="text">'.$service[label].'</span></a></li>' . "\n";
		}
		$output .= '</ul>';

		$output = preg_replace('/{{url}}/', $url, $output);
		$output = preg_replace('/{{title}}/', $title, $output);
		$output = preg_replace('/{{icon_prefix}}/', $icon_prefix, $output);

		return $output;
	} else {
		// not enought data. return empty string.
		return '';
	}
}
function share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	echo get_share_links($url, $title, $class, $icon_prefix);
}

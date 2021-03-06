<?php

// Vars
$site_name = "Photo Blog";
$site_url = "http://localhost/phopho";

// Lorem Ipsum
require('lib/LoremIpsum.class.php');
$filler = new LoremIpsumGenerator;

// share links
require('lib/sharelinks.lib.php');

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title><?php echo $site_name; ?></title>

		<link rel="stylesheet" href="//brick.a.ssl.fastly.net/Karla:400,700,400i,700i">
		<link rel="stylesheet" href="lib/font-awesome-4.1.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">

		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="lib/packery.pkgd.min.js"></script>
		<script src="js/phopho-script.js"></script>

		<script>
			jQuery(function(){
				$('.photo-item').each(function(){
					var $me = $(this);
					$me.addClass('loading');
					$me.find('img').load(function(){
						$me.removeClass('loading');
					})
				})
			});
			jQuery(window).load(function(){
				var $photoGrid = $('#photo-grid');

				$photoGrid.packery({
					itemSelector: '.photo-item',
					gutter: 0
				});
			});
		</script>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.5">
		
	</head>
	<body class="no-splash">

		<header id="site-header">
			<div class="grid">
				<div class="g12">
					<!-- <div id="site-logo">
						<i class="fa fa-anchor fa-4x"></i>
					</div> -->
					<nav id="nav-holder">
						<ul class="menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="#">Photos</a></li>
							<li><a href="#">Pricing</a></li>
							<li><a href="blog.php">Blog</a></li>
							<li><a href="#">About</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</nav>
					<div id="drawer-link"><a href="#drawer" class="drawer-link"><i class="fa fa-bars"></i><span class="text">Menu</span></a></div>
					<h1 id="site-title"><a href="#"><?php echo $site_name; ?></a></h1>
				</div>
			</div> <!-- close .grid -->
		</header> <!-- close header#site-header -->

		<div id="content-wrapper">
			<div id="content-body">
				<div class="grid">

					<div class="g12 listing">
						<article class="post single">
							
							<h1>Article Title</h1>

							<div class="content">
								<p>Intro <?php echo $filler->getContent(30, 'plain', false); ?></p>
							</div>

							<div id="photo-grid" class="row">

							<?php

							$tags = array(
								'people',
								'abstract',
								'fashion',
								'nature',
								'city',
								'animals',
								'people',
								'technics',
								'nature',
								'abstract',
								'fashion',
								'nature',
								// 'city',
								// 'animals',
								// 'people',
							);
							foreach ($tags as $tag) :
								$width = rand(400, 800);
								$height = rand(400, 800);
								$size = $width . "/" . $height;
								$image_path = 'http://lorempixel.com/' . $size . '/' . $tag;
								$image_tag = ucwords($tag);
								$sample_text = $filler->getContent(rand(5,15), 'html', false);
								// $post_title = ucfirst($filler->getContent(rand(2,8), 'plain', false));
								$post_title = ucfirst($image_tag);
							?>

								<div class="photo-item g3">
									<a href="post.php"><img src="<?php echo $image_path; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" /></a>
									<!-- <div class="overlay">
										<h2><a href="single.php"><?php echo $post_title; ?></a></h2>
										<?php echo $sample_text; ?>
									</div> -->
								</div>

							<?php endforeach; ?>
							</div>
						</article>
					</div>
				</div> <!-- close .grid.row -->
			</div> <!-- close #content-body -->

			<footer id="site-footer">
				<div class="grid">
					<div class="g4">
						<h2>About <?php echo $site_name; ?></h2>
						<?php echo $filler->getContent(20, 'html', false); ?>
						<p><a href="#" class="more-link">More...</a></p>
					</div>
					<div class="g4">
						<h2>Recent Photos</h2>
						<ul class="photo-block-list">
							<?php for($i=0; $i<8; $i++) : ?>
							<li><div class="image-placeholder"><i class="fa fa-image"></i></div></li>
							<?php endfor; ?>
						</ul>
						<p><a href="#" class="more-link">More...</a></p>
					</div>
					<div class="g4">
						<h2>Sharing</h2>
					</div>
				</div> <!-- close .grid -->
			</footer> <!-- close footer#site-footer -->

		</div> <!-- close #content-wrapper -->
	</body>
</html>
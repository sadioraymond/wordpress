<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
        <?php wp_head();?>
	</head>
	<!--body_class() nous donne le contexte cad la ou on se trouve dans le site-->
	<body <?php body_class(); ?>>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="#"><?php bloginfo('name'); ?></a></h1>
						<nav class="links">
							<ul>
								<?php if(has_nav_menu( 'site-nav') ):
						wp_nav_menu( array( 'theme-location' => 'site-nav' ) );
						 endif?>
							</ul>
						</nav>
						<nav class="search-form-container">
                                <?php get_search_form();?>

						</nav>
					</header>

				<!-- Menu -->
			

				<!-- Main -->
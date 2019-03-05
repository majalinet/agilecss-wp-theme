<?php if( is_archive() || is_tax() || is_category() || is_tag() ){
	$border_class="";
}elseif( is_front_page() || is_single() ){	
	$border_class="bordered-top";
}else{
	$border_class="bordered-bottom";
	
}?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Kim Majali">
    <meta name="copyright" content="MIT license, Europe IT Outsourcing, https://www.europeitoutsourcing.com/">
   
   <?php wp_head(); ?>
   
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="d-none" href="#content"><?php _e( 'Skip to content', 'agilecss' ); ?></a>
	<div class="main-nav <?php echo $border_class;?>">
		<div class="main-menu">
			<a href="<?php echo esc_url(bloginfo( 'url' ));?>" id="logo">                            
				<svg alt="Agile Logo" class="icon-color-1-fill  icon-ml" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 30.17 37.71"><defs><style>.cls-2{font-size:34px;fill:#fff;font-family:Montserrat-Thin, Montserrat;letter-spacing:0.01em;}</style></defs><title>Agile logo</title><g ><g ><rect class="cls-1" y="1.53" width="30.17" height="30.17" rx="1.12" ry="1.12"/><text class="cls-2" transform="translate(3.33 28.9)">A</text></g></g></svg>
			</a>
			
			<label for="toggle-1" class="toggle-menu">
				<svg xmlns="http://www.w3.org/2000/svg" class="icon-color-1-fill icon-s" viewbox="0 0 24 24">
					<path d="M0 0h24v24H0z" fill="none" />
					<path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
				</svg>
			</label>
			<input type="checkbox" id="toggle-1">

			<nav>
				<?php
					wp_nav_menu( [
						'theme_location' => 'main_menu'
					] );
				?>
			</nav>
		</div>

	</div>
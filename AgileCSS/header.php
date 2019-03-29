<?php 
$agile_options = get_option( 'agile_option_name' );
$border_class = "";
switch( $agile_options['header_border'] ){
	case 'top':
		$border_class = "bordered-top";
		break;
	case 'bottom':
		$border_class = "bordered-bottom";
		break;
	case 'both':
		$border_class = "bordered-top bordered-bottom";
		break;
	default:
		$border_class = "container";
		break;
}
switch( $agile_options['main_menu_border_style'] ){
	case 'rounded':
		$border_class .= " menu-borderd";
		$menu_items_class = "rounded";
		break;
	case 'menu-borderd':
		$border_class .= " menu-borderd";
		$menu_items_class = "";
		break;
	default:
		$border_class .= "";
		$menu_items_class = "";
		break;
}

$agile_header_options = get_option( 'agile_header_option_name' );
?>

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
<div id="page" class="site background_color">
	<a class="d-none" href="#content"><?php _e( 'Skip to content', 'agilecss' ); ?></a>
	<?php if( $agile_header_options['header_row_content'] ){?><div class="msg bg-info no-margin"><?php _e($agile_header_options['header_row_content']); ?></div><?php };?>
	<div class="main-nav <?php echo $border_class;?> <?php _e( $agile_options["main_menu_style"] );?> header_background_color">
		<div class="main-menu">
			<?php if($agile_options["logos"]){?>
				<a href="<?php echo esc_url(bloginfo( 'url' ));?>" id="logo"> 
					<?php if( $agile_options['logos']['header']['img_type'] == 'SVG' ){			
						echo $agile_options['logos']['header']['svg'];
					}elseif( $agile_options['logos']['header']['img_type'] == 'IMG' ){
						?><img src="<?php echo $agile_options['logos']['header']['img']; ?>" ><?php
					}?>
				</a>
			<?php }?>
			
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
						'theme_location' => 'main_menu',
						'container'       => '',
						'menu_items_class' => $menu_items_class
					] );
				?>
			</nav>
			<?php if( $agile_options['display_search'] == "Y" ){?>
			<label for="toggle-2" class="toggle-search"><svg xmlns="http://www.w3.org/2000/svg" class="icon-color-1-fill  icon-s" width="24" height="24" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M0 0h24v24H0z" fill="none"/></svg></label>
			<input type="checkbox" id="toggle-2">
			<nav class="search-form"><?php get_search_form(); ?></nav>
			<?php };?>
		</div>

	</div>
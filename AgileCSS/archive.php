<?php
get_header();
$agile_options = get_option( 'agile_option_name' );

switch($agile_options['layout_type']){
	case 'booked':
		$layout_class = 'container';
		break;
	default:
		$layout_class = 'container-fluid';
		break;
}
?>

	<section id="primary" class="<?php _e($layout_class); ?> content-area">
		<main id="main" class="site-main">
			<header class="promo-box-s bg-light-grey">
			  <div class="container">
				<h1 class=""><?php wp_title(''); ?></h1>

				<?php custom_breadcrumbs();?>
			  </div>
			</header>
			<div class="container row m-v-2">
				<?php
				if ( have_posts() ) {
					// Load posts loop.
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content-posts', get_post_format() );
					}

				} else {

					// If no content, include the "No posts found" template.
					get_template_part( 'template-parts/content/content', 'none' );

				}
				?>
				<?php if(function_exists('agile_navi')) {
					agile_navi();
				}?>
			</div>
			
		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
?>

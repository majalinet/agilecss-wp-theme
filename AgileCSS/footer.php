<?php
	$options = get_option( 'agile_footer_option_name' );
	$agile_options=get_option( 'agile_option_name' );
?>
	<footer class="<?php echo $options['footer_type']; ?> p2 line-height-17 footer_background_color">
		<div class="container-fluid row color-1">
			<?php
				for( $i=1; $i<=$options['footer_col_count']; $i++ ){
				?>
					<div class="col-md-6 col-lg-3">
						<?php
						switch($options['footer_col_'.$i.'_type']){
							case 'text':
								?>
								<?php if($agile_options["logos"] && $i == 1 ){?>
									<a href="<?php echo esc_url(bloginfo( 'url' ));?>" id="logo"> 
										<?php if( $agile_options['logos']['footer']['img_type'] == 'SVG' ){			
											echo $agile_options['logos']['footer']['svg'];
										}elseif( $agile_options['logos']['footer']['img_type'] == 'IMG' ){
											?><img src="<?php echo $agile_options['logos']['footer']['img']; ?>" ><?php
										}?>
									</a>
								<?php }?>
								<p class="footer-about">
									<?php echo $options['footer_col_'.$i.'_text'];?>
								</p>
								<?
								break;
							case 'menu':?>
								<p class="h4"><?php echo $options['footer_col_'.$i.'_title']; ?></p>
								<hr>
								<?php wp_nav_menu( [
									'theme_location' => 'footer_col_'.$i.'_menu_name',
									'container'       => '',
									'menu_class' => 'color-1',
									'items_wrap' => '<ul id="%1$s" style="list-style-type:none" class="%2$s">%3$s</ul>',
								] );
								break;
							case 'map':?>
								<p class="h4"><?php echo $options['footer_col_'.$i.'_title']; ?></p>
								<?php echo $options['footer_col_'.$i.'_map_script'];?>
								<?php 
								break;
							case 'contacts':?>
								<p class="h4"><?php echo $options['footer_col_'.$i.'_title']; ?></p>
								<hr>
								<?php
									foreach( $options['footer_col_'.$i.'_contacts'] as $k => $field ){
										switch($field["type"]){
											case 'text':
												?><p>
													<?php echo $field['value']; ?>
												</p><?php
												break;
											case 'label_text':
												?><p class="footer-label-text">
														<?php echo $field['label']; ?>: <?php echo $field['value']; ?>
												</p><?php
												break;
											case 'social_bar':
												$social = get_option( 'agile_social_option_name' );
												foreach( $social as $array){
													foreach($array as $n => $service){
														?><a href="<?php echo $service['link']; ?>" title="<?php echo $service['name']; ?>" alt="<?php echo $service['name']; ?>" target="_blank"> 
															<i class="icon-box  hover-shadow">
																<?php 
																if ( $service['img_type'] == "IMG" ){
																	?><img src="<?php echo $service['img']; ?>" title="<?php echo $service['name']; ?>" alt="<?php echo $service['name']; ?>"><?php
																}else{
																	echo $service['svg'];
																}?>	 
															</i>
														</a>
														<?php
													}
												}
												break;
											case 'subscribe':
												
												break;
											default:
												break;
										}
									}
									
									?>
							<?php break;
							default:
								break;
						}
						?>
					</div>
				<?php
				}
			?>
		</div>

	</footer>
	<div class="center p2 <?php if($options['footer_type'] == 'bg-light-grey'){ echo 'bg-dark'; }?> copyrights_background_color">
		<p class="color-1"> © Copyright 2018. All Rights Reserved Europe IT Outsourcing Company.</p>
	</div>

</div><!-- #page -->

<?php wp_footer(); ?>
<?php if($agile_options['footer_scripts']){?>
	<script>
		<?php _e($agile_options['footer_scripts']); ?>
	</script>
<?php };?>
</body>
</html>
<?php 
if( !is_active_sidebar( 'index' )){
	return;
}
?>
<section class="h-100  center d-flex flex-column justify-content-center m-v-4 container">
	<div class="row justify-content-center">
<?php
	dynamic_sidebar( 'index' );
?>
	</div>
</section>

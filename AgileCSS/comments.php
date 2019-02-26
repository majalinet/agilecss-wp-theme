<?php
if ( post_password_required() ) {
	return;
}
$count = get_comments_number( get_the_ID() );

?>
<?php if( $count>0 ){?>
<p class="h4"><?php echo $count;?> Comments</p>
<?php if ( have_comments() ){
	wp_list_comments(
		array(
			'short_ping'  => true,
			'style'       => 'div',
		)
	);
	
}?>
<div class="outline-light-grey rounded p1 m-v-1">
		<p><img src="../img/vika/u1.jpg" class="circle icon-m"><span class="h5"> John Doe</span> wrote <span class="badge"> on
				5/2/2019</span>:
			</p><p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, dolorum, vero ipsum molestiae
					minima odio quo voluptate illum excepturi quam cum voluptates doloribus quae nisi tempore
					necessitatibus dolores ducimus enim libero eaque explicabo suscipit animi at quaerat aliquid.
				</p>
		<p></p>
</div>    
<div class="outline-light-grey rounded p1 m2">
		<p><img src="../img/vika/u3.jpg" class="circle icon-m"><span class="h5"> Kim Doe</span> relied <span class="badge"> on
				5/2/2019</span>:
			</p><p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, dolorum, vero ipsum molestiae
					minima odio quo voluptate.
				</p>
		<p></p>
</div>               
<?php };?>
<p class="h4">Leave a comment</p>

<form>
		<div class="form-row">
			<div class="form-group col-md-4 ">
				<input type="text" class="form-control" id="inputName" placeholder="Name">
			</div>
			<div class="form-group col-md-4">
					<input type="email" class="form-control" id="inputEmail4" placeholder="Email">
				</div>
			<div class="form-group col-md-4">
					<input type="text" class="form-control" id="inputWebsite" placeholder="Website">
				</div>                        
		</div>



		<div class="form-group">
			<textarea class="form-control" rows="5" id="comment" placeholder="Comments"></textarea>
		</div>

		<button type="submit" class="btn btn-primary">Leave a comment</button>
	</form>
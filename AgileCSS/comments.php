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
			'walker'      => new Agile_Walker_Comment(),
			'avatar_size' => 32,
			'short_ping'  => true,
			'style'       => 'div',
		)
	);
	
}?>              
<?php };?>
<?php 
if ( have_comments() ) :
	$comments_text = __( 'Comments', 'agilecss' );
	the_comments_navigation(
		array(
			'prev_text' => sprintf( '<span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>',  __( 'Previous', 'twentynineteen' ), __( 'Comments', 'twentynineteen' ) ),
			'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', __( 'Next', 'twentynineteen' ), __( 'Comments', 'twentynineteen' ) ),
		)
	);
endif;
?>
<p class="h4">Leave a comment</p>
<?php
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$comments_args = array(    
	'fields' => '',
	'format'       => 'html5',
	'show_fields_logged_in' => true,
	'logged_in_as' => null,
	'title_reply'  => null,
	'comment_field'=> '<div class="form-group">
                        <textarea class="form-control" rows="5" name="comment" id="comment" placeholder="Comments"></textarea>
                    </div>',
	'class_submit' =>'btn btn-primary',
	
);
comment_form($comments_args, get_the_ID());
?>


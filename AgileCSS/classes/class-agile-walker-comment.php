<?php

class Agile_Walker_Comment extends Walker_Comment {

	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<div  <?php comment_class( $comment->comment_parent==0 ? 'outline-light-grey rounded p1 m-v-1' : 'outline-light-grey rounded p1 m2', $comment ); ?> id="comment-<?php comment_ID(); ?>">
			<?php
				$comment_meta_author = get_comment_meta( get_comment_ID(), 'author', true );
				$comment_author_link = get_comment_author_link( $comment );
				$comment_author_url  = get_comment_author_url( $comment );
				$comment_author      = get_comment_author( $comment );
				$avatar              = get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'circle icon-s' ) );
			?>
			<p>
				<?php
				if ( 0 != $args['avatar_size'] ) {					
					echo $avatar;					
				}
				$comment_timestamp = sprintf( __( '%1$s at %2$s', 'agilecss' ), get_comment_date( 'd/m/Y', $comment ), get_comment_time() );
				?>
				<span class="h5"> <?php echo $comment_meta_author?$comment_meta_author:$comment_author?></span> wrote 
				<span class="badge"> on	<?php echo $comment_timestamp; ?></span>:
			</p>
			
			<?php comment_text(); ?>
			
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="comment-reply">',
						'after'     => '</div>',
					)
				)
			);
			?>
			<p></p> 		
		<?php
	}
}

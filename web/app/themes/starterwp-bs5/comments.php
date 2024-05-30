<?php
/**
 * The template for displaying comments.
 * This is the template that displays the area of the page that contains both the current comments and the comment form.
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

if ( post_password_required() ) {
	return;
}
?>

	<div id="comments" class="comments-area">
		<?php
		if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
					printf(
						esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'starterwp-textdomain' ) ),
						number_format_i18n( get_comments_number() ),
						'<span>' . get_the_title() . '</span>'
					);
				?>
			</h2>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'starterwp-textdomain' ); ?></h2>
					<div class="nav-links">
						<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'starterwp-textdomain' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'starterwp-textdomain' ) ); ?></div>
					</div>
				</nav>
			<?php endif; ?>
			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'      => 'ol',
						'short_ping' => true,
					) );
				?>
			</ol>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'starterwp-textdomain' ); ?></h2>
					<div class="nav-links">
						<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'starterwp-textdomain' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'starterwp-textdomain' ) ); ?></div>
					</div>
				</nav>
				<?php
			endif;
		endif;

		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'starterwp-textdomain' ); ?></p>
			<?php
		endif;

		$req           = get_option( 'require_name_email' );
		$aria_req      = ( $req ? " aria-required='true'" : '' );
		$comments_args = array(
			'label_submit'        => 'Submit',
			'title_reply'         => 'Leave a Comment',
			'comment_notes_after' => '',
			'class_submit'        => 'btn btn-secondary',
			'comment_field'       => ' <div class="form-group"><label for="comment">' . _x( 'Comment', 'starterwp-textdomain' ) . '</label><textarea class="form-control" rows="10" id="comment" name="comment" aria-required="true"></textarea></div>',

			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' =>
					'<div class="form-group">' .
					'<label for="author">' . __( 'Name', 'starterwp-textdomain' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' /></div>',
				'email' =>
					'<div class="form-group"><label for="email">' . __( 'Email', 'starterwp-textdomain' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"' . $aria_req . ' /></div>',
				'url' =>
					'<div class="form-group"><label for="url">' .
					__( 'Website', 'starterwp-textdomain' ) . '</label>' .
					'<input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" /></div>'
				)
			),
		);
		comment_form($comments_args);
		?>
	</div>

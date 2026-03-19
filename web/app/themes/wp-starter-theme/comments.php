<?php
/**
 * The template for displaying comments.
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area" aria-labelledby="comments-title">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title" id="comments-title">
			<?php
				$comments_number = get_comments_number();

				printf(
					wp_kses(
						_nx(
							'%1$s kommentar på &ldquo;%2$s&rdquo;',
							'%1$s kommentarer på &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'wp-starter-theme'
						),
						array( 'span' => array() )
					),
					esc_html( number_format_i18n( $comments_number ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" aria-label="<?php echo esc_attr__( 'Navigering för kommentarer ovanför', 'wp-starter-theme' ); ?>">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Navigering för kommentarer', 'wp-starter-theme' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Äldre kommentarer', 'wp-starter-theme' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Nyare kommentarer', 'wp-starter-theme' ) ); ?></div>
				</div>
			</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'short_ping' => true,
						'avatar_size' => 48,
					)
				);
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" aria-label="<?php echo esc_attr__( 'Navigering för kommentarer nedanför', 'wp-starter-theme' ); ?>">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Navigering för kommentarer', 'wp-starter-theme' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Äldre kommentarer', 'wp-starter-theme' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Nyare kommentarer', 'wp-starter-theme' ) ); ?></div>
				</div>
			</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Kommentarer är stängda.', 'wp-starter-theme' ); ?></p>
	<?php endif; ?>

	<?php
	$req       = (bool) get_option( 'require_name_email' );
	$commenter = wp_get_current_commenter();

	$required_hint_id = 'comment-required-hint';

	$comments_args = array(
		'label_submit'         => esc_html__( 'Skicka kommentar', 'wp-starter-theme' ),
		'title_reply'          => esc_html__( 'Lämna en kommentar', 'wp-starter-theme' ),
		'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h2>',
		'comment_notes_before' => '<p id="' . esc_attr( $required_hint_id ) . '" class="comment-notes screen-reader-text">' . esc_html__( 'Fält markerade med * är obligatoriska.', 'wp-starter-theme' ) . '</p>',
		'comment_notes_after'  => '',
		'class_submit'         => 'btn btn-secondary',

		'comment_field'        => '<div class="form-group">
			<label for="comment">' . esc_html__( 'Kommentar', 'wp-starter-theme' ) . '</label>
			<textarea class="form-control" id="comment" name="comment" rows="10" required aria-describedby="' . esc_attr( $required_hint_id ) . '"></textarea>
		</div>',

		'fields'               => apply_filters(
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			'comment_form_default_fields',
			array(
				'author' =>
					'<div class="form-group">
						<label for="author">' . esc_html__( 'Namn', 'wp-starter-theme' ) . ' ' . ( $req ? '<span class="required" aria-hidden="true">*</span>' : '' ) . '</label>
						<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . ( $req ? 'required aria-describedby="' . esc_attr( $required_hint_id ) . '"' : '' ) . ' />
					</div>',

				'email'  =>
					'<div class="form-group">
						<label for="email">' . esc_html__( 'E-post', 'wp-starter-theme' ) . ' ' . ( $req ? '<span class="required" aria-hidden="true">*</span>' : '' ) . '</label>
						<input class="form-control" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . ( $req ? 'required aria-describedby="' . esc_attr( $required_hint_id ) . '"' : '' ) . ' />
					</div>',

				'url'    =>
					'<div class="form-group">
						<label for="url">' . esc_html__( 'Webbplats', 'wp-starter-theme' ) . '</label>
						<input class="form-control" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
					</div>',
			)
		),
	);

	comment_form( $comments_args );
	?>

</section>

<?php
if (comments_open()) {
    $fields = [];
    if (! is_user_logged_in()) {
        $fields = [
            'author' => '<p><input type="text" id="author" name="author" class="form-control" placeholder="Your Name" required></p>',
            'email'  => '<p><input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required></p>',
            'url'    => '<p><input type="url" id="url" name="url" class="form-control" placeholder="Your Website"></p>',
        ];
    }

    $custom_fields = implode('', $fields) . '<p><textarea id="comment" name="comment" class="form-control" placeholder="Leave a message here ..." rows="4" required></textarea></p>';

    $comment_form_args = [
        'title_reply'     => 'Leave a Comment',
        'label_submit'    => 'Submit Comment',
        'class_submit'    => 'btn btn-primary',
        'fields'          => [],
        'comment_field'   => $custom_fields,
        'comment_notes_before'  => '',
        'comment_notes_after'   => '',
        'logged_in_as'          => '',
        'submit_button'   => '<button type="submit" class="btn btn-primary">%s</button>',
    ];
}

wp_list_comments([
    'style' => 'ul',
    'short_ping' => true,
    'reply_text' => 'Reply',
    'max_depth' => 4,
    'callback' => 'my_custom_comments',
]);



function my_custom_comments($comment, $args, $depth) {
    $container = ($args['style'] === 'div') ? 'div' : 'li';
    $comment_id = get_comment_ID();

    ob_start();
    comment_class('p-0 customize-comments');
    $comment_class = ob_get_clean();
?>

    <ul class="list-unstyled m-0">
        <?php echo '<' . esc_attr($container) . ' id="comment-' . esc_attr($comment_id) . '" class="' . esc_attr($comment_class) . '">'; ?>

        <div class="comment-author d-flex mb-3">
            <?php echo get_avatar($comment, 48); ?>
            <div class="ml-3">
                <span class="author-name"><?php comment_author_link(); ?></span>
                <div class="text-xs comment-meta">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                        <?php printf('%1$s at %2$s', get_comment_date(), get_comment_time()); ?>
                    </a>
                    <?php edit_comment_link('(Edit)', '  ', ''); ?>
                </div>
            </div>
        </div>

        <?php if ($comment->comment_approved == '0') : ?>
            <em><?php _e('Your comment is awaiting for approval.'); ?></em><br />
        <?php endif; ?>

        <div class="comment-content"><?php comment_text(); ?></div>

        <div class="reply">
            <?php
            $reply_text = sprintf(__('Reply to %s'), get_comment_author($comment));
            comment_reply_link(array_merge($args, [
                'depth' => $depth,
                'max_depth' => $args['max_depth'],
                'reply_text' => $reply_text,
            ]));
            ?>
        </div>

        <?php echo '</' . esc_attr($container) . '>' ?>
    </ul>

    <hr>
<?php } ?>

<?php comment_form($comment_form_args); ?>
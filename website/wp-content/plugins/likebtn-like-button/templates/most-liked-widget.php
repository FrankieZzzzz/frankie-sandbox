<?php
/**
 * Most Liked Content tempplate
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');
?>

<?php if (!empty($before_widget)): ?>
    <?php echo wp_kses($before_widget, 'post'); ?>
<?php endif ?>

<?php if (!empty($title)): ?>
    <?php if (!empty($before_title)): ?>
        <?php echo wp_kses($before_title, 'post'); ?>
    <?php endif ?>
	<?php echo wp_kses($title, 'post'); ?>
    <?php if (!empty($after_title)): ?>
        <?php echo wp_kses($after_title, 'post'); ?>
    <?php endif ?>
<?php endif ?>

<?php if (count($post_loop) > 0): ?>
	<ul class="likebtn-mlw">
	<?php foreach ($post_loop as $post): ?>
		<li id="post-<?php echo esc_attr($post['id']) ?>" class="likebtn-mlw-item" >
            <a href="<?php echo esc_attr($post['link']) ?>" title="<?php echo esc_attr($post['title']) ?>">
                <?php if ($show_thumbnail): ?>
                    <?php if ('image/' == substr( $post['post_mime_type'], 0, 6 ) ): ?>
                        <?php echo wp_get_attachment_image( $post['id'], $thumbnail_size, array('class' => 'likebtn-item-thumbnail') ); ?>
                    <?php else: ?>
                        <?php echo get_the_post_thumbnail($post['id'], $thumbnail_size, array('class' => 'likebtn-item-thumbnail')); ?>
                    <?php endif ?>
                <?php endif ?>
                <div class="likebtn-mlw-title">
                    <?php echo esc_html($post['title']) ?><?php if ($show_likes || $show_dislikes): ?>&nbsp;<span class="likebtn-item-likes"><nobr>(
                    <?php endif ?>
                    <?php echo ($show_likes ? (int)$post['likes'] : ''); ?>
                    <?php if ($show_likes && $show_dislikes): ?>
                        /
                    <?php endif ?>
                    <?php echo ($show_dislikes ? (int)$post['dislikes'] : ''); ?>
                    <?php if ($show_likes || $show_dislikes): ?>
                        )</nobr></span>
                    <?php endif ?>
                </div>
            </a>
            <?php if ($show_date && $post['date']): ?>
                <small class="likebtn-mlw-date"><i><?php echo date_i18n(get_option('date_format'), $post['date']) ?></i></small>
            <?php endif ?>
            <?php if ($show_author && $post['author_name']): ?>
                <?php if ($show_date && $post['date']): ?>
                    <small>/</small> 
                <?php endif ?>
                <small class="likebtn-mlw-author"><i><?php echo esc_html($post['author_name']) ?></i></small>
            <?php endif ?>
            <?php if ($show_excerpt): ?>
                <div class="likebtn-mlw-excerpt"><?php echo esc_html($post['excerpt']) ?></div>
            <?php endif ?>
            <?php if ($post['button_html']): ?>
                <div class="likebtn-mlw-button"><?php echo wp_kses($post['button_html'], 'post'); ?></div>
            <?php endif ?>
            <?php if ($show_thumbnail || $show_excerpt): ?>
                <br/>
            <?php endif ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php else: // No items ?>
	<div class="likebtn-mlw-no-items">
		<p>
            <?php if ($empty_text): ?>
                <?php echo esc_html($empty_text); ?>
            <?php else: ?>
                <?php _e('No items liked yet.', 'likebtn-like-button'); ?>
            <?php endif ?>
        </p>
	</div>
<?php
endif;
?>

<?php if (!empty($after_widget)): ?>
    <?php echo wp_kses($after_widget, 'post'); ?>
<?php endif ?>
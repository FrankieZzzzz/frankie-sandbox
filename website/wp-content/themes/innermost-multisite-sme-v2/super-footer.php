<?php 
    global $site_super_footer_columns,
    $site_social_media_option,
    $site_super_footer_bottom,
    $site_super_footer_top;
    $columnclass = 'super-footer__menu__nav col';
    // Set superfooter menu
    function set_superfooter_menu($menuname) {
        if(has_nav_menu($menuname)){
            wp_nav_menu(array('theme_location' => $menuname)); 
        }
    }
?>

<div class="super-footer d-none d-sm-none d-md-block">
    <div class="container-lg">
        <?php if (isset($site_super_footer_top) && $site_super_footer_top) : ?>
            <div class="row super-footer__callout-top">
                <div class="col">
                    <?php 
                        while( have_rows('footer_settings', 'option') ) : the_row(); 
                            the_sub_field('super_footer_top', 'option');
                        endwhile;
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row super-footer__middle">
            <?php 
            if ($site_super_footer_columns['columns']) : 
                while( have_rows('footer_settings', 'option') ) : the_row(); 
                    while( have_rows('super_footer_columns', 'option') ) : the_row();
                        if ($site_super_footer_columns['columns'] > '0'): ?>
                            <div class="super-footer__1 <?php echo $columnclass; ?>">
                                <?php if ($site_super_footer_columns['column_1']['options'] == 'menu') {
                                    set_superfooter_menu($site_super_footer_columns['column_1']['menu']);
                                } elseif ($site_super_footer_columns['column_1']['options'] == 'content') {
                                    while( have_rows('column_1', 'option') ) : the_row();
                                        the_sub_field('content', 'option');
                                    endwhile;
                                } ?>
                            </div>
                        <?php endif;
                        if ($site_super_footer_columns['columns'] > '1'): ?>
                            <div class="super-footer__2 <?php echo $columnclass; ?>">
                                <?php if ($site_super_footer_columns['column_2']['options'] == 'menu') {
                                    set_superfooter_menu($site_super_footer_columns['column_2']['menu']);
                                } elseif ($site_super_footer_columns['column_2']['options'] == 'content') {
                                    while( have_rows('column_2', 'option') ) : the_row();
                                        the_sub_field('content', 'option');
                                    endwhile;
                                } ?>
                            </div>
                        <?php endif;
                        if($site_super_footer_columns['columns'] > '2'): ?>
                            <div class="super-footer__3 <?php echo $columnclass; ?>">
                                <?php if ($site_super_footer_columns['column_3']['options'] == 'menu') {
                                    set_superfooter_menu($site_super_footer_columns['column_3']['menu']);
                                } elseif ($site_super_footer_columns['column_3']['options'] == 'content') {
                                    while( have_rows('column_3', 'option') ) : the_row();
                                        the_sub_field('content', 'option');
                                    endwhile;
                                } ?>
                            </div>
                        <?php endif;
                        if ($site_super_footer_columns['columns'] > '3'): ?>
                            <div class="super-footer__4 <?php echo $columnclass; ?>">
                                <?php if ($site_super_footer_columns['column_4']['options'] == 'menu') {
                                    set_superfooter_menu($site_super_footer_columns['column_4']['menu']);
                                } elseif ($site_super_footer_columns['column_4']['options'] == 'content') {
                                    while( have_rows('column_4', 'option') ) : the_row();
                                        the_sub_field('content', 'option');
                                    endwhile;
                                } ?>
                            </div>
                        <?php endif;
                        if ($site_super_footer_columns['columns'] > '4'): ?>
                            <div class="super-footer__5 <?php echo $columnclass; ?>">
                                <?php if ($site_super_footer_columns['column_5']['options'] == 'menu') {
                                    set_superfooter_menu($site_super_footer_columns['column_5']['menu']);
                                } elseif ($site_super_footer_columns['column_5']['options'] == 'content') {
                                    while( have_rows('column_5', 'option') ) : the_row();
                                        the_sub_field('content', 'option');
                                    endwhile;
                                } ?>
                            </div>
                        <?php endif;
                        if ($site_super_footer_columns['columns'] > '5'): ?>
                            <div class="super-footer__6 <?php echo $columnclass; ?>">
                                <?php if ($site_super_footer_columns['column_6']['options'] == 'menu') {
                                    set_superfooter_menu($site_super_footer_columns['column_6']['menu']);
                                } elseif ($site_super_footer_columns['column_6']['options'] == 'content') {
                                    while( have_rows('column_6', 'option') ) : the_row();
                                        the_sub_field('content', 'option');
                                    endwhile;
                                } ?>
                            </div>
                        <?php 
                        endif;
                    endwhile;
                endwhile;
            endif;
            ?>
        </div>
        <?php if (isset($site_super_footer_bottom) && $site_super_footer_bottom) : ?>
            <div class="super-footer__callout-bottom row">
                <div class="col">
                    <?php 
                        while( have_rows('footer_settings', 'option') ) : the_row(); 
                            the_sub_field('super_footer_bottom', 'option');
                        endwhile;
                    ?>
                </div>
            </div>
        <?php endif; 
        ?>
        <?php if (isset($site_social_media_option) && in_array('superfooter', $site_social_media_option)) { ?>
            <div class="super-footer__social row">
                <div class="col">
                    <?php  // see site_social_media.php
                        echo do_shortcode('[social_media_bar]');
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
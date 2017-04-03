<?php
/**
 *
 * Description:文章列表页的sidebar
 * Author: falcon
 * Date: 15/11/22
 * Time: 上午1:30
 *
 */
?>
<?php if ( is_active_sidebar( 'fp-sidebar-2' ))  : ?>
    <div id="widget-area" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'fp-sidebar-2' ); ?>
    </div><!-- .widget-area -->
<?php endif; ?>

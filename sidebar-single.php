<?php
/**
 *
 * Description:侧栏widget
 * Author: falcon
 * Date: 15/11/21
 * Time: 下午4:39
 *
 */
?>
<?php if ( is_active_sidebar( 'fp-sidebar-1' )) : ?>
    <div id="widget-area" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'fp-sidebar-1' ); ?>
    </div><!-- .widget-area -->
<?php endif; ?>


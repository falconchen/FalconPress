<?php
/**
 *
 * Description:配置相关
 * Author: falcon
 * Date: 15/11/23
 * Time: 下午3:41
 *
 */
//使WordPress支持post thumbnail
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
}
add_image_size('book-cover',255,340,false); // 书籍封面255*340

add_image_size('music-cover',120,120,true); // 音乐封面

add_image_size('music-cover2',240,120,true); // 音乐封面

add_theme_support( 'post-formats', array(
    'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
) );

// 重写规则


//禁用 WordPress 4.4+ 的响应式图片功能
//add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
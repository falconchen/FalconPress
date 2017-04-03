<?php
/**
 * Created by PhpStorm.
 * User: falcon
 * Date: 15/11/15
 * Time: 上午7:27
 * Project: cellmean.com
 *
 */
require_once __DIR__ . '/inc/config.php';// 配置相关,比如缩略图大小
require __DIR__ . '/inc/constants.php'; // 自定义的常量
require_once __DIR__ . '/inc/widgets.php'; // 挂件,必须用__DIR__,否则在widget管理页会出现找不到类的错误
require_once __DIR__ . '/inc/helpers.php'; // 可重用的函数


// 定义js变量供后续使用
add_action('wp_head','define_js_vars',8); //较高优先级，在js文件前加载
function define_js_vars() {
    echo '<script type="text/javascript">';
    echo 'var ajaxurl = "' . admin_url( 'admin-ajax.php', 'relative' ) . '";'; // ajaxurl
    echo 'var online_timestamp = '.FP_ONLINE_TIMESTAMP .';'; //上线时间
    echo '</script>';
    echo "\n";
}

// front page 加载更多文章
add_action('wp_ajax_load_front_articles', 'load_front_articles');
add_action('wp_ajax_nopriv_load_front_articles', 'load_front_articles');
function load_front_articles() {
    $paged = isset($_REQUEST['paged']) ? intval($_REQUEST['paged']) : 1;
    $output = get_front_articles($paged,1,1);
    wp_die();
    //wp_die(json_encode(array('code'=>0,'data'=>$output), JSON_UNESCAPED_UNICODE));
}


// 加载js和样式表
add_action( 'wp_enqueue_scripts', 'fp_theme_scripts_styles' );
function fp_theme_scripts_styles() {
    wp_enqueue_style( 'main', FP_TEMPLATE_DIR_URI . '/css/main.css',array(),'falconpress2.0'); // 主样式
    wp_enqueue_style( 'mScrollbar', FP_TEMPLATE_DIR_URI . '/css/jquery.mCustomScrollbar.css'); // 主样式
    wp_enqueue_script( 'mousewheel', FP_TEMPLATE_DIR_URI . '/js/vendor/jquery.mousewheel.min.js', array( 'jquery' ),false,true);
    wp_enqueue_script( 'plugins', FP_TEMPLATE_DIR_URI . '/js/plugins.js', array( 'jquery' ),false,true);
    wp_enqueue_script( 'main', FP_TEMPLATE_DIR_URI . '/js/main.js', array( 'jquery' ),false,true);
    //wp_enqueue_script( 'mScrollbar', FP_TEMPLATE_DIR_URI . '/js/vendor/jquery.mCustomScrollbar.min.js', array( 'jquery' ),false,true);

    if(is_archive() && get_post_type()=='music') {
        wp_enqueue_style( 'smusic' );
        wp_enqueue_script( 'smusic' );
    }
}

add_editor_style( 'css/editor-style.css' );


// 注册侧栏小工具
add_action( 'widgets_init', 'fp_widgets_init' );
function fp_widgets_init() {


    register_sidebar( array(
        'name'          => __( '文章页', 'FP' ),
        'id'            => 'fp-sidebar-1',
        'before_widget' => '<div class="list-group">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="list-group-item title">',
        'after_title'   => '</div>',
    ) );

    register_sidebar( array(
        'name'          => __( '文章分类页', 'FP' ),
        'id'            => 'fp-sidebar-2',
        'description'   => __( '文章分类页面的sidebar', 'fp' ),
        'before_widget' => '<div class="list-group">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="list-group-item title">',
        'after_title'   => '</div>',
    ) );

    register_sidebar( array(
        'name'          => __( '音乐分类页', 'FP' ),
        'id'            => 'fp-sidebar-3',
        'description'   => __( '音乐分类页面的sidebar', 'fp' ),
        'before_widget' => '<div class="list-group">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="list-group-item title">',
        'after_title'   => '</div>',
    ) );




    register_widget('FP_Widget_Search'); // 注册一个widget
    register_widget('FP_Widget_Related_Entries'); // 注册一个widget
    register_widget('FP_Widge_Archives'); // 注册一个widget
    register_widget('FP_Widget_Tag_Cloud'); // 注册一个widget
}

// bootstrap风格的归档
add_filter('get_archives_link',function($link_html){
    return str_replace(array('<a','</a>'),array('<a class="list-group-item"',''),$link_html).'</a>';
});


add_filter('query_vars', 'fp_insert_query_vars');//修改query_vars钩子,增加一个公共变量.
function fp_insert_query_vars($vars) {
    array_push($vars, 'cid');// 章节id
    return $vars;
}

add_filter('wp_get_attachment_image_src','fp_fix_https_image_src',10,4);
function fp_fix_https_image_src($image, $attachment_id, $size, $icon ) {
    if(is_array($image) && is_ssl() && substr($image[0],0,5)!=='https') {
        $image[0] = str_replace('http://','https://',$image[0]);
    }
    return $image;
}

// 移除后台左上方的wordpress logo
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);
function annointed_admin_bar_remove() {
    global $wp_admin_bar;
    /* Remove their stuff */
    $wp_admin_bar->remove_menu('wp-logo');
}

// 后台编辑器增加分页符
// TinyMCE: First line toolbar customizations
if( !function_exists('base_extended_editor_mce_buttons') ){
    function base_extended_editor_mce_buttons($buttons) {
        // The settings are returned in this array. Customize to suite your needs.
        /*
        return array(
            'pre','formatselect', 'bold', 'italic', 'sub', 'sup', 'bullist', 'numlist', 'link', 'unlink', 'blockquote', 'outdent', 'indent', 'charmap', 'removeformat', 'spellchecker', 'fullscreen', 'wp_more', 'wp_help'
        );
        */
        $buttons[] = "wp_page";
        return $buttons;
        /* WordPress Default
        return array(
            'bold', 'italic', 'strikethrough', 'separator',
            'bullist', 'numlist', 'blockquote', 'separator',
            'justifyleft', 'justifycenter', 'justifyright', 'separator',
            'link', 'unlink', 'wp_more', 'separator',
            'spellchecker', 'fullscreen', 'wp_adv'
        ); */
    }
    add_filter("mce_buttons", "base_extended_editor_mce_buttons", 0);
}


//add_filter( 'wp_insert_post_data', 'filter_handler', '99', 2 );
//function filter_handler( $data , $postarr ) {
//    // do something with the post data
//  return $data;
//}


function clean_blockquote($content) {
    return str_replace(array("<blockquote>\n<pre>","</blockquote>\n</pre>"),array("<pre>","</pre>"),$content);
}
add_filter('the_content', 'clean_blockquote',999);

function appthemes_add_quicktags() {
    if (wp_script_is('quicktags')){
        ?>
        <script type="text/javascript">
            QTags.addButton( 'h2_tag', 'h2', '<h2>', '</h2>', 'h', 'h2标签', 2 );
        </script>
        <?php
    }
}
add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );


function custom_posts_per_page($query){
    /*
    if(is_home()){
        $query->set('posts_per_page',8);//首页每页显示8篇文章
    }
    if(is_search()){
        $query->set('posts_per_page',-1);//搜索页显示所有匹配的文章，不分页
    }
    */
    if(is_archive() ){
        if(get_query_var('post_type') == 'music'){
            $query->set('posts_per_page',10); //音乐每页显示10篇
        }elseif(get_query_var('post_type') == 'book') {
            $query->set('posts_per_page',9); //读书每页显示9篇
        }

    }//endif
}//function

//this adds the function above to the 'pre_get_posts' action
add_action('pre_get_posts','custom_posts_per_page');


function get_post_thumbnail_url($post_id=null,$size='thumbnail'){
    $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
    $thumbnail_id = get_post_thumbnail_id($post_id);
    if($thumbnail_id ){
        $thumb = wp_get_attachment_image_src($thumbnail_id, $size);
        return $thumb[0];
    }else{
        return false;
    }
}

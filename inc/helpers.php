<?php
/**
 *
 * Description: 一些可复用的函数
 * Author: falcon
 * Date: 15/11/21
 * Time: 下午11:41
 *
 */


// front页的文章列表
function get_front_articles($paged=1,$echo=true,$debug=false) {


    if(!$debug && $cache = wp_cache_get($paged,'front_articles')){
       $output = $cache;
    }else{
        $front_query = new WP_Query('posts_per_page='.FP_FRONT_POST_PER_PAGE.'&paged='.intval($paged));
        $i = 0;

        ob_start();


        while($front_query->have_posts()) : $front_query->the_post();
            $i++;
            if ( $i % 3 == 1 ):
                echo '<div class="row post-row ">';
            endif;

            echo get_template_part('content','front');

            if ( $i % 3 == 0 || $i == $front_query->post_count):
                echo '</div><!-- /.row -->';
            endif;


        endwhile;

        wp_reset_postdata();

        $output = ob_get_contents();
        ob_clean();

        if( $paged <= FRONT_POST_CACHE_NUM ) { // 缓存
            wp_cache_add($paged,$output,'front_articles');
        }
    }
    if($echo) {
        echo $output;
    }else{
        return $output;
    }


}

// bootstrap风格的搜索栏
function fp_get_search_form($echo=true) {
    //$submit_btn_name = current_user_can('publish_posts') ? 'admin-search-submit' : 'search-submit';
    $submit_btn_name = 'search-submit';
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
                <div class="input-group input-group-xs">
					<input type="search" class="form-control search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label' ) . '" />
					<span class="input-group-btn">
					<button type="submit" class="btn btn-default '.$submit_btn_name .' ">
					<span class="icon fa fa-search"></span>
					</button>
					</span>
				</div>
			</form>';
    if($echo) :echo $form;
    else: return form;
    endif;
}

// 作家html,带链接
function get_book_term_link($term, $book_id=null, $split=', ',$with_link=true,$echo=true) {
    if(null==$book_id) {
        $book = get_post();
        $book_id = $book->ID;
    }
    $writer_obj_arr = get_the_terms($book_id,$term); // 获取作家
    $html ="";
    if(!empty($writer_obj_arr)){
        foreach($writer_obj_arr as $k=>$writer_obj){

            $link = get_term_link($writer_obj->term_id,$term);

            if($with_link){
                $html .= sprintf('<a href="%s" title="%s">%s</a>',$link,\
                     esc_attr($writer_obj->name),\
                    esc_html($writer_obj->name));
            }else{
                $html .= esc_html($writer_obj->name);
            }

            if($k+1!==count($writer_obj_arr)) {
                $html .= $split;
            }

        }
    }

    if($echo) {
        echo $html;
    }
    else {
        return $html;
    }
}

// 输出作家链接的html
function writers_html() {
    return get_book_term_link('book_writer');
}





// 输出缩略图,不存在时使用默认封面
function fp_the_post_thumbnail(){
    if (has_post_thumbnail()){
        the_post_thumbnail();
    }else{
        echo '<img src="'. FP_DEFAULT_BOOK_COVER .'"/>';
    }
}



/**
 * 从缓存中取得首页公告
 * 站点公告从站点公告分类最新一篇文章取得
 * 新书发布取最新发布的三本书
 * 视频发布取最新的三部视频
 */
function get_headlines_announcements($force_from_db=false) {

    $headlines = wp_cache_get('headlines','announcement');
    if($force_from_db OR $headlines === false) {
        $headlines = array();
        $site_announcement = get_last_announcement(SITE_ANNOUNCEMENT);

        $headlines[SITE_ANNOUNCEMENT] = $site_announcement->post_excerpt . sprintf(' <a href="%s" title="%s">%s</a>',get_permalink($site_announcement->ID),esc_attr($site_announcement->post_title),$site_announcement->post_title) ;


        $book_updated = get_last_books(3);
        $headlines[BOOK_ANNOUNCEMENT] = "";

        if(!empty($book_updated)) {
            foreach($book_updated as $book) {
                $headlines[BOOK_ANNOUNCEMENT].= "<li>". sprintf('<a href="%s" title="%s">%s</a>',get_permalink($book->ID),esc_attr($book->post_title),$book->post_title) ."</li>";
            }
        }else{
            $headlines[BOOK_ANNOUNCEMENT] = "<li>".暂无更新 . "</li>";
        }


        $video_updated = get_last_videos(3);
        $headlines[VIDEO_ANNOUNCEMENT] = "";

        if(!empty($video_updated)) {
            foreach($video_updated as $video) {
                $headlines[VIDEO_ANNOUNCEMENT].= "<li>". sprintf('<a href="%s" title="%s">%s</a>',get_permalink($video->ID),esc_attr($video->post_title),$video->post_title) ."</li>";
            }
        }else{
            $headlines[VIDEO_ANNOUNCEMENT] = "<li>".暂无更新 . "</li>";
        }
        wp_cache_set('headlines',$headlines,'announcement');
        return $headlines;
    }else{
        return $headlines;
    }

}
// 缓存控制
add_action('save_post','fp_save_post_delete_cache');
add_action('delete_post','fp_save_post_delete_cache');
function fp_save_post_delete_cache($post_id=null) {
    $post = get_post($post_id);
    wp_cache_delete('headlines','announcement'); // 清理headlines的缓存
    if($post->post_type == 'post') { // 清理首页文章项目缓存
        for($i=1;$i<=FRONT_POST_CACHE_NUM;$i++){
            wp_cache_delete($i,'front_articles');
        }
    }

}

//显示redis缓存状态
//add_action('wp_footer','display_cache_status');
function display_cache_status() {
    global $wp_object_cache;
    echo $wp_object_cache->stats();
}

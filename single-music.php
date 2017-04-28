<?php
/**
 * 博客文章
 * url: http://dev.cellmean.com/%E8%BD%AC-centos-%E4%B8%8B%E5%AE%89%E8%A3%85-zeromq-%E5%8F%8A%E5%85%B6php%E6%89%A9%E5%B1%95%E5%AE%89%E8%A3%85/
 * User: falcon
 * Date: 15/11/15
 * Time: 下午1:37
 * Project: cellmean.com
 */

wp_enqueue_style('aplayer');
wp_enqueue_script('aplayer');
get_header('');
?>
<main role="main">
    <div class="page-contents container">


        <div class="row">
            <div class="col-sm-8 music-list col-sm-offset-2">




                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo home_url();?>">首页</a></li>
                        <li><a href="<?php echo home_url('?post_type=music');?>">音乐</a></li>
                        <li class="active"><?php the_title()?></li>
                    </ol>

                    <article class="music-inisde">
                    <h4><?php the_title()?></h4>
                    <div class="aplayer" id="player1"></div>
                    <div class="lyric" style="padding: 10px 5px;">
                    <?php the_content();?>
                    </div>
                    </article>
                <?php endwhile; endif;?>
                <!-- UY BEGIN -->
                <div id="uyan_frame"><div class="loading-comment">加载中<div class=" fa fa-spinner fa-spin animated"></div></div></div>
                <script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=1617851"></script>
                <!-- UY END -->
            </div>

        </div>

    </div>
</main>

<?php
    $meta_arr = get_music_meta(get_the_ID());
    $img_arr = wp_get_attachment_image_src($meta_arr['cover'],'music-cover');
    $img_src = $img_arr[0];
    $audio_info = wp_get_attachment_metadata($meta_arr['file']);
    $audio_url = ($meta_arr['type'] == 'upload') ? wp_get_attachment_url($meta_arr['file']) : $meta_arr['url'];

?>

<script>
    var ap1 = new APlayer({
        element: document.getElementById('player1'),
        narrow: false,
        autoplay: true,
        music: {
            title: '<?php echo esc_attr(get_the_title())?>',
            author: '<?php echo esc_attr($meta_arr['artist'])?>',
            url: '<?php echo esc_attr($audio_url);?>',
            pic: '<?php echo esc_attr($img_src);?>'
        }
    });
    ap1.init();

    document. getElementsByTagName('main')[0].style.minHeight=document.documentElement.clientHeight-220 + "px";
</script>



<?php get_footer(''); ?>

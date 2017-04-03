<?php
/**
 * 音乐列表
 * url: http://dev.cellmean.com/?post_type=music
 * User: falcon
 * Date: 15/11/15
 * Time: 下午1:37
 * Project: cellmean.com
 */

get_header(); ?>
<main role="main">


    <div class="page-contents container">

        <ol class="breadcrumb">
            <li><a href="<?php echo home_url();?>">首页</a></li>
            <li class="active">音乐</li>
        </ol>

        <div class="col music-sidebar">
            <div style="position: relative;">


                <div class="grid-music-container f-usn">
                    <div class="m-music-play-wrap">
                        <div class="u-cover"></div>
                        <div class="m-now-info">
                            <h1 class="u-music-title"><strong>标题</strong><small>歌手</small></h1>
                            <div class="m-now-controls">
                                <div class="u-control u-process">
                                    <span class="buffer-process"></span>
                                    <span class="current-process"></span>
                                </div>
                                <div class="u-control u-time">00:00/00:00</div>
                                <div class="u-control u-volume">
                                    <div class="volume-process" data-volume="0.50">
                                        <span class="volume-current"></span>
                                        <span class="volume-bar"></span>
                                        <span class="volume-event"></span>
                                    </div>
                                    <a class="volume-control"></a>
                                </div>
                            </div>
                            <div class="m-play-controls">
                                <a class="u-play-btn prev" title="上一曲"></a>
                                <a class="u-play-btn ctrl-play play" title="暂停"></a>
                                <a class="u-play-btn next" title="下一曲"></a>
                                <a class="u-play-btn mode mode-list current" title="列表循环"></a>
                                <a class="u-play-btn mode mode-random" title="随机播放"></a>
                                <a class="u-play-btn mode mode-single" title="单曲循环"></a>
                            </div>
                        </div>
                    </div>
                    <div class="f-cb">&nbsp;</div>
                    <div class="m-music-list-wrap"></div>
                </div>


            </div>

        </div>


            <div class="">
                <div class="list-group post-list row">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <?php
                            $post_id = get_the_ID();
                            $meta_arr = get_music_meta($post_id);
                            $song_arr[] = array(
                                'title'=>empty($meta_arr['title'])? get_the_title():$meta_arr['title'],
                                'singer'=>$meta_arr['artist'],
                                'cover'=>get_music_cover_url(),
                                'src'=>$meta_arr['type'] == 'type' ?  wp_get_attachment_url($meta_arr['file']) : $meta_arr['url']
                            );
                        ?>
                        <div class="col-sm-6">
                            <a class="list-group-item post-item music-item" href="<?php the_permalink(); ?>">

                                            <div class="music-cover">
                                             <img style="height:120px;width:120px" src="<?php echo get_music_cover_url();?>">
                                            </div>

                                            <div class="music-detail">
                                                <h4 class="list-group-item-heading"><?php the_title(); ?> </h4>
                                                <?php the_excerpt(); ?>
                                            </div>

                                            <div class="clearfix"></div>
                            </a>

                            <div class="list-group-item well well-sm">
                                <?php the_tags(); ?>&nbsp;
                                <small class="label label-primary pull-right"><?php echo get_the_date(); ?></small>
                            </div>
                        </div>
                    <?php endwhile; endif;?>
                </div>

                <div class="row">
                    <div class="col-sm-12 pagination_wrap">
                        <?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
                    </div><!--/.pagination_wrap -->
                </div>
            </div>




    </div>
    <script>
        var musicList = <?php echo json_encode($song_arr,JSON_UNESCAPED_UNICODE);?>;
    </script>
    <script>
        new SMusic({
            musicList : musicList,
            autoPlay  : true,  //是否自动播放
            defaultMode : 1,   //默认播放模式，1顺序, 2随机
            callback   : function (obj) {  //返回当前播放歌曲信息
                // console.log(obj);
            }
        });
    </script>
</main>



<?php get_footer(); ?>

<?php
/**
 * Template Name: 自定义首页 front page
 *
 *
 * User: falcon
 * Date: 15/11/14
 * Time: 下午6:01
 * Project: cellmean.com
 */
$headlines = get_headlines_announcements();// 取得更新公告


get_header(); ?>
    <main role="main">
        <div class="page-contents container" id="floor1">
            <div class="row">
                <div class="col-sm-8 col-xm-12 fp-slider">
                    <?php if(function_exists('putRevSlider')) putRevSlider( "front" ) ?>
                    <!-- /#homepage-feature.carousel -->
                </div>
                <div class="col-sm-4 fp-board">
                    <div id="fp-board-details">
                        <h2>最近更新</h2>
                        <dl class="dl-horizontal">
                            <dt class="text-danger"><?php echo get_cat_name(SITE_ANNOUNCEMENT);?></dt>
                            <dd>
                                <p>
                                    <?php echo $headlines[SITE_ANNOUNCEMENT];?>
                                </p>
                            </dd>
                            <dt><?php echo get_cat_name(BOOK_ANNOUNCEMENT);?></dt>
                            <dd>
                                <ul class="list-inline">
                                    <?php echo $headlines[BOOK_ANNOUNCEMENT];?>
                                </ul>
                            </dd>
                            <dt><?php echo get_cat_name(VIDEO_ANNOUNCEMENT);?></dt>
                            <dd>
                                <ul class="list-inline">
                                    <?php echo $headlines[VIDEO_ANNOUNCEMENT];?>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <!-- /.fp-pub -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#floor1 -->

        <div class="page-contents container front-articles">

            <?php get_front_articles(1,true,true);?>



        </div>
        <div class="read-more read-more-frontpage" >
            <p>
                <a class="btn btn-lg btn-default ">
                    载入更多<i class="hidden loading fa fa-spinner fa-spin animated"></i>
                </a>
            </p>
        </div>


        <!-- /.container -->
    </main>

<?php get_footer(); ?>

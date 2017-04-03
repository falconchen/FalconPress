<?php
/**
 * 博客文章
 * url: http://dev.cellmean.com/%E8%BD%AC-centos-%E4%B8%8B%E5%AE%89%E8%A3%85-zeromq-%E5%8F%8A%E5%85%B6php%E6%89%A9%E5%B1%95%E5%AE%89%E8%A3%85/
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
            <li class="active">笔记</li>
        </ol>

        <div class="row">
            <div class="col-sm-8 post-list">
                <article class="list-group post-item">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="list-group-item ">
                        <a class="post-title" href="<?php the_permalink(); ?>">
                            <h4 class="list-group-item-heading "><?php the_title(); ?> </h4>
                        </a>
                        </div>
                        <div class="list-group-item post-meta">
                            <div class="row">
                            <div class="col-sm-4 meta-item">
                                <date><i class="icon fa fa-calendar"></i> <?php the_date('','发布于: ');?></date>
                            </div>
                            <div class="col-sm-8 meta-item">
                            <span class=""><i class="icon fa fa-tags"></i> <?php the_tags(); ?></span>
                            </div>
                            </div>
                        </div>
                        <div class="list-group-item well well-sm">
                            <div class="post-content">
                                <?php the_content() ?>
                            </div>

                            <small class="label label-primary pull-right">- EOF -</small>
                        </div>


                    <?php endwhile; endif;?>
                </article>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">评论</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12" >

                                <!-- UY BEGIN -->
                                <div id="uyan_frame">
                                    <div class="loading-comment">加载中<div class=" fa fa-spinner fa-spin animated"></div></div>
                                </div>
                                <script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=1617851"></script>
                                <!-- UY END -->
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <aside class="col-sm-4 sidebar">

                <?php get_sidebar('single'); ?>

            </aside>
        </div>

    </div>
</main>

<?php get_footer(); ?>

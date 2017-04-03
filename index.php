<?php
/**
 * 博客文章列表
 * url: http://dev.cellmean.com/?post_type=post
 * User: falcon
 * Date: 15/11/15
 * Time: 下午1:37
 * Project: cellmean.com
 */

get_header(); ?>
<!--<div class="bg-note"></div>-->
<main role="main">

    <div class="page-contents container">

        <ol class="breadcrumb">
            <li><a href="#">首页</a></li>
            <li class="active">笔记</li>
        </ol>

        <div class="row">
            <div class="col-sm-8">
                <div class="list-group post-list">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <a class="list-group-item post-item" href="<?php the_permalink(); ?>">
                        <h4 class="list-group-item-heading"><?php the_title(); ?> </h4>
                        <p class="list-group-item-text"><?php the_excerpt(); ?></p>

                    </a>
                        <div class="list-group-item well well-sm">
                            <?php the_tags(); ?>&nbsp;
                            <small class="label label-primary pull-right"><?php echo get_the_date(); ?></small>
                        </div>
                    <?php endwhile; endif;?>
                </div>

                <div class="row">
                <div class="col-sm-12 pagination_wrap">
                    <?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
                </div><!--/.pagination_wrap -->
                </div>
            </div>

            <aside class="col-sm-4 sidebar">
                <?php get_sidebar('index');?>
            </aside>
        </div>

    </div>
</main>

<?php get_footer(); ?>

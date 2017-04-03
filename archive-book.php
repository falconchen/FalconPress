<?php
/**
 * Description: Book模板
 * url:http://dev.cellmean.com/?post_type=book
 * User: falcon
 * Date: 15/11/14
 * Time: 下午4:03
 * Project: cellmean.com
 */
get_header(); ?>

    <main role="main">
        <div class="page-contents container">

            <ol class="breadcrumb">
                <li><a href="#">首页</a></li>
                <li class="active">读书</li>
            </ol>

            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                            <?php echo get_template_part('content','book');?>

                        <?php endwhile;?>
                        <?php endif;?>

                    </div><!--/.row-->

                    <div class="row">
                        <div class="col-sm-12 pagination_wrap">
                            <?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
                        </div><!--/.pagination_wrap -->
                        <!--/.pagination_wrap -->
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="list-group">
                        <a class="list-group-item active" href="#">
                            推荐书单
                        </a>
                        <a class="list-group-item" href="#">Dapibus ac facilisis in</a>
                        <a class="list-group-item" href="#">Morbi leo risus</a>
                        <a class="list-group-item" href="#">Porta ac consectetur ac</a>
                        <a class="list-group-item" href="#">Vestibulum at eros</a>
                    </div>

                    <div class="list-group">
                        <a class="list-group-item active" href="#">
                            阅读排行
                        </a>
                        <a class="list-group-item" href="#">Dapibus ac facilisis in</a>
                        <a class="list-group-item" href="#">Morbi leo risus</a>
                        <a class="list-group-item" href="#">Porta ac consectetur ac</a>
                        <a class="list-group-item" href="#">Vestibulum at eros</a>
                    </div>
                </div>
            </div>

        </div>
    </main>

<?php get_footer(); ?>
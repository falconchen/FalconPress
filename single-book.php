<?php
/**
 * 书籍详情页
 * url: http://dev.cellmean.com/book/%E7%BA%A2%E6%A5%BC%E6%A2%A6/
 * User: falcon
 * Date: 15/11/15
 * Time: 下午1:37
 * Project: cellmean.com
 */

get_header();

//echo get_query_var('cid');
$writer_obj_arr = get_the_terms(get_the_ID(), 'book_writer'); // 获取作家
//$book_meta = get_post_meta(, '_book_meta', true);




?>
<main role="main">
    <div class="page-contents container">

        <ol class="breadcrumb">
            <li><a href="<?php echo home_url();?>">首页</a></li>
            <li><a href="<?php echo home_url('?post_type=book');?>">读书</a></li>
            <li class="active"><?php the_title()?></li>
        </ol>

        <div class="row">
            <div class="col-sm-12 post-list book-info">
                <article class="list-group post-item">
                    <?php if (have_posts()) : while (have_posts()) :
                    the_post(); ?>
                    <div class="list-group-item book-heading">
                        <a class="post-title" href="<?php the_permalink(); ?>">
                            <h4 class="list-group-item-heading "><?php the_title(); ?> </h4>
                        </a>
                    </div>
                    <div class="list-group-item post-meta  row-eq-height">
                        <div class="row">
                            <div class="col-sm-3 meta-item">

                                <div class="book-single-thumbnail thumbnail">
                                    <a href="">
                                        <?php fp_the_post_thumbnail(); ?>
                                    </a>
                                </div>
                            </div>
                            <?php $book_data = get_book_meta(get_the_ID());?>
                            <div class="col-sm-3 meta-item book-meta">

                                <p>作者: <?php writers_html(); ?></p>
                                <p>页数: <?php echo $book_data['pages']; ?></p>
                                <p>定价: <?php echo $book_data['price']; ?></p>
                                <p>出版日期: <?php echo $book_data['publish_date']; ?></p>
                                <p>出版社: <?php echo $book_data['press']; ?></p>
                                <p>ISBN: <?php echo $book_data['isbn']; ?></p>
                                <p>标签: <?php the_tags(''); ?></p>
                                <p>豆瓣评分:</p>
                            </div>

                            <div class="col-sm-6 meta-item book-intro book-meta">

                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#book-content" data-toggle="tab">
                                            内容简介
                                        </a>
                                    </li>
                                    <li><a href="#book-writer" data-toggle="tab">作者简介</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="book-content">
                                        <p>
                                            <?php echo strip_tags(get_the_content(),'<a><img>'); ?>
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="book-writer">
                                        <?php if (!empty($writer_obj_arr)): ?>
                                            <?php foreach ($writer_obj_arr as $writer_obj): ?>
                                                <h5>
                                                    <a href="<?php echo get_term_link($writer_obj->term_id, 'book_writer'); ?>"><?php echo esc_html($writer_obj->name); ?></a>

                                                </h5>
                                                <p><?php echo $writer_obj->description; ?></p>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <h5>暂无</h5>
                                        <?php endif ?>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </article>

                <?php endwhile;
                endif; ?>


            </div>


        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">作品目录</h1>
            </div>
            <div class="panel-body">
                <?php $chapter_arr = get_post_meta(get_the_ID(), '_chapter_arr', true); ?>
                <?php if (is_array($chapter_arr) && !empty($chapter_arr)): ?>
                    <ul class="chapters row">
                        <?php foreach ($chapter_arr as $chapter): ?>
                            <?php if ($chapter['type'] == 'block'): ?>
                                <li class="h4 col-sm-12 <?php echo $chapter['type']; ?>">
                                    <?php echo $chapter['title'] ?>
                                </li>
                            <?php else: ?>
                                <?php if (!isset($col_length)) $col_length = (mb_strlen($chapter['title']) > 20) ? 6 : 3; ?>
                                <li class="col-sm-<?php echo $col_length; ?> <?php echo $chapter['type']; ?>">
                                    <a href="<?php echo add_query_arg('cid',$chapter['cid']);?>"><?php echo $chapter['title'] ?></a>
                                </li>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </ul>
                <?php endif ?>
            </div>

        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">评论</h1>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-8" >
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

</main>

<?php get_footer(); ?>

<?php
/**
 *
 * Description:书籍列表,作家作品列表 单个书籍
 * Author: falcon
 * Date: 15/11/25
 * Time: 下午11:20
 *
 */
?>
<div class="col-sm-4 book-info">

    <div class="book-thumbnail ">
        <a href="#" class="douban btn btn-default btn-sm" role="button">
            <i class="bg-primary fa fa-heart icon"></i>
            评分:暂无
        </a>
        <a href="<?php the_permalink(); ?>">
            <?php fp_the_post_thumbnail(); ?>
        </a>

    </div>

    <div class="caption fp-book-meta">
        <h5><strong><?php the_title(); ?></strong></h5>

        <p>
            类别: <?php get_book_term_link('book_category'); ?>
        </p>

        <p>作者: <?php writers_html(); ?></p>
    </div>

</div>
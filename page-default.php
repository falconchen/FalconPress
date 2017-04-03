<?php
/**
 * Template Name: 默认单列
 *
 * This is the template that displays content in on col.
 *
 */

get_header(); ?>
<main role="main">
<?php while ( have_posts() ) : the_post();?>
    <div class="page-contents container">

        <ol class="breadcrumb">
            <li><a href="<?php bloginfo('url');?>">首页</a></li>
            <li class="active"><?php the_title();?></li>
        </ol>

        <div class="row">
            <div class="col-sm-12 post-list">
                <h1 style="margin-bottom: 30px;"><?php the_title();?></h1>
                <div style="text-indent: 2em;"><?php the_content(); ?></div>
            </div>

        </div>
    </div>
<?php endwhile;?>
</main>
<?php get_footer(); ?>
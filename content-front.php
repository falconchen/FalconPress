<?php
/**
 *
 * Description: front 页的文章列表
 * Author: falcon
 * Date: 15/11/16
 * Time: 下午8:12
 *
 */
?>
<?php $class_thumb = has_post_thumbnail() ? 'has_thumb':'no_thumb'?>
<div <?php post_class("col-sm-4 row-eq-height $class_thumb"); ?> >
    <?php if(has_post_thumbnail()):?>
    <img class="front-row-thumbs" src="<?php echo get_post_thumbnail_url();?>">
    <?php endif;?>
    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

    <div <?php if(has_post_thumbnail()):?>class="front-row-excerpt"<?php endif?>>
        <a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>
    </div>




</div>

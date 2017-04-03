<?php
/**
 *
 * Description:书籍章节模板
 * Author: falcon
 * Date: 15/11/24
 * Time: 下午4:08
 *
 */
get_header();
$book_id = get_the_ID();
$cid = get_query_var('cid');
$chapter_content = get_chapter_content(get_query_var('cid'));

$chapter_arr = get_post_meta($book_id, '_chapter_arr', true);


if (is_array($chapter_arr) && !empty($chapter_arr)) {
    foreach($chapter_arr as $chapter){

        if($chapter['type'] == 'chapter'){
            if(!isset($key)) {
                $key = 0;
            }
            if($chapter['cid'] == $cid){
                $current_index = $key;
                $current_chapter = $chapter;
            }
            $chapter_without_block_arr[$key] = $chapter;
            $key++;
        }

    }

    $prev_chapter = array();
    $next_chapter = array();
    if($current_index > 0) {
        $prev_chapter = $chapter_without_block_arr[$current_index-1];
    }

    if($current_index+1<count($chapter_without_block_arr)) {
        $next_chapter = $chapter_without_block_arr[$current_index+1];
    }

}else{
    wp_die('没有找到该章节',404);
}


function get_chapter_link($chapter_cid,$book_id=null){
    //暂时不使用重写
    if($book_id == null) {
        $post = get_post();
        $book_id = $post->ID;
    }

    return add_query_arg(array('cid'=>$chapter_cid) ,get_the_permalink($book_id));

}


?>
    <main role="main">
        <div class="page-contents container">
            <ol class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li><a href="/book/">读书</a></li>
                <li class="active"><?php the_title()?></li>
            </ol>


            <div class="chapter-container">
                    <div class="col-sm-12 chapter-info">



                        <h2 class="center-block chapter-title"><?php echo esc_html($current_chapter['title']);?></h2>


                        <div class="chapter-content">
                            <?php
                                //echo preg_match_all("#^[\t\r\n\W\b ]*<br />#i",);
                                //$content = $chapter_content;
                                foreach(explode("\n",$chapter_content) as $line) {

                                    if(strlen($line)==0 || in_array($line,array("\n","\t","\r"))){
                                        continue;
                                    }
                                    if(strpos($line,'<p>') === false) {
                                        $line = sprintf("<p>%s</p>\n",$line);
                                    }
                                    echo $line;
                                }
                            ?>
                        </div>


                        <!-- Split button -->
                        <div class="btn-group center-block book-index" role="group" aria-label="">

                            <?php if (!empty($prev_chapter)): ?>
                                <button  type="button" class="book-nav btn btn-default">
                                    <a href="<?php echo get_chapter_link($prev_chapter['cid']);?>">上一篇</a>
                                </button>
                            <?php else:?>
                                <button  type="button" class="book-nav btn btn-default">没有了</button>
                            <?php endif;?>

                            <div class="btn-group dropup" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    作品目录
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php foreach($chapter_arr as $chapter):?>
                                    <li>


                                        <?php if($chapter['type']=='block'):?>
                                        <strong>
                                            &nbsp;<?php echo esc_html($chapter['title'])?>
                                        </strong>

                                        <?php else:?>
                                        <a href="<?php echo get_chapter_link($chapter['cid']);?>">
                                            <?php if($chapter['cid']==$current_chapter['cid']):?>
                                                <span class="fa fa-caret-right" style="margin-left:-8px;"></span>
                                            <?php endif?>
                                            <?php echo esc_html($chapter['title'])?>
                                        </a>
                                        <?php endif?>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <?php if (!empty($next_chapter)): ?>
                                <button  type="button" class="book-nav btn btn-default">
                                    <a href="<?php echo get_chapter_link($next_chapter['cid']);?>">下一篇</a>
                                </button>
                            <?php else:?>
                                <button  type="button" class="book-nav btn btn-default">没有了</button>
                            <?php endif;?>
                        </div>



                    </div>

                <div class="panel panel-default" style="clear: both;margin-top:36px;">
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
        </div>

    </main>
<?php get_footer();

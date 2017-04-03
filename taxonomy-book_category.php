<?php
/**
 * Description: 作家分类模板
 * User: falcon
 * Date: 15/11/14
 * Time: 下午4:03
 * Project: cellmean.com
 * Demo: http://dev.cellmean.com/book_writer/%E7%BD%97%E8%B4%AF%E4%B8%AD/
 */
get_header();


$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$termid = $term->term_id;
$termname = $term->name;
$taxmname = $term->taxonomy;
$description = nl2br($term->description);
?>
    <main role="main">
        <div class="page-contents container">

            <ol class="breadcrumb">
                <li><a href="#">首页</a></li>
                <li class="active">读书</li>
            </ol>


            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="panel-title"><?php echo esc_html($termname);?> </h1>
                        </div>
                        <div class="panel-body">
                            <?php echo $description;?>

                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <?php
                    while (have_posts()) : the_post();
                        echo get_template_part('content','book');
                    endwhile;
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 pagination_wrap">
                    <?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>
                </div><!--/.pagination_wrap -->
                <!--/.pagination_wrap -->
            </div>
        </div>
    </main>
<?php
get_footer();

<?php
/**
 * 模板常量
 * Created by PhpStorm.
 * User: falcon
 * Date: 15/11/15
 * Time: 上午7:26
 * Project: cellmean.com
 */
define('FP_TEMPLATE_DIR_URI',esc_url(get_template_directory_uri()));// 模板目录url,不带 /
//define('FP_FRONT_POST_PER_PAGE',12);
define('FP_FRONT_POST_PER_PAGE',15); // 首页项目一次显示多少条,与系统设置的post_per_page区别,3的倍数
define('FP_ONLINE_TIMESTAMP',strtotime('2015-11-26 17:50') - get_option('gmt_offset') * HOUR_IN_SECONDS); // 上线时间,wordpress使用utc时区
define('FP_DEFAULT_BOOK_COVER',esc_url(get_template_directory_uri()) . '/img/255x340.png');
define('FRONT_POST_CACHE_NUM',5); // 首页项目缓存页数
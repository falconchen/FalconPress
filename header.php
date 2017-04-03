<?php
/**
 * Created by PhpStorm.
 * User: falcon
 * Date: 15/11/14
 * Time: 下午5:28
 * Project: cellmean.com
 */
?>
<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <?php wp_head(); ?>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="apple-touch-icon-precomposed" href="<?php echo FP_TEMPLATE_DIR_URI?>/img/dogg.png"/>
    <link rel="shortcut icon" href="<?php echo FP_TEMPLATE_DIR_URI?>/img/dogg.png" >

    <!-- Modernizr -->
    <script src="<?php echo FP_TEMPLATE_DIR_URI?>/js/vendor/modernizr-2.6.2.min.js"></script>
    <!-- Respond.js for IE 8 or less only -->
    <!--[if (lt IE 9) & (!IEMobile)]>
    <script src="<?php echo FP_TEMPLATE_DIR_URI?>/js/vendor/respond.min.js"></script>
    <![endif]-->

</head>
<body class="<?php echo get_post_type();?>-body">

<!--[if lte IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<header role="banner">
    <nav role="navigation" class="navbar navbar-static-top navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand h1" href="<?php echo home_url('/');?>" style="color:#fff;background:  url(<?php echo FP_TEMPLATE_DIR_URI?>/img/dogg.png) no-repeat right 15px;background-size: 35px;padding-right: 40px;"><?php echo bloginfo('name');?></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li <?php if(is_front_page()):?>class="active"<?php endif;?> ><a href="<?php echo home_url('/');?>">
                            <span class="icon fa fa-home"></span> 首页
                        </a></li>
                    <li <?php if(is_home() OR get_post_type()=='post'):?>class="active"<?php endif;?> ><a href="<?php echo home_url('/?post_type=post');?>">
                            <span class="icon fa fa-pencil"></span> 笔记
                        </a></li>
                    <li <?php if(get_post_type()=='book'):?>class="active"<?php endif?>><a href="<?php echo home_url('/?post_type=book');?>">
                            <span class="icon fa fa-book"></span> 读书
                        </a></li>
                    <li <?php if(get_post_type()=='video'):?>class="active"<?php endif?>><a href="<?php echo home_url('/?post_type=video');?>">
                            <span class="icon fa fa-film"></span> 视频
                        </a></li>
                    <li <?php if(get_post_type()=='music'):?>class="active"<?php endif?>><a href="<?php echo home_url('/?post_type=music');?>">
                            <span class="icon fa fa-music"></span> 音乐
                        </a></li>
                    <li class="disabled" <?php if(get_post_type()=='time'):?>class="active"<?php endif?>><a href="<?php echo home_url('/?post_type=time');?>">
                            <span class="icon fa fa-calendar"></span> 时间轴
                        </a></li>
                </ul>
                <div class="header-search pull-right"><?php fp_get_search_form();?></div>
            </div><!--/.nav-collapse -->

        </div><!--/.container -->
    </nav>
</header>

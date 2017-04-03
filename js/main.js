jQuery(document).ready(function ($) {

    // disale 点击无效化
    $('.disabled > a').click(function(e){
        e.preventDefault();
    });

    // 书籍上下章导航条
    $('.book-nav').click(
        function () {
            location.href = $(this).children('a').first().attr('href');
            return false;
        }
    );


    // 自定义滚动条
    $("#book-content,#book-writer,#lyric").mCustomScrollbar({
        theme: "dark-thin",
        setHeight: '280px',
        scrollInertia: 400,
        scrollButtons: {enable: true},
        //theme:"light-thick",
        scrollbarPosition: "outside"
    });


    // 语法高亮
    $('pre,code').each(function (i, block) {
        hljs.highlightBlock(block);
    });


    // 加载front page 的文章列表
    var front_load_page = 1;
    $('.read-more-frontpage a').live('click', function () {

        front_load_page++;
        var url = ajaxurl + '?action=load_front_articles&paged=' + front_load_page;
        var _this = $(this);
        _this.find('.loading').removeClass('hidden');
        $.get(url, function (data) {
            $('.front-articles').append(data);
            _this.find('.loading').addClass('hidden');
            //console.log(data);
        });
        return false;
        //$('.front-articles').load();

    })

    display_runing_time()
    setInterval(display_runing_time, 1000)

    function display_runing_time() {

        var time_obj = site_runing_total(online_timestamp);

        if ("undefined" == typeof time_text) {
            time_text = $('.site-running-cal').html();
        }
        var time_text_echo = time_text.replace(/%day%/, time_obj.day).replace(/%hour%/, time_obj.hour).replace(/%minute%/, time_obj.minute).replace(/%second%/, time_obj.second);

        $('.site-running-cal').removeClass('hidden').html(time_text_echo);
    }


    var load_comment =setInterval(function(){
        if($('#uyan_frame').children('iframe').length > 0) {
            $('.loading-comment').fadeOut();
            clearInterval(load_comment);
        }
    },300);
});


// 当前时间与指定timestamp的差距
function site_runing_total(start) {

    // 站点运行计时器
    var timestamp1 = Date.parse(new Date());

    var between_seconds = (timestamp1 / 1000) - start;

    var day = parseInt((between_seconds) / (3600 * 24));

    var rest_sec = (between_seconds) % (3600 * 24);

    var hour = parseInt(rest_sec / 3600);

    var rest_sec2 = rest_sec % 3600;

    var minute = parseInt(rest_sec2 / 60);

    var second = rest_sec2 % 60;

    hour = hour < 10 ? '0'+hour : hour;

    minute = minute < 10 ? '0'+minute : minute;

    second = second < 10 ? '0'+second :second;

    return {'day': day, 'hour': hour, 'minute': minute, 'second': second};


}



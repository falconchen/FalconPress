<?php
/**
 * Footer
 * User: falcon
 * Date: 15/11/14
 * Time: 下午5:28
 * Project: cellmean.com
 */
?>
<HR/>
<footer role="contentinfo" class="<?php echo get_post_type();?>-footer">

    <div>

            <h3 class="copyright"><small> 2015 - 2017 &copy; <?php echo bloginfo('name');?></small></h3>




            <h3 class="copyright" style="margin-top:0 "><small style="color:#999">Powered By <a href="">WordPress</a>  | Theme : <a href="#">FalconPress</a></small>

            </h3>

            <span>
                    <i class="fa fa-cog fa-spin animated h5"></i>
                    <small class="site-running-cal hidden"  style="color:#999">已运行: %day%天%hour%时%minute%分%second%秒</small>
            </span>

    </div>


</footer>
<?php wp_footer(); ?>


</body>
</html>

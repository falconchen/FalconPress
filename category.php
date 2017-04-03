<?php
/**
 * Description: 作家分类模板
 * User: falcon
 * Date: 15/11/14
 * Time: 下午4:03
 * Project: cellmean.com
 * Demo: http://dev.cellmean.com/book_writer/%E7%BD%97%E8%B4%AF%E4%B8%AD/
 */


			// Start the Loop.
			while ( have_posts() ) : the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                the_title();

                // End the loop.
            endwhile;
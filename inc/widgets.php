<?php
/**
 *
 * Description:
 * Author: falcon
 * Date: 15/11/21
 * Time: 下午6:23
 *
 */

// 使用Bootstrap风格搜索栏
class FP_Widget_Search extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'fp_widget_search', 'description' => __( "Bootstrap风格的搜索栏",'fp') );
        parent::__construct( 'fp_search', __('Bootstrap Search Form'), $widget_ops );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        if(!isset($instance['endformtext'])) $instance['endformtext'] = '';
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Use current theme search form if it exists
        // get_search_form();

        echo fp_get_search_form();
        echo $instance['endformtext'];
        echo $args['after_widget'];
    }

    /**
     * @param array $instance
     */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '','endformtext'=>'') );
        $endformtext = $instance['endformtext'];
        $title = $instance['title'];
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('endformtext'); ?>"><?php _e('endformtext:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('endformtext'); ?>" name="<?php echo $this->get_field_name('endformtext'); ?>" type="text" value="<?php echo esc_attr($endformtext); ?>" /></label></p>
        <?php
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['endformtext'] = $new_instance['endformtext'];
        return $instance;
    }

}

class TG_Img_Show extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array( 'description' => __('显示自定义图片') );
        parent::__construct( 'tg_img_show', __('TG显示自定义图片小工具'), $widget_ops );
    }

    function widget($args, $instance)
    {
        echo $args['before_widget'];

        if ( !empty($instance['title']) )
            echo '<span>'.$args['before_title'] . $instance['title'] . $args['after_title'].'</span>';

        echo '<img src="',$instance['text'],'" title="',$instance['tip'],'" alt="',$instance['tip'],'" />';

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        $instance['text'] = $new_instance['text'];
        $instance['tip'] = strip_tags( stripslashes($new_instance['tip']) );
        return $instance;
    }

    function form($instance)
    {
        $text = isset( $instance['text'] ) ? $instance['text'] : '';
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $tip = isset( $instance['tip'] ) ? $instance['tip'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('图片url：') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $text; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tip'); ?>"><?php _e('图片tip：') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('tip'); ?>" name="<?php echo $this->get_field_name('tip'); ?>" value="<?php echo $tip; ?>" />
        </p>
        <?php
    }
}


/**
 * 相关内容,按tag相关
 */
class FP_Widget_Related_Entries extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_related_entries', 'description' => __( "根据tag取得的相关文章",'fp') );
        parent::__construct('related-entries', __('Related entries','fp'), $widget_ops);
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {


        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] :'';

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $exclude_tags = isset($instance['exclude_tags']) ? explode(',',$instance['exclude_tags']) :array();

        $exclude_tag_ids = array();
        foreach($exclude_tags as $term_name){
            $term = get_term_by('name',$term_name,'post_tag');
            $exclude_tag_ids[] = $term->term_id;
        }


        ob_start();


        $post_id = get_the_ID();
        $tags_arr = get_the_tags($post_id);
        if(empty($tags_arr)) return;
        $tag_ids = array();

        foreach($tags_arr as $tag_obj){
            if(in_array($tag_obj->term_id,$exclude_tag_ids)){
                continue;
            }
            $tag_ids[] = $tag_obj->term_id;

        }

        $r = new WP_Query( apply_filters( 'fp_widget_related_entries_args', array(
            'tag__in' =>$tag_ids,
            'posts_per_page'      => $number,
            'post__not_in'=>array($post_id),
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );


        if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>

                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                        <a class="list-group-item" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?>
                        <?php if ( $show_date ) : ?>
                            <p><small class=""><?php echo get_the_date(); ?></small></p>
                        <?php endif; ?>
                        </a>
                <?php endwhile; ?>
            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {

            $cache[ $args['widget_id'] ] = ob_get_flush();
            //wp_cache_set( 'widget_recent_posts', $cache, 'widget' );

        } else {
            ob_end_flush();
        }
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['exclude_tags'] = strip_tags($new_instance['exclude_tags']);
        return $instance;
    }


    /**
     * @param array $instance
     */
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        $exclude_tags     = isset( $instance['exclude_tags'] ) ? esc_attr( $instance['exclude_tags'] ) : '';
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>

        <p><label for="<?php echo $this->get_field_id( 'exclude_tags' ); ?>"><?php _e( 'Exclude tags: ','fp' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'exclude_tags' ); ?>" name="<?php echo $this->get_field_name( 'exclude_tags' ); ?>" type="text" value="<?php echo $exclude_tags; ?>" size="35" /></p>
        <?php
    }
}


// bootstarp风格的归档


class FP_Widge_Archives extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'fp_widget_archive', 'description' => __( 'Bootstrap风格归档','fp') );
        parent::__construct('fp_archives', __('Bootstrap风格归档','fp'), $widget_ops);
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Archives' ) : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        ?>


        <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>

                <?php
                /**
                 * Filter the arguments for the Archives widget.
                 *
                 * @since 2.8.0
                 *
                 * @see wp_get_archives()
                 *
                 * @param array $args An array of Archives option arguments.
                 */
                wp_get_archives( apply_filters( 'widget_archives_args', array(
                    'type'            => 'monthly',
                    'show_post_count' => $c,
                    'format'=>'custom',
                ) ) );
                ?>
            </ul>
            <?php


        echo $args['after_widget'];
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        //$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }

    /**
     * @param array $instance
     */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
        </p>
        <?php
    }
}


/**
 * FP Tag cloud widget class
 *

 */
class FP_Widget_Tag_Cloud extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'description' => __( "Bootstrap风格的标签云",'fp') );
        parent::__construct('fp_tag_cloud',__( "Bootstrap风格的标签云",'fp'), $widget_ops);
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        if ( !empty($instance['title']) ) {
            $title = $instance['title'];
        } else {
            if ( 'post_tag' == $current_taxonomy ) {
                $title = __('Tags');
            } else {
                $tax = get_taxonomy($current_taxonomy);
                $title = $tax->labels->name;
            }
        }
        $exclude_tags = array();
        foreach(explode(',',$instance['excludes']) as $tag){
            $term_obj = get_term_by('name',$tag,$current_taxonomy);
            $exclude_tags[] = $term_obj->term_id;
        }


        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div class="tagcloud list-group-item">';

        /**
         * Filter the taxonomy used in the Tag Cloud widget.
         *
         * @since 2.8.0
         * @since 3.0.0 Added taxonomy drop-down.
         *
         * @see wp_tag_cloud()
         *
         * @param array $current_taxonomy The taxonomy to use in the tag cloud. Default 'tags'.
         */
        wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array(
            'taxonomy' => $current_taxonomy,
            'exclude'=>$exclude_tags
        ) ) );

        echo "</div>\n";
        echo $args['after_widget'];
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
        $instance['excludes'] = stripslashes($new_instance['excludes']);
        return $instance;
    }

    /**
     * @param array $instance
     */
    public function form( $instance ) {
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:') ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
            <?php foreach ( get_taxonomies() as $taxonomy ) :
                $tax = get_taxonomy($taxonomy);
                if ( !$tax->show_tagcloud || empty($tax->labels->name) )
                    continue;
                ?>
                <option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
            <?php endforeach; ?>
        </select></p>

        <p><label for="<?php echo $this->get_field_id('excludes'); ?>"><?php _e('排除的标签:','fp') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('excludes'); ?>" name="<?php echo $this->get_field_name('excludes'); ?>" value="<?php if (isset ( $instance['excludes'])) {echo esc_attr( $instance['excludes'] );} ?>" /></p>
        <?php
    }

    /**
     * @param array $instance
     * @return string
     */
    public function _get_current_taxonomy($instance) {
        if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
            return $instance['taxonomy'];

        return 'post_tag';
    }
}
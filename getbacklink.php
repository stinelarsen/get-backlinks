<?php 
/*
Plugin Name: Get backlink Plugin
Contributors: kristofferknase
Description: Let your visitors link back to your site
Tags: Backlinks, linking, link to us,
Tested up to: 4.7
Version: 1.0
Author: kristofferknase
Author URI: http://
License: GPLv2
*/

class Getbacklink_Widget extends WP_Widget {
     
    function __construct() {
        parent::__construct(
         
            // base ID of the widget
            'getbacklink_widget',
             
            // name of the widget
            __('Get backlink: Link to us', 'getbacklink' ),
             
            // widget options
            array (
                'description' => __( 'Lets visitors easy link to you by copy a done html code widget.', 'getbacklink' )
            )
             
        );
    }
     
       
    function widget( $args, $instance ) {
       
        //wp_enqueue_script('clipboardjs', plugin_dir_url(__FILE__) . 'js/clipboard.min.js');
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title']; 
extract($args);
$checkbox_var = $instance[ 'checkbox_var' ] ? 'true' : 'false';
 
       
  if ($instance['checkbox_var'] == "on") { 
$currenturl = get_bloginfo( 'url' );
$blogname = get_bloginfo( 'name' );
 echo '<textarea id="bar" class="textlanka">&lt;a href='. $currenturl .'&gt;' . $blogname . '&lt;/a&gt;</textarea>
';
 }
 else{
$currenturl = get_permalink( $post->ID );
$blogtitle =  get_the_title();
 $blogname = get_bloginfo( 'name' );
 echo '<textarea id="bar" class="textlanka">&lt;a href='. $currenturl .'&gt;' . $blogname .'-'.$blogtitle . '&lt;/a&gt;</textarea>
';
 }
?>
<style>
.textlanka {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
   width: 100%;
   height: 100%;
}
</style>

<?php
 ?>
    <span style= "float:left;"><button class="btn btn-primary" data-clipboard-action="copy" data-clipboard-target="#bar">Copy</button></span><p style="text-align:right; font-size:8px"><a href="http://getbacklinksplugin.com">Made by kristofferknase</a></p>
 
 <script src="https://cdn.jsdelivr.net/clipboard.js/1.5.13/clipboard.min.js"></script>

 <script>

    var clipboard = new Clipboard('.btn');
clipboard.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);
    e.trigger.textContent = 'Copied';
    window.setTimeout(function() {
        e.trigger.textContent = 'Copy';
    }, 3000);
     e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
    e.trigger.textContent = 'Press "Ctrl + C" to copy';
    window.setTimeout(function() {
        event.trigger.textContent = 'Copy';
    }, 3000);
});

    </script>

    <?php 
        echo $args['after_widget'];
    } 

     
    

  function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'text_domain' );
        }
        ?>
     
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'getbacklink'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
     <p>
    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'checkbox_var' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'checkbox_var' ); ?>" name="<?php echo $this->get_field_name( 'checkbox_var' ); ?>" /> 
    <label for="<?php echo $this->get_field_id( 'checkbox_var' ); ?>">Only use frontpage URL and title</label>
</p>
  
  
        <?php 

  
    }
     
    function update( $new_instance, $old_instance ) { 
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance[ 'checkbox_var' ] = strip_tags( $new_instance[ 'checkbox_var' ] );
        return $instance;      
    }
}

function getbacklink_widget() {
 
    register_widget( 'Getbacklink_Widget' );
 
}
add_action( 'widgets_init', 'getbacklink_widget' );



function getbacklink_widget_shortcode($atts) {
    
    global $wp_widget_factory;
        
    $widget_name = 'Getbacklink_Widget';
       if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, array(), array('widget_id'=>'arbitrary-instance-lankaoss_widget',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('get_backlink','getbacklink_widget_shortcode'); 

?>
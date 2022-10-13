<?php
// The widget class
class JWPext_News_Ticker_Widget extends WP_Widget {
    
    // Main constructor
    public function __construct() {
        $widget_ops  = array(
            'classname'   => 'news_ticker_widget',
            'description' => __( 'use Shortcode to show News Ticker', 'news-ticker-anywhere' ),
        );
        $control_ops = array();
        parent::__construct( 'jwpext_news_ticker_widget', __( 'News Ticker Widget', 'news-ticker-anywhere' ), $widget_ops, $control_ops );
    }
    // The widget form (for the backend )
    public function form( $instance ) {
        // Set widget defaults
        $defaults = array(
            'text'     => '',
        );
        // Parse current settings with defaults
        extract( wp_parse_args( ( array ) $instance, $defaults ) ); 
        ?>

    	<?php // Widget Title ?>
    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo __( 'Shortcode Text:', 'news-ticker-anywhere' ); ?></label>
    		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text); ?></textarea>
    	</p>
    <?php }
    
    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['text'] = wp_kses_post( $new_instance['text'] );
        return $instance;
    }
    // Display the widget
    public function widget( $args, $instance ) {
        extract( $args );
        // Check the widget options
        $text = do_shortcode( apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance, $this ) );
        echo $args['before_widget'];
        ?>
        <div class="jwpext-textwidget"><?php echo wp_kses_post($text); ?></div>
        <?php
        echo $args['after_widget'];
    }
}

// Register the widget
function my_register_jwpext_news_ticker_widget($page) {  
    register_widget( 'JWPext_News_Ticker_Widget' );
}
function news_ticker_load_widget_scripts($page){
    if ($page !== 'widgets.php') return;
    wp_enqueue_style('admin-newsanywhere-custom-css', NEWSANW_DIRURL.'template/assets/css/css_widget.css');
    wp_enqueue_script('admin-metro-js', NEWSANW_DIRURL.'template/assets/js/metro.min.js');
}
add_action( 'widgets_init', 'my_register_jwpext_news_ticker_widget' );
?>
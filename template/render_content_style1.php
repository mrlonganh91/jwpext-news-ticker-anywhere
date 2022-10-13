<?php
if(sanitize_text_field($news_ticker_attr['animate'])){
    $class_animate = sanitize_text_field($news_ticker_attr['animate']);
}else{
	$class_animate = 'bounce';
}
if(sanitize_text_field($news_ticker_attr['mouse_pause'])=='on'){
	$mouse_pause = 'true';
}else{
	$mouse_pause = 'false';
}
if(sanitize_text_field($news_ticker_attr['auto_play'])=='on'){
	$auto_play = 'true';
}else{
	$auto_play = 'false';
}
if(sanitize_text_field($news_ticker_attr['controll_button'])=='on'){
	$controll_button = '';
}else{
	$controll_button = 'jwext-hid-controll-button';
}

require_once ABSPATH . 'wp-includes/class-phpass.php';
$hasher      = new PasswordHash( 8, false );
$button_id = '-' . substr( md5( $hasher->get_random_bytes( 32 ) ), 2 );

?>

<div class="jwpext-news-ticker-wrapper">
	<?php 
		if(esc_html($news_ticker_attr['title'])){
			echo '<h2>'.esc_html($news_ticker_attr['title']).'</h2>';	
		}
	?>
	<div class="jwext-news-demo1 jwext-news-demof jwext-news-control-but" id="<?php echo $button_id;?>">
		<ul>
			<?php 
			$i=0;
			foreach($postids as $postid){
				$object = get_post( $postid );
				$url 	= wp_get_attachment_url( get_post_thumbnail_id($postid), 'thumbnail' );
				if(!$url){
					$url = NEWSANW_DIRURL.'template/assets/images/'.'demo.jpg';
				}
				if($i%2=='1'){
					$classli = 'odd';
				}else{
					$classli = '';
				}
				//$content = $object->post_content;
				//$content = apply_filters('the_content', $content);
				//$content = str_replace(']]>', ']]&gt;', $content);
				//$content=get_post_field('post_content', $postid);
			?>
			<li class="animated <?php echo $class_animate;?> <?php echo $classli;?>">				
				<img src="<?php echo $url;?>" alt="<?php echo esc_html($object->post_title);?>" />
				<a href="<?php echo get_permalink( $postid );?>"><?php echo esc_html($object->post_title);?></a>
				<p><?php echo $this->limit_string(wp_strip_all_tags($object->post_content),esc_html($news_ticker_attr['limit_desc']));?></p>
			</li>
			<?php $i++;}?>
		</ul>
		<div class="jwext-news-navi <?php echo $controll_button;?>">
			<span class="<?php echo 'btnDown'.$button_id;?>"></span>			
			<span class="<?php echo 'btnUp'.$button_id;?>"></span>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
	jQuery('#'+'<?php echo $button_id;?>').easyTicker({
		direction: '<?php echo esc_html($news_ticker_attr['direction']);?>',
		easing: 'swing',
		visible: '<?php echo (int)esc_html($news_ticker_attr['visible']);?>',
		width: '<?php echo esc_html($news_ticker_attr['width']);?>',
		height: '<?php echo esc_html($news_ticker_attr['height']);?>',
		interval: '<?php echo (int)esc_html($news_ticker_attr['interval']);?>',
		mousePause: <?php echo esc_html($mouse_pause);?>,
        autoplay: <?php echo esc_html($auto_play);?>,
		controls: {
			up: 'span.<?php echo 'btnUp'.$button_id;?>',
			down: 'span.<?php echo 'btnDown'.$button_id;?>',			
		},
		callbacks: {
            before: function(ul, li){
                
            },
            after: function(ul, li){
               
            },
            finish: function(a){
               
            }
        }		
	});
	
});
</script>
<?php
if($news_ticker_attr['style']=='1'){
    include NEWSANW_DIREXT . '/template/render_content_style1.php';
}else if($news_ticker_attr['style']=='2'){    
    include NEWSANW_DIREXT . '/template/render_content_style2.php';
}else if($news_ticker_attr['style']=='3'){    
    include NEWSANW_DIREXT . '/template/render_content_style3.php';
}
?>

<?php
/**
 * Renders the content of the menu page for the News Ticker Anywhere plugin.
 *
 * @since    1.0.0
 *
 * @package     News Ticker Anywhere
 * @subpackage  core
 */

//GET CUSTOM POST TYPE
$args=array(
    'public'   => true,
    '_builtin' => true//Boolean. If true, will return WordPress default post types. Use false to return only custom post types.
  );
$output       = 'names'; // or objects
$operator     = 'and';
$taxonomies   = get_taxonomies($args,$output,$operator); 

$args=array(
    'public'   => true,
    '_builtin' => false//Boolean. If true, will return WordPress default post types. Use false to return only custom post types.
  );
$output       = 'names'; // or objects
$operator     = 'and';
$taxonomies_custom   = get_taxonomies($args,$output,$operator); 

$class_postype_hide = '';

if(empty($jwext_news_ticker_assigncat)){
    $class_postype_hide = 'jl-postype-hide';
}

?>

<div class="container">

	<h1 class="animated bounce">News Ticker Anywhere</h1>
	
	<div class="grid">
        <div class="row">
            <div class="cell-12">
                <div class="itemIntroText">
                    <ul>
                        <li>This plugin will show news ticker anywhere on your webpage.</li>
                        <li>News Ticker Anywhere lets you add and display news or your post categories with shortcodes. 
                        	This fantastic WordPress news ticker plugin is compatible with custom post types.
							Its customizable shortcode can be adjusted to change the attribute or select specific post categories. 
							The plugin provides you features like adding custom color, effects & animations, etc. </li>
                        <li>Or you can use short code:
                            <ul>
                                <li>[newsanywhere style="1" direction="1" animate="bounce" width="auto" height="auto" interval="5000" visible="3" auto_play="on" mouse_pause="on" controll_button="on" cat="1,2,3" title="News Ticker Anywhere" limit_desc="150" limit_post="15"]</li>
                                <li>style=1[Aqua] style=2[Rounder] style=3[Headline]</li>
                                <li>direction=1[Up] direction=2[Down]</li>
                                <li>width=auto[reponsive] width=200[set px]</li>
                                <li>height=auto[reponsive] height=200[set px]</li>
                                <li>interval=5000[milisecond]</li>
                                <li>visible=3[The number of visible elements of the list can be set to this property.]</li>
                                <li>auto_play[on/off]</li>
                                <li>mouse_pause[on/off]</li>
                                <li>controll_button[on/off]</li>
                                <li>cat[category id:1,2,3]</li>
                                <li>title[show top frontend plugin]</li>
                                <li>limit_desc[Counts the number of Post description]</li>
                                <li>limit_post[Set limit of Post in category]</li>
                            </ul>
                        </li>            
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell-6">
                <form action="#" method="post" id="popup-form">
                	<?php include_once NEWSANW_COREEXT . '/render_news_ticker_anywhere.php';?>                	
                    <div class="form-group">
                    	<input type="hidden" value='<?php echo addslashes(json_encode($jwext_cat_postype));?>' name="jwext_hid_cat_postype" id="jwext_hid_cat_postype"/>
                    	<input type="hidden" value="<?php echo admin_url('admin-ajax.php');?>" name="jwext_news_admin_url" id="jwext_news_admin_url"/>
                        <button id="jwext-btn-save" class="button-primary"><?php echo __('Save','news-ticker-anywhere');?></button> 
                        <?php wp_nonce_field( 'news-ticker-anywhere-page-save', 'news-ticker-anywhere-page-save-nonce' ); ?>                   
                    </div>
                </form>
            </div>
        </div>
    </div>    
	

</div><!-- .wrap -->

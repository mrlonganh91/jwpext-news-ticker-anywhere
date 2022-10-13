<?php
/**
 * Renders the content of the menu page for the News Ticker Anywhere plugin.
 *
 * @since    1.0.0
 *
 * @package     News Ticker Anywhere
 * @subpackage  core
 */

?>
<div data-role="accordion" data-one-frame="true" data-show-active="true">
    <div class="frame">
        <div class="heading"><?php echo __( 'Basic Config', 'news-ticker-anywhere' );?></div>
        <div class="content">
            <div class="p-2">
            	<div class="form-group">
                    <label><?php echo __( 'Select Style', 'news-ticker-anywhere' );?></label>                    
                    <select data-role="select" name="jwext_news_stype" class="jwext_news_stype">                            
                        <option value="1" <?php echo isset($jwext_news_stype) && $jwext_news_stype==1?"selected":"" ?>><?php echo __( 'Aqua', 'news-ticker-anywhere' );?></option>
                        <option value="2" <?php echo isset($jwext_news_stype) && $jwext_news_stype==2?"selected":"" ?>><?php echo __( 'Rounder', 'news-ticker-anywhere' );?></option>
                        <option value="3" <?php echo isset($jwext_news_stype) && $jwext_news_stype==3?"selected":"" ?>><?php echo __( 'Headline', 'news-ticker-anywhere' );?></option>                            
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo __( 'Direction', 'news-ticker-anywhere' );?></label>                    
                    <select data-role="select" name="jwext_news_direction">      
                        <option value="1" <?php echo isset($jwext_direction) && $jwext_direction==1?"selected":"" ?>><?php echo __( 'Up', 'news-ticker-anywhere' );?></option>                      
                        <option value="2" <?php echo isset($jwext_direction) && $jwext_direction==2?"selected":"" ?>><?php echo __( 'Down', 'news-ticker-anywhere' );?></option>                                            
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo __( 'Animate', 'news-ticker-anywhere' );?></label>                    
                    <select data-role="select" name="jwext_news_animate">      
                        <option value="bounce" <?php echo isset($jwext_direction) && $jwext_direction=='bounce'?"selected":"" ?>><?php echo __( 'bounce', 'news-ticker-anywhere' );?></option>                      
                        <option value="rubberBand" <?php echo isset($jwext_direction) && $jwext_direction=='rubberBand'?"selected":"" ?>><?php echo __( 'rubberBand', 'news-ticker-anywhere' );?></option>                                            
                        <option value="shakeX" <?php echo isset($jwext_direction) && $jwext_direction=='shakeX'?"selected":"" ?>><?php echo __( 'shakeX', 'news-ticker-anywhere' );?></option>                      
                        <option value="shakeY" <?php echo isset($jwext_direction) && $jwext_direction=='shakeY'?"selected":"" ?>><?php echo __( 'shakeY', 'news-ticker-anywhere' );?></option>                                            
                        <option value="swing" <?php echo isset($jwext_direction) && $jwext_direction=='swing'?"selected":"" ?>><?php echo __( 'swing', 'news-ticker-anywhere' );?></option>                      
                        <option value="tada" <?php echo isset($jwext_direction) && $jwext_direction=='tada'?"selected":"" ?>><?php echo __( 'tada', 'news-ticker-anywhere' );?></option>
                        <option value="wobble" <?php echo isset($jwext_direction) && $jwext_direction=='wobble'?"selected":"" ?>><?php echo __( 'wobble', 'news-ticker-anywhere' );?></option>
                        <option value="jello" <?php echo isset($jwext_direction) && $jwext_direction=='jello'?"selected":"" ?>><?php echo __( 'jello', 'news-ticker-anywhere' );?></option>
                        <option value="heartBeat" <?php echo isset($jwext_direction) && $jwext_direction=='heartBeat'?"selected":"" ?>><?php echo __( 'heartBeat', 'news-ticker-anywhere' );?></option>
                        <option value="backInDown" <?php echo isset($jwext_direction) && $jwext_direction=='backInDown'?"selected":"" ?>><?php echo __( 'backInDown', 'news-ticker-anywhere' );?></option>
                        <option value="backInLeft" <?php echo isset($jwext_direction) && $jwext_direction=='backInLeft'?"selected":"" ?>><?php echo __( 'backInLeft', 'news-ticker-anywhere' );?></option>
                        <option value="backInRight" <?php echo isset($jwext_direction) && $jwext_direction=='backInRight'?"selected":"" ?>><?php echo __( 'backInRight', 'news-ticker-anywhere' );?></option>
                        <option value="backInUp" <?php echo isset($jwext_direction) && $jwext_direction=='backInUp'?"selected":"" ?>><?php echo __( 'backInUp', 'news-ticker-anywhere' );?></option>
                        <option value="flip" <?php echo isset($jwext_direction) && $jwext_direction=='flip'?"selected":"" ?>><?php echo __( 'flip', 'news-ticker-anywhere' );?></option>
                        <option value="flipInX" <?php echo isset($jwext_direction) && $jwext_direction=='flipInX'?"selected":"" ?>><?php echo __( 'flipInX', 'news-ticker-anywhere' );?></option>
                        <option value="flipInY" <?php echo isset($jwext_direction) && $jwext_direction=='flipInY'?"selected":"" ?>><?php echo __( 'flipInY', 'news-ticker-anywhere' );?></option>   
                        
                        <option value="lightSpeedInRight" <?php echo isset($jwext_direction) && $jwext_direction=='lightSpeedInRight'?"selected":"" ?>><?php echo __( 'lightSpeedInRight', 'news-ticker-anywhere' );?></option>
                        <option value="lightSpeedInLeft" <?php echo isset($jwext_direction) && $jwext_direction=='lightSpeedInLeft'?"selected":"" ?>><?php echo __( 'lightSpeedInLeft', 'news-ticker-anywhere' );?></option>
                        <option value="zoomIn" <?php echo isset($jwext_direction) && $jwext_direction=='zoomIn'?"selected":"" ?>><?php echo __( 'zoomIn', 'news-ticker-anywhere' );?></option>
                        <option value="zoomInDown" <?php echo isset($jwext_direction) && $jwext_direction=='zoomInDown'?"selected":"" ?>><?php echo __( 'zoomInDown', 'news-ticker-anywhere' );?></option>  
                        <option value="zoomInLeft" <?php echo isset($jwext_direction) && $jwext_direction=='zoomInLeft'?"selected":"" ?>><?php echo __( 'zoomInLeft', 'news-ticker-anywhere' );?></option>
                        <option value="zoomInRight" <?php echo isset($jwext_direction) && $jwext_direction=='zoomInRight'?"selected":"" ?>><?php echo __( 'zoomInRight', 'news-ticker-anywhere' );?></option>  
                        <option value="zoomInUp" <?php echo isset($jwext_direction) && $jwext_direction=='zoomInUp'?"selected":"" ?>><?php echo __( 'zoomInUp', 'news-ticker-anywhere' );?></option>  
                                        
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo __( 'Setup width & height News Ticker(number or auto)', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="text" data-role="input" data-prepend="Width News: " name="jwext_news_width" value="<?php echo esc_html($jwext_news_width);?>">                                        
                    <input type="text" data-role="input" data-prepend="Height News: " name="jwext_news_height" value="<?php echo esc_html($jwext_news_height);?>">
                </div>
                <hr/>
                <div class="form-group">
                    <label><?php echo __( 'Auto play.', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="checkbox" data-role="switch" <?php echo esc_html($jwext_news_auto_play)=='on'?"checked":"" ?> data-material="true" name="jwext_news_auto_play" id="jwext_news_auto_play">
                </div>
                <div class="form-group">
                    <label><?php echo __( 'The time for the next transition to take place. Values: time in milliseconds', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="text" data-role="input" data-prepend="Interval: " name="jwext_news_interval" value="<?php echo esc_html($jwext_news_interval);?>">
                </div>   
                <div class="form-group">
                    <label><?php echo __( 'The number of visible elements of the list can be set to this property.(1 or 2 or 3...)', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="text" data-role="input" data-prepend="Visible: " name="jwext_news_visible" value="<?php echo esc_html($jwext_news_visible);?>">
                </div>
                <hr/>
                <div class="form-group">
                    <label><?php echo __( 'The timer can be stopped when the mouse rolls over the element.', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="checkbox" data-role="switch" <?php echo esc_html($jwext_news_mouse_pause)=='on'?"checked":"" ?> data-material="true" name="jwext_news_mouse_pause" id="jwext_news_mouse_pause">
                </div>
                <hr/> 
                <div class="form-group">
                    <label><?php echo __( 'The controls property is used to assign the elements which control the transition. The value is an object with the following properties.', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="checkbox" data-role="switch" <?php echo esc_html($jwext_news_controll_button)=='on'?"checked":"" ?> data-material="true" name="jwext_news_controll_button" id="jwext_news_controll_button">
                </div>
                <hr/>                                    
    
            </div>
        </div>
    </div>     
    <div class="frame">
        <div class="heading"><?php echo __( 'Advance Config', 'news-ticker-anywhere' );?></div>
        <div class="content">
        	<div class="p-2">                                    
                <div class="form-group" id="popup-assign-show">
                    <label><?php echo __( 'Assign Categories', 'news-ticker-anywhere' );?></label><br/>
                    <select data-role="select" multiple name="jwext_news_ticker_assigncat[]" id="jwext_news_ticker_assigncat">
                        <?php
                            if(count($taxonomies)){
                                echo '<optgroup label="Categories of Wordpress">';
                                foreach($taxonomies as $k=>$v){
                                    ?>
                                        <option value="<?php echo esc_html($k);?>" <?php echo isset($jwext_news_ticker_assigncat) && in_array(esc_html($k), $jwext_news_ticker_assigncat)?"selected":"" ?>><?php echo ucwords(esc_html($v));?></option>            
                                    <?php
                                }
                                echo '</optgroup>';
                            }
                            if(count($taxonomies_custom)){
                                echo '<optgroup label="Categories of Custom Post type">';
                                foreach($taxonomies_custom as $k=>$v){
                                    ?>
                                        <option value="<?php echo esc_html($k);?>" <?php echo isset($jwext_news_ticker_assigncat) && in_array(esc_html($k), $jwext_news_ticker_assigncat)?"selected":"" ?>><?php echo ucwords(esc_html($v));?></option>            
                                    <?php
                                }
                                echo '</optgroup>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group <?php //echo $class_postype_hide;?>" id="news-tickers-item-form-group">
                    <label><?php echo __( 'Items Categories Assign to show Posts', 'news-ticker-anywhere' );?></label><br/>
                    <div id="div-render-popup-item">
                          <?php                                                 
                            echo '<select data-role="select" multiple id="select-render-cat-item" name="jwext_cat_postype[]">';
                                if(!empty($jwext_cat_postype)){
                                    echo $this->getItemsCustom($jwext_cat_postype,$jwext_news_ticker_assigncat);                                                        
                                }
                            echo '</select>';
                          ?>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php echo __( 'Fill Title to show in frontend plugin', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="text" data-role="input" data-prepend="Title: " name="jwext_news_title" value="<?php echo esc_html($jwext_news_title);?>">
                </div>
                <div class="form-group">
                    <label><?php echo __( 'Counts the number of Post desc', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="text" data-role="input" data-prepend="Limit Character: " name="jwext_news_limit_desc" value="<?php echo esc_html($jwext_news_limit_desc);?>">
                </div>
                <div class="form-group">
                    <label><?php echo __( 'Set limit of Post in category', 'news-ticker-anywhere' );?></label><br/>                    
                    <input type="text" data-role="input" data-prepend="Limit Post: " name="jwext_news_limit_post" value="<?php echo esc_html($jwext_news_limit_post);?>">
                </div>
             </div>  
        </div><!-- content -->
    </div><!-- end frame -->                               
        
    </div><!-- accordion -->

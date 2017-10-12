<?php
    if (IsSet($_POST["update_options"])) {
        foreach ($_POST as $key => $value) {
            if ($key != 'update_options') {
                update_option($key, esc_html($value));
            }
        }
    }
    $option      = array();
    $getArt      = array();
    $getCipher   = array();
    $getFeatures = array();

    for($i=0;$i<3;$i++){
        $option['notebook'][$i]         = get_option('notebook_'.($i+1));
        $option['pbpanel_notebook'][$i] = get_option('pbpanel_notebook_'.($i+1));
    }
    for($i=0;$i<6;$i++){
        $option['exclusive'][$i]         = get_option('exclusive_'.($i+1));
        $option['pbpanel_exclusive'][$i] = get_option('pbpanel_exclusive_'.($i+1));
    }
    for($i=0;$i<2;$i++){
        $option['features'][$i]         = get_option('features_'.($i+1));
        $option['pbpanel_features'][$i] = get_option('pbpanel_features_'.($i+1));
    }
    for($i=0;$i<2;$i++){
        $option['tech_cyber'][$i]         = get_option('tech_cyber_'.($i+1));
        $option['pbpanel_tech_cyber'][$i] = get_option('pbpanel_tech_cyber_'.($i+1));
    }
    for($i=0;$i<10;$i++){
        $option['flash_title'][$i]  = get_option('pbpanel_title_'.($i+1));
        $option['flash_author'][$i] = get_option('pbpanel_author_'.($i+1));
        $option['flash_link'][$i]   = get_option('pbpanel_link_'.($i+1));
    }

    if(!empty($option['notebook'])){
        $getArt = getOption(array_filter($option['pbpanel_notebook'], 'strlen'));
    }
    if(!empty($option['exclusive'])){
        $getCipher = getOption(array_filter($option['pbpanel_exclusive'], 'strlen'));
    }
    if(!empty($option['exclusive'])){
        $getFeatures = getOption(array_filter($option['pbpanel_features'], 'strlen'));
    }

    function getPre($temp){
        echo '<pre>';
        print_r($temp);
        echo '</pre>';
    }
    function getOption($option){
        global $wpdb;
        $temp   = array();
        $result = array();
        $results = $wpdb->get_results("SELECT 
										ID,
            							post_author,
										post_date,
										post_title
                                       FROM wp_posts 
                                       WHERE 
                                            post_title <> '' AND 
                                            post_status = 'publish' AND
                                            ID IN (".implode(',',array_values($option)).")");
        foreach ($results as $word) {
            $temp[$word -> post_author] = $word->ID;
            $result[$word->ID] = array(
                'id'       => $word->ID,
                'value'    => $word->post_title,
                'authorId' => $word->post_author,
            );
        }
        if(!empty($temp)){
            $results = $wpdb->get_results("SELECT ID,display_name FROM wp_users WHERE ID IN (".implode(',',array_keys($temp)).")");
            foreach ($results as $word){
                $temp[$word -> ID] = $word -> display_name;
            }
            foreach ($result as $k => $v){
                if(IsSet($temp[$v['authorId']])){
                    $result[$k]['author'] = $temp[$v['authorId']];
                }
            }
        }
        if(!empty($temp)){
            $results = $wpdb->get_results("SELECT post_parent,guid,post_type FROM wp_posts WHERE post_parent IN (".implode(',',array_keys($result)).")");
            foreach ($results as $word){
                $result[$word -> post_parent][$word -> post_type] = $word -> guid;
            }
        }
        return $result;
    }

    function getArticle($value){
        $img = '';
        $res = array();
        if(IsSet($value['attachment'])){
            $res = @getimagesize($value['attachment']);
        }
        $temp = '';
        $temp .= '<img src="'.(!IsSet($value['attachment']) || empty($res) ? '/wp-content/themes/thecipherbrief/pbpanel/images/no_photo.png' : $value['attachment']).'"/>';
        $temp .= '<p>'.(!IsSet($value['value']) ? 'No select' : $value['value']).'</p>';
        $temp .= '<span>'.(!IsSet($value['author']) ? 'No select' : $value['author']).'</span>';
        return $temp;
    }

    function getFleshHtml($option,$index,$number){
        ?>
        <div class="infoClear">
            <label for="pbpanel_flash_title_<?php echo $number?>"><?php echo 'Post ('.$number.')'; ?></label>
            <span class="helptext">Enter article title</span>
            <label for="pbpanel_flash_traffic_<?php echo $number?>" class="width100">
                <input type="text" value="<?php echo stripslashes(IsSet($option['flash_title']) && IsSet($option['flash_title'][$index]) ? $option['flash_title'][$index] : ''); ?>"  name="pbpanel_title_<?php echo $number?>" id="pbpanel_flash_title_<?php echo $number?>"/>
            </label>
            <span class="helptext">Enter article author</span>
            <label for="pbpanel_flash_author_<?php echo $number?>" class="width100">
                <input type="text" value="<?php echo stripslashes(IsSet($option['flash_author']) && IsSet($option['flash_author'][$index]) ? $option['flash_author'][$index] : ''); ?>"  name="pbpanel_author_<?php echo $number?>" id="pbpanel_flash_author_<?php echo $number?>"/>
            </label>
            <span class="helptext">Enter article link</span>
            <label for="pbpanel_flash_link_<?php echo $number?>" class="width100">
                <input type="text" value="<?php echo stripslashes(IsSet($option['flash_link']) && IsSet($option['flash_link'][$index]) ? $option['flash_link'][$index] : ''); ?>"  name="pbpanel_link_<?php echo $number?>" id="pbpanel_flash_link_<?php echo $number?>"/>
            </label>
        </div>
        <?php
    }
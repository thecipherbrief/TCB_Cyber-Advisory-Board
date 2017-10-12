<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
get_template_part('pbpanel/header');
include '../wp-content/themes/thecipherbrief/pbpanel/option.php';
//    echo getcwd();
?>
    <div class="pbpanel-column">
        <div class="pbpanel-box">
            <h2><?php echo 'Cipher exclusive'; ?></h2>
        </div>
        <div class="pbpanel-box">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="infoClear">
                    <label for="pbpanel_exclusive_1"><?php echo 'Post (1)'; ?></label>
                    <span class="helptext">Enter article title</span>
                    <label for="pbpanel_exclusive_1">
                        <input type="text" value="<?php echo $option['exclusive'][0]; ?>"  name="exclusive_1" id="pbpanel_exclusive_1" class="pbpanelAutocomplite"/>
                        <input type="hidden" value="<?php echo $option['pbpanel_exclusive'][0]; ?>" name="pbpanel_exclusive_1"/>
                    </label>
                    <div class="itemsInfo">
                        <?php echo getArticle(IsSet($getCipher[$option['pbpanel_exclusive'][0]]) ? $getCipher[$option['pbpanel_exclusive'][0]] : array());?>
                    </div>
                </div>
                <hr>
                <div class="infoClear">
                    <label for="pbpanel_exclusive_2"><?php echo 'Post (2)'; ?></label>
                    <span class="helptext">Enter article title</span>
                    <label for="pbpanel_exclusive_2">
                        <input type="text" value="<?php echo $option['exclusive'][1]; ?>"  name="exclusive_2" id="pbpanel_exclusive_2" class="pbpanelAutocomplite"/>
                        <input type="hidden" value="<?php echo $option['pbpanel_exclusive'][1]; ?>" name="pbpanel_exclusive_2"/>
                    </label>
                    <div class="itemsInfo">
                        <?php echo getArticle(IsSet($getCipher[$option['pbpanel_exclusive'][1]]) ? $getCipher[$option['pbpanel_exclusive'][1]] : array());?>
                    </div>
                </div>
                <hr>
                <div class="infoClear">
                    <label for="pbpanel_exclusive_3"><?php echo 'Post (3)'; ?></label>
                    <span class="helptext">Enter article title</span>
                    <label for="pbpanel_exclusive_3">
                        <input type="text" value="<?php echo $option['exclusive'][2]; ?>"  name="exclusive_3" id="pbpanel_exclusive_3" class="pbpanelAutocomplite"/>
                        <input type="hidden" value="<?php echo $option['pbpanel_exclusive'][2]; ?>" name="pbpanel_exclusive_3"/>
                    </label>
                    <div class="itemsInfo">
                        <?php echo getArticle(IsSet($getCipher[$option['pbpanel_exclusive'][2]]) ? $getCipher[$option['pbpanel_exclusive'][2]] : array());?>
                    </div>
                </div>
                <hr>
                <div class="infoClear">
                    <label for="pbpanel_exclusive_4"><?php echo 'Post (4)'; ?></label>
                    <span class="helptext">Enter article title</span>
                    <label for="pbpanel_exclusive_4">
                        <input type="text" value="<?php echo $option['exclusive'][3]; ?>"  name="exclusive_4" id="pbpanel_exclusive_4" class="pbpanelAutocomplite"/>
                        <input type="hidden" value="<?php echo $option['pbpanel_exclusive'][3]; ?>" name="pbpanel_exclusive_4"/>
                    </label>
                    <div class="itemsInfo">
                        <?php echo getArticle(IsSet($getCipher[$option['pbpanel_exclusive'][3]]) ? $getCipher[$option['pbpanel_exclusive'][3]] : array());?>
                    </div>
                </div>
                <hr>
                <div class="infoClear">
                    <label for="pbpanel_exclusive_5"><?php echo 'Post (5)'; ?></label>
                    <span class="helptext">Enter article title</span>
                    <label for="pbpanel_exclusive_5">
                        <input type="text" value="<?php echo $option['exclusive'][4]; ?>"  name="exclusive_5" id="pbpanel_exclusive_5" class="pbpanelAutocomplite"/>
                        <input type="hidden" value="<?php echo $option['pbpanel_exclusive'][4]; ?>" name="pbpanel_exclusive_5"/>
                    </label>
                    <div class="itemsInfo">
                        <?php echo getArticle(IsSet($getCipher[$option['pbpanel_exclusive'][4]]) ? $getCipher[$option['pbpanel_exclusive'][4]] : array());?>
                    </div>
                </div>
                <hr>
                <div class="infoClear">
                    <label for="pbpanel_exclusive_6"><?php echo 'Post (6)'; ?></label>
                    <span class="helptext">Enter article title</span>
                    <label for="pbpanel_exclusive_6">
                        <input type="text" value="<?php echo $option['exclusive'][5]; ?>"  name="exclusive_6" id="pbpanel_exclusive_6" class="pbpanelAutocomplite"/>
                        <input type="hidden" value="<?php echo $option['pbpanel_exclusive'][5]; ?>" name="pbpanel_exclusive_6"/>
                    </label>
                    <div class="itemsInfo">
                        <?php echo getArticle(IsSet($getCipher[$option['pbpanel_exclusive'][5]]) ? $getCipher[$option['pbpanel_exclusive'][5]] : array());?>
                    </div>
                </div>
                <p><input type="submit" name="update_options" value="<?php echo 'Save cipher exclusive'; ?>" class="pbpanel-button pbpanel-button-color-1"></p>
            </form>
        </div>
    </div>

<?php
get_template_part('pbpanel/footer');
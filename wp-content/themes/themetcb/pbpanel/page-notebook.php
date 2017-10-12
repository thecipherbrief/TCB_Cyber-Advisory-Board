<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    get_template_part('pbpanel/header');
    include '../wp-content/themes/thecipherbrief/pbpanel/option.php';
//    echo getcwd();
?>
<div class="pbpanel-column">
    <div class="pbpanel-box">
        <h2><?php echo 'Analyst notebook'; ?></h2>
    </div>
    <div class="pbpanel-box">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="infoClear">
            <label for="pbpanel_notebook_1"><?php echo 'Post (1)'; ?></label>
            <span class="helptext">Enter article title</span>
            <label for="pbpanel_notebook_1">
                <input type="text" value="<?php echo $option['notebook'][0]; ?>"  name="notebook_1" id="pbpanel_notebook_1" class="pbpanelAutocomplite"/>
                <input type="hidden" value="<?php echo $option['pbpanel_notebook'][0]; ?>" name="pbpanel_notebook_1"/>
            </label>
            <div class="itemsInfo">
                <?php echo getArticle($getArt[$option['pbpanel_notebook'][0]]);?>
            </div>
        </div>
        <hr>
        <div class="infoClear">
            <label for="pbpanel_notebook_1"><?php echo 'Post (2)'; ?></label>
            <span class="helptext">Enter article title</span>
            <label for="pbpanel_notebook_2">
                <input type="text" value="<?php echo $option['notebook'][1]; ?>"  name="notebook_2" id="pbpanel_notebook_2" class="pbpanelAutocomplite"/>
                <input type="hidden" value="<?php echo $option['pbpanel_notebook'][1]; ?>" name="pbpanel_notebook_2"/>
            </label>
            <div class="itemsInfo">
                <?php echo getArticle($getArt[$option['pbpanel_notebook'][1]]);?>
            </div>
        </div>
        <hr>
        <div class="infoClear">
            <label for="pbpanel_notebook_3"><?php echo 'Post (3)'; ?></label>
            <span class="helptext">Enter article title</span>
            <label for="pbpanel_notebook_3">
                <input type="text" value="<?php echo $option['notebook'][2]; ?>"  name="notebook_3" id="pbpanel_notebook_3" class="pbpanelAutocomplite"/>
                <input type="hidden" value="<?php echo $option['pbpanel_notebook'][2]; ?>" name="pbpanel_notebook_3"/>
            </label>
            <div class="itemsInfo">
                <?php echo getArticle($getArt[$option['pbpanel_notebook'][2]]);?>
            </div>
        </div>
        <p><input type="submit" name="update_options" value="<?php echo 'Save notebook'; ?>" class="pbpanel-button pbpanel-button-color-1"></p>
        </form>
    </div>
</div>

<?php
    get_template_part('pbpanel/footer');
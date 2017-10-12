<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
get_template_part('pbpanel/header');
include '../wp-content/themes/thecipherbrief/pbpanel/option.php';
//    echo getcwd();
?>
    <div class="pbpanel-column">
        <div class="pbpanel-box">
            <h2><?php echo 'Flash Traffic'; ?></h2>
        </div>
        <div class="pbpanel-box">
            <form action="" method="post" enctype="multipart/form-data">
                <?php getFleshHtml($option,0,1)?>
                <hr>
                <?php getFleshHtml($option,1,2)?>
                <hr>
                <?php getFleshHtml($option,2,3)?>
                <hr>
                <?php getFleshHtml($option,3,4)?>
                <hr>
                <?php getFleshHtml($option,4,5)?>
                <hr>
                <?php getFleshHtml($option,5,6)?>
                <hr>
                <?php getFleshHtml($option,6,7)?>
                <hr>
                <?php getFleshHtml($option,7,8)?>
                <hr>
                <?php getFleshHtml($option,8,9)?>
                <hr>
                <?php getFleshHtml($option,9,10)?>
                <p><input type="submit" name="update_options" value="<?php echo 'Save flash traffic'; ?>" class="pbpanel-button pbpanel-button-color-1"></p>
            </form>
        </div>
    </div>

<?php
get_template_part('pbpanel/footer');
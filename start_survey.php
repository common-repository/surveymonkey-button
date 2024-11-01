<?php
header("content-type: application/javascript");
?>

<?php
    error_reporting(E_ALL);

    function checkParamExist($paramName="", $paramKey="") {
        if ((isset($_GET[$paramKey])) && ($_GET[$paramKey]!="")) {
            return '\''.$paramName.'\': '.'\''.$_GET[$paramKey].'\',';
        } else {
            return "";
        }
    }
?>

<?php
if (!isset($_GET['state']) || $_GET['state']=="on" || $_GET['state']=='') {
?>
    FloatingButtonFunc();
<?php
};

$source = 1; //local settings
if (!isset($_GET['source']) || $_GET['source']=="probtn.com" || $_GET['source']=='') {
} else {
    $source = 1;
};
?>

function runYourFunctionWhenJQueryIsLoaded() {
    if (window.$){
        FloatingButtonFunc();
    } else {
        setTimeout(runYourFunctionWhenJQueryIsLoaded, 50);
    }
}

function FloatingButtonFunc() {    
    jQuery(document).ready(function() {
        setTimeout(InitButton, 2500);
    });
}

function InitButton() {
    jQuery(document).StartButton({
		    "mainStyleCss": "<?php echo str_replace("http:/", "http://",$_GET["mainStyleCss"]); ?>",
            "fancyboxCssPath": "<?php echo str_replace("http:/", "http://",$_GET["fancyboxCss"]); ?>",
            <?php
            if ($source==1) {
            ?>
                "jqueryPepPath": "<?php echo $_GET["jqueryPepPath"]; ?>",
                <?php echo checkParamExist("ButtonImage","probtn_image") ?>
                <?php echo checkParamExist("ButtonDragImage","probtn_image") ?>
                <?php echo checkParamExist("ButtonOpenImage","probtn_image") ?>
                <?php echo checkParamExist("ButtonInactiveImage","probtn_image") ?>
                'domain': 'wordpress.plugin',
                <?php echo checkParamExist("ContentURL","probtn_contenturl") ?>
                <?php echo checkParamExist("HintText","probtn_hinttext") ?>
            <?php
            } else {
            ?>
                "jqueryPepPath": "<?php echo $_GET["jqueryPepPath"]; ?>"
            <?php
            }
            ?>
	    });
}

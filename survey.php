<?php
/**
 * Plugin Name: Surveymonkey Button
 * Plugin URI: http://probtn.com
 * Description: Surveymonkey Button is the easiest way to add a Surveymonkey survey on your Wordpress blog. The survey is located inside a pop-up window that opens by clicking on the floating button. Using Surveymonkey Button, you can find out the opinions of users of your site and collect useful information
 * Version: 1.1
 * Author: hintsolutions
 * Author URI: http://probtn.com
 * License: -
 */

 /**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'survey_add_my_stylesheet' );

add_filter( 'wp_nav_menu_objects', 'survey_wp_nav_menu_objects' );
/*
We need to find current menu item and
*/
function survey_wp_nav_menu_objects( $sorted_menu_items )
{
		foreach ( $sorted_menu_items as $menu_item ) {
			if ( $menu_item->current ) {
                    $menu_options = get_option( 'survey_menu_settings' );
                    $options = get_option( 'survey_settings' );
				    if ((isset($options['menu_show'])) && ($options['menu_show']=='on')) {
					    foreach ($menu_options as $key=>$val) {
						    if (($val==$menu_item->ID) || ($val=="on")) {
							    survey_start_button_script();
							    break;
						    };
					    }
                    }
                    //else {
                        //survey_start_button_script();
                    //};
				break;
			};
		};
    return $sorted_menu_items;
}

/**
 * Enqueue plugin style-file
 */
function survey_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'survey-style', plugins_url('style.css', __FILE__));
    wp_enqueue_style( 'survey-style' );

    wp_register_script( 'jquerypep-script', plugins_url('jquery.pep.min.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script( 'jquerypep-script' );

    wp_register_script( 'fancybox-script', plugins_url('fancybox/jquery.fancybox-1.3.4.pack.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script( 'fancybox-script' );

    $mainStyleCss = plugins_url('style.css');
    $jqueryPepPath = plugins_url('jquery.form.min.js');
    //parse_url('https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
    
    //$jqueryPepPath = parse_url("https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js");

    //wp_register_script( 'survey-script', 'https://pizzabtn.herokuapp.com/javascripts/probtn.js', array( 'jquery', 'jquerypep-script' ));
    wp_register_script( 'survey-script', plugins_url('probtn.js', __FILE__), array( 'jquery', 'jquerypep-script', 'fancybox-script'));
    wp_enqueue_script( 'survey-script' );

    $options = get_option( 'survey_settings' ); 
	if ((isset($options['menu_show'])) && ($options['menu_show']=='on')) {
	} else {
		survey_start_button_script();
	};
}


function surveyinit_function() {
    $options = get_option( 'probtn_settings' );
    if (($options['state']==null) || ($options['state']=='')) {
        $options['state'] = 'on';
    };
    if (($options['probtn_image']==null) || ($options['probtn_image']=='')) {
        $options['probtn_image'] = 'http://admin.probtn.com/eqwid_btn_nonpress.png';
    };
                if (($options['probtn_contenturl']==null) || ($options['probtn_contenturl']=='')) {
                    $options['probtn_contenturl'] = 'https://www.surveymonkey.com/s/YQG8C2J';
                };
                if (($options['probtn_hinttext']==null) || ($options['probtn_hinttext']=='')) {
                    $options['probtn_hinttext'] = 'Survey';
                };

    //$mainStyleCss = plugins_url('style.css');
    //$jqueryPepPath = plugins_url('jquery.form.min.js');
    $mainStyleCss = plugins_url('surveymonkey-button/style.css');
    $jqueryPepPath = plugins_url('surveymonkey-button/jquery.form.min.js');
    $fancyboxCss = plugins_url('surveymonkey-button/fancybox/jquery.fancybox-1.3.4.css');

    if ($options['state']=="off") {
$output = '
<script>
FloatingButtonFunc();

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
		    "mainStyleCss": "'.$mainStyleCss.'",
            "fancyboxCssPath": "'.$fancyboxCss.'",
            ';
                $output = $output. '
                "jqueryPepPath": "'.$jqueryPepPath.'",
                "ButtonImage": "'.$options['probtn_image'].'",
                "ButtonDragImage": "'.$options['probtn_image'].'",
                "ButtonOpenImage": "'.$options['probtn_image'].'",
                "ButtonInactiveImage": "'.$options['probtn_image'].'",
                "domain": "wordpress.plugin",
                "ContentURL": "'.$options['probtn_contenturl'].'",
                "HintText": "'.$options['probtn_hinttext'].'"
                ';
             $output = $output. '}); } </script>';
            return $output;
	    } else {
	        return "";
	    }
}

add_shortcode('surveymonkey_button', 'surveyinit_function');


function survey_start_button_script() {
    $mainStyleCss = plugins_url('surveymonkey-button/style.css');
    $jqueryPepPath = plugins_url('surveymonkey-button/jquery.form.min.js');
    $fancyboxCss = plugins_url('surveymonkey-button/fancybox/jquery.fancybox-1.3.4.css');

    $options = get_option( 'survey_settings' );

                if (($options['source']==null) || ($options['source']=='')) {
                    $options['source'] = 'local settings';
                };
                if (($options['state']==null) || ($options['state']=='')) {
                    $options['state'] = 'on';
                };
                if (($options['probtn_contenturl']==null) || ($options['probtn_contenturl']=='')) {
                    $options['probtn_contenturl'] = 'https://www.surveymonkey.com/s/YQG8C2J';
                };
                if (($options['probtn_hinttext']==null) || ($options['probtn_hinttext']=='')) {
                    $options['probtn_hinttext'] = 'Survey';
                };

    function urlify($key, $val) {
        return urlencode($key) . '=' . urlencode($val);
    }
    $url = '';
    $url .= implode('&amp;', array_map('urlify', array_keys($options), $options));
    wp_register_script( 'survey-start-script', plugins_url("start_survey.php?mainStyleCss=".$mainStyleCss."&jqueryPepPath=".$jqueryPepPath."&fancyboxCss=".$fancyboxCss."&".$url, __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'survey-start-script' );
}

add_action('admin_init', 'survey_register_settings');

function survey_register_settings(){
    //this will save the option in the wp_options table as 'wpse61431_settings'
    //the third parameter is a function that will validate your input values
    register_setting('survey_settings', 'survey_settings', 'survey_settings_validate');
}

function survey_settings_validate($args){
    return $args;
}

add_action('admin_init', 'survey_register_menu_settings');
function survey_register_menu_settings(){
    register_setting('survey_menu_settings', 'survey_menu_settings', 'probtn_menu_settings_validate');
}
function survey_menu_settings_validate($args){
    return $args;
}

/** Step 2 (from text above). */
add_action( 'admin_menu', 'survey_menu' );

/** Step 1. */
function survey_menu() {
    add_menu_page( 'Surveymonkey Button', 'Surveymonkey Button', 'manage_options', 'survey_button_page',
    'survey_options', plugins_url( 'surveymonkey-button/images/profit_button_icon_3_1.png' ), 171 );
}

add_action('admin_notices', 'survey_admin_notices');
function survey_admin_notices(){
   settings_errors();
}



/** Step 3. */
function survey_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>

<script src="<?php echo plugins_url('/surveymonkey-button/jquery.form.min.js'); ?>"></script>

<style>
    #wpfooter {
        display: none;
    }

    .mp6-sg-example {
    padding: 1em;
    margin: 10px 0 20px;
    background: white;

    -webkit-box-shadow: 0px 1px 1px 0px rgba(0,0,0,0.1);
    box-shadow: 0px 1px 1px 0px rgba(0,0,0,0.1);
}

.mp6-sg-example h3 {
    margin-top: 0;
}

.mp6-table {
    width: 100%;
}

.mp6-table th, .mp6-table td {
    border-bottom: 1px solid #eee;
}

.mp6-table .sg-example-code {
    width: 25%;
}
.mp6-table .sg-example-descrip {
    width: 75%;
}

.mp6-table td span {
    display: block;
    padding: 5px 10px;
}

/*jQuery UI demo page css*/
.demoHeaders {
    margin-top: 2em;
    clear: both;
}
#dialog_link {
    padding: .4em 1em .4em 20px;
    text-decoration: none;
    position: relative;
}
#dialog_link span.ui-icon {
    margin: 0 5px 0 0;
    position: absolute;
    left: .2em;
    top: 50%;
    margin-top: -8px;
}
ul#icons {
    margin: 0;
    padding: 0
}
ul#icons li {
    margin: 2px;
    position: relative;
    padding: 4px 0;
    cursor: pointer;
    float: left;
    list-style: none;
}
ul#icons span.ui-icon {
    float: left;
    margin: 0 4px
}
.columnbox {
    height: 150px;
    width: 48%;
    float:left;
    margin-right: 1%;
}
#eq span {
    height:120px;
    float:left;
    margin:15px;
 }
.buttonset {
    margin-bottom: 5px;
}
#toolbar {
    padding: 10px 4px;
}
.ui-widget-overlay {
    position: absolute;
} /* fixed doesn't actually work? */
</style>

<div class="wrap">
    <div style="clear: both; width: 95%; display: inline-block;
    height: 110px;">
        <img alt="logo" style="width: 100px; height: auto; display: inline-block; float: left;"
            src="<?php echo plugins_url('/surveymonkey-button/images/probtnlogo-2.png'); ?>"/>
        <h1 style="line-height: 70px; margin-left: 20px; display: inline-block;width: auto;">Surveymonkey Button</h1>
    </div>

    <div class="mp6-sg-example">
        <h3>About</h3>
        <p>
        Surveymonkey Button is the easiest way to add a Surveymonkey survey on your Wordpress blog. The survey is located inside a pop-up window that opens by clicking on the floating button. Using Surveymonkey Button, you can find out the opinions of users of your site and collect useful information</p>
        <p>This product is not affiliated with Surveymonkey</p>
    </div>

    <!-- START SETTINGS MENU -->
    <div class="mp6-sg-example">
        <h3>Settings</h3>
        <div id="options">
            <form action="options.php" method="post">
            <?php
                settings_fields( 'survey_settings' );
                do_settings_sections( __FILE__ );

                //get the older values, wont work the first time
                $options = get_option( 'survey_settings' );
                if (($options['source']==null) || ($options['source']=='')) {
                    $options['source'] = 'local settings';
                };
                if (($options['state']==null) || ($options['state']=='')) {
                    $options['state'] = 'on';
                };
                if (($options['probtn_contenturl']==null) || ($options['probtn_contenturl']=='')) {
                    $options['probtn_contenturl'] = 'https://www.surveymonkey.com/s/YQG8C2J';
                };
                if (($options['probtn_hinttext']==null) || ($options['probtn_hinttext']=='')) {
                    $options['probtn_hinttext'] = 'Survey';
                };
                
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Button state</th>
                        <td>
                            <fieldset>
                                <label>
                                    <input type="radio" name="survey_settings[state]" class=""
                                        value="on"<?php checked( 'on' == $options['state'] ); ?> />
                                    <span class="localSettings_item description">On</span>
                                </label>
                                <br/>
                                <label>
                                    <input type="radio" name="survey_settings[state]" class=""
                                        value="off"<?php checked( 'off' == $options['state'] ); ?> />
                                    <span class="description probtnSettings_item">Off</span>
                                </label>
                            </fieldset>
                        </td>
                    </tr>


                    <tr class="localSettings">
                        <th scope="row">Survey URL</th>
                        <td>
                            <fieldset>
                                <label>
                                    <input name="survey_settings[probtn_contenturl]" type="text" id="probtn_contenturl"
                                    value="<?php echo (isset($options['probtn_contenturl']) && $options['probtn_contenturl'] != '') ? $options['probtn_contenturl'] : ''; ?>"/>
                                    <br />
                                    <span class="description">Please enter content url.</span>
                                </label>
                            </fieldset>
                        </td>
                    </tr>

                    <tr class="localSettings">
                        <th scope="row">Hint Text</th>
                        <td>
                            <fieldset>
                                <label>
                                    <input name="survey_settings[probtn_hinttext]" type="text" id="probtn_hinttext"
                                    value="<?php echo (isset($options['probtn_hinttext']) && $options['probtn_hinttext'] != '') ? $options['probtn_hinttext'] : ''; ?>"/>
                                    <br />
                                    <span class="description">Please enter button hint text.</span>
                                </label>
                            </fieldset>
                        </td>
                    </tr>

                </table>
                <input type="submit" value="Save settings" class="button-primary" />
            </form>
        </div>
    </div>
    <!-- END SETTINGS MENU -->

    <!-- START LAUNCH DEMO BUTTON -->
    <script src='<?php echo plugins_url('/surveymonkey-button/jquery.pep.min.js'); ?>'></script>
    <script src='<?php echo plugins_url('/surveymonkey-button/fancybox/jquery.fancybox-1.3.4.pack.js'); ?>'></script>
    <script src='<?php echo plugins_url('/surveymonkey-button/probtn.js'); ?>'></script>
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('/surveymonkey-button/style.css'); ?>" />

    <script>
        jQuery(document).ready(
        function ($) {
            $(".probtnSettings_item").click(function () {
                $(".localSettings").hide(200);
                $("#probtnSettings").show(200);
            });
            $(".localSettings_item").click(function () {
                $(".localSettings").show(200);
                $("#probtnSettings").hide(200);
            });
            $(document).StartButton({
                'domain': 'example.com',
                'fancyboxCssPath':'<?php echo plugins_url('fancybox/jquery.fancybox-1.3.4.css', __FILE__); ?>',
                'mainStyleCss':'<?php echo plugins_url('/surveymonkey-button/style.css'); ?>',
                'ContentURL': 'https://www.surveymonkey.com/s/YQG8C2J'
            });
        });
    </script>
    <!-- END LAUNCH DEMO BUTTON -->
        
        
        <!--START SELECT MENU ITEMS -->
        <h3 style="cursor: pointer;" id="">Menu assignment <small>&#9660;</small></h3>
        <p>You can select menu items, where button would be shown\hidden, or by default it would be shown at all pages.</p>

       <form method="post" action="options.php">
            <?php
                settings_fields( 'survey_settings' );
                do_settings_sections( __FILE__ );
                //get the older values, wont work the first time
                $options = get_option( 'survey_settings' );
                //print_r($menu_options);
            ?> 
           <input type="checkbox" name="survey_settings[menu_show]" value="on" <?php checked( 'on' == $options["menu_show"]); ?> />
                <span>Show button only at selected menu pages</span><br/>
           <br/>
           <input type="submit" value="Save" class="button-primary"/>
           </form>

        <?php
        // Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
        // This code based on wp_nav_menu's code to get Menu ID from menu slug

        $menu_name = 'custom_menu_slug';
        $locations = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        //print_r($locations);        

        foreach ($locations as $menu) {
            ?>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'survey_menu_settings' );
                do_settings_sections( __FILE__ );
                //get the older values, wont work the first time
                $menu_options = get_option( 'survey_menu_settings' );
                //print_r($menu_options);
            ?>            
            <h4><?php echo $menu->name; ?></h4>
                <input type="checkbox" name="survey_menu_settings[<?php echo $menu->slug; ?>_all]" value="on" <?php checked( 'on' == $menu_options[$menu->slug."_all"]); ?> />
                <span>All items</span><br/>
            <?php                
            $items = wp_get_nav_menu_items($menu->slug);  
            //print_r($items);
            foreach ($items as $item) {
                ?>
                <input type="checkbox" name=survey_menu_settings[<?php echo $menu->slug; ?>_<?php echo $item->ID; ?>]" value="<?php echo $item->ID; ?>" <?php checked( $item->ID == $menu_options[$menu->slug."_".$item->ID]); ?>/>
                <span><?php echo $item->title; ?></span><br/>
                <?php
            }
            ?>
                <br/>
                <input type="submit" value="Save" class="button-primary"/>
            </form>
            <?php 
        }       
        ?>
        
        <!--END SELECT MENU -->

    </div>
    <!-- END PROBTN SETTINGS -->
<?php
}
?>

<?php

defined( 'ABSPATH' ) OR exit;

add_action('admin_menu', 'scu_create_theme_options_page');
add_action('admin_init', 'scu_register_and_build_fields');
add_action('admin_enqueue_scripts', 'us_script');

function us_script() {
  wp_enqueue_style( 'us_style_css', plugins_url('/assets/us-admin.css', __FILE__), array(), null, 'all' );

  wp_enqueue_script( 'us_script_js', plugins_url('/assets/uikit.js', __FILE__), array('jquery'), '20120206', true );
}

function scu_register_and_build_fields() {
  register_setting('tonjoo_uncache_script', 'tonjoo_uncache_script_version');
}

function scu_create_theme_options_page() {
  add_options_page('Uncache Script', 'Uncache Script', 'administrator', __FILE__, 'options_page_fn');
}

function options_page_fn() {
?>

        <div class="us-option-wrapper">
         <div id="us-theme-options-wrap" class="widefat-us">
            <div class="icon32" id="icon-tools"></div>

            <h1><b>Uncache Script</b></h1>
            <p>Just hit the "Uncache Script" button to force your scripts and style to uncache !</p>
            <p><b>*Important : If you use W3Total Cache script/style cache you should disable this plugin </b></p>

            <form id="updateUncache" method="post" action="options.php" enctype="multipart/form-data">

               <?php

                  settings_fields('tonjoo_uncache_script');

                  do_settings_sections( 'tonjoo_uncache_script' );

                  $version = get_option('tonjoo_uncache_script_version');

                  if(!$version)
                  {

                     $version = 1;
                     $nextVersion = 1;

                  }
                  else
                     $nextVersion = $version +1 ;

               ?>

               <p>Current Version : <?php echo $version ?> </p>

               <input type='hidden' name='tonjoo_uncache_script_version' value="<?php echo $nextVersion ?>">



               <p class="submit">
                  <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Uncache Script'); ?>" />
               </p>
               <?php

              // if(isset($_GET['act']) && $_GET['act'] == 'update' && !isset($_POST['tonjoo_uncache_script_version'])) { ?>

               <script type="text/javascript">
                  // jQuery(function() {
                  //    jQuery(".submit input").click();
                  // });
               </script>



               <?php

           // } ?>
         </form>
        </div>
      </div>
      <div class="ads-box-wrapper">
        <div class="us-postbox-container">
          <div class="metabox-holder" style="padding-top:0px;">
            <div class="meta-box-sortables ui-sortable">

              <!-- ADS -->
                <div class="us-postbox">
                <script type="text/javascript">
                  /**
                   * Setiap dicopy-paste, yang find dan dirubah adalah
                   * - var pluginName
                   * - premium_exist
                   */

                  jQuery(function(){
                    var pluginName = "frs";
                    var url = 'https://tonjoostudio.com/jsonp/?promo=get&plugin=' + pluginName;
                    var promoFirst = new Array();
                    var promoSecond = new Array();

                    <?php if(function_exists('is_frs_premium_exist')): ?>
                    var url = 'https://tonjoostudio.com/jsonp/?promo=get&plugin=' + pluginName + '&premium=true';
                    <?php endif ?>

                    // strpos function
                    function strpos(haystack, needle, offset) {
                      var i = (haystack + '')
                        .indexOf(needle, (offset || 0));
                      return i === -1 ? false : i;
                    }

                    jQuery.ajax({url: url, dataType:'jsonp'}).done(function(data){

                      if(typeof data =='object')
                      {
                        var fristImg, fristUrl;

                          // looping jsonp object
                        jQuery.each(data, function(index, value){

                          <?php if(! function_exists('is_frs_premium_exist')): ?>

                          fristImg = pluginName + '-premium-img';
                          fristUrl = pluginName + '-premium-url';

                          // promoFirst
                          if(index == fristImg)
                            {
                              promoFirst['img'] = value;
                            }

                            if(index == fristUrl)
                            {
                              promoFirst['url'] = value;
                            }

                            <?php else: ?>

                            if(! fristImg)
                            {
                              // promoFirst
                            if(strpos(index, "-img"))
                              {
                                promoFirst['img'] = value;

                                fristImg = index;
                              }

                              if(strpos(index, "-url"))
                              {
                                promoFirst['url'] = value;

                                fristUrl = index;
                              }
                            }

                            <?php endif; ?>

                          // promoSecond
                          if(strpos(index, "-img") && index != fristImg)
                            {
                              promoSecond['img'] = value;
                            }

                            if(strpos(index, "-url") && index != fristUrl)
                            {
                              promoSecond['url'] = value;
                            }
                        });

                        //promo_1
                        jQuery("#promo_1 img").attr("src",promoFirst['img']);
                        jQuery("#promo_1 a").attr("href",promoFirst['url']);

                        //promo_2
                        jQuery("#promo_2 img").attr("src",promoSecond['img']);
                        jQuery("#promo_2 a").attr("href",promoSecond['url']);
                      }
                    });
                  });
                </script>

                <!-- <h3 class="hndle"><span>This may interest you</span></h3> -->
                <div class="inside" style="margin: 23px 10px 6px 10px;">
                  <div id="promo_1" style="text-align: center;padding-bottom:17px;">
                    <a href="https://tonjoostudio.com" target="_blank">
                      <img src="<?php echo plugins_url(FRS_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" <?php if(! function_exists('is_frs_premium_exist')): ?> data-step="8" data-intro="If you like this slider, please consider the premium version to support us and get all the skins.<b>Fluid Responsive Slideshow</b> !" <?php endif ?>>
                    </a>
                  </div>
                  <div id="promo_2" style="text-align: center;">
                    <a href="https://tonjoostudio.com" target="_blank">
                      <img src="<?php echo plugins_url(FRS_DIR_NAME."/assets/loading-big.gif") ?>" width="100%">
                    </a>
                  </div>
                </div>
               </div>
             </div>
           </div>
         </div>
       </div>







<?php
}

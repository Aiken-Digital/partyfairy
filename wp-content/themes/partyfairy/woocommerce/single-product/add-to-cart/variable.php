<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$link =  do_shortcode('[wcfm_store_info id="" data="store_url"]');
preg_match_all('/<a[^>]+href=([""])(?<href>.+?)\1[^>]*>/i', $link, $result_url_vendor);  

$src =  do_shortcode('[wcfm_store_info id="" data="store_gravatar"]');
preg_match_all('/<img[^>]+src=([""])(?<src>.+?)\1[^>]*>/i', $src, $result_src_vendor);

$name = do_shortcode('[wcfm_store_info id="" data="store_name"]');
preg_match_all('|<div[^>]*>(?<name>[^<]+)<|', $name, $result_name_vendor);


$store_address = do_shortcode('[wcfm_store_info id="" data="store_address"]');
$store_phone = do_shortcode('[wcfm_store_info id="" data="store_phone"]');
$store_email = do_shortcode('[wcfm_store_info id="" data="store_email"]');


$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
  <div class="row">
   <?php do_action( 'woocommerce_before_variations_form' ); ?>




   <div class="col-lg-8">
    <div class="row">
      <div class="col-lg-4">
        <div class="productimg"><img class="img-fluid" src="<?php if ( has_post_thumbnail() ) {the_post_thumbnail_url('full'); } else { echo get_template_directory_uri().'/images/broken/img-not-available-landscape.png'; } ?>">
          <div class="productimg--des">Images shown on this page may differ slightly from the actual product.</div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="pf-product">
          <div class="pf-product--name"><?php the_title() ?></div>
          <div class="pf-product--sku"><?php party_show_sku() ?></div><a class="pf-product--seller" href="<?php if (!empty($result_url_vendor)) { echo $result_url_vendor['href'][0]; } ?>">
            <div class="pf-product--seller--img"><img class="img-fluid" src="<?php if (!empty($result_src_vendor)) { echo $result_src_vendor['src'][0]; } ?>"></div>
            <div class="pf-product--seller--name"><?php if (!empty($result_name_vendor)) { echo $result_name_vendor['name'][0]; } ?></div></a>
            <?php the_content() ?>


            <?php  $detail = get_field('detail', get_option('page_for_posts')); 
            $policies = get_field('policies', get_option('page_for_posts')); ?>


            <div class="pf-product--btm">

              <ul class="nav nav-pills m-b-30" id="pills-tab" role="tablist">

                <?php if($detail or $policies != ""){ ?>
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Select Options</a>
                  </li>

                <?php } if($detail) { ?>

                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Details</a>
                  </li>

                <?php } if($policies){ ?>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Policies</a>
                  </li>

                <?php } ?>
              </ul>

              <div class="tab-content m-b-15">


                <div class="tab-pane fade show active " id="tab-1" role="tabpanel" aria-labelledby="tab-1-tab">


                 <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
                  <p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
                  <?php else : ?>
                    <div class="variations">

                      <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                        <div class="row m-b-30">
                          <div class="col-4">
                            <p class="uppercase"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?><span class="asterisk">*</span></p>
                          </div>					 	
                          <div class="col-8">
                            <div class="form-group">

                             <?php
                             wc_dropdown_variation_attribute_options( array(
                               'options'   => $options,
                               'attribute' => $attribute_name,
                               'product'   => $product,
                               'class'		=> 'form-control hidden-validate',
                             ) );

                             ?>

                           </div>

                         </div>
                       </div>
                     <?php endforeach; ?>



                   </div>




                   <div class="row m-b-30">
                    <div class="col-4">
                      <p class="uppercase m-b-5">personalise this!</p>
                      <p>30 characters</p>
                    </div>
                    <div class="col-8">
                      <div class="form-group">
                        <input class="form-control" type="text" name="personalise-text" value="-">
                      </div>
                    </div>
                  </div>

                  <div  class="row m-b-30">
                   <div class="col-12">
                     <center>
                      <?php echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : ''; ?>	
                    </center>
                  </div>
                </div>


              </div>


              <?php 
              if($detail) {  ?>

                <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2-tab">

                  <?php foreach ($detail as $key => $value) { ?>

                    <div class="row m-b-15">
                      <div class="col-4">
                        <div>
                          <p class="uppercase"><?php if($value['title']) { echo $value['title']; } ?></p>
                        </div>
                      </div>
                      <div class="col-8">
                        <div>

                          <div class="d-flex align-items-center">
                            <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                              <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
                            </svg>
                          </div>
                          <?php if($value['description']) { echo $value['description']; } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>

              </div>

            <?php } ?>





            <?php 
            if($policies) {  ?>

              <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab-3-tab">

                <?php foreach ($policies as $key => $value) { ?>

                  <div class="row m-b-15">
                    <div class="col-4">

                      <div class="d-flex align-items-center">
                        <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                          <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
                        </svg>
                      </div>
                      <p class="uppercase m-b-0"><?php if($value['title']) { echo $value['title']; } ?></p>
                    </div>


                  </div>
                  <div class="col-8">
                    <div>


                      <?php if($value['description']) { echo $value['description']; } ?>

                    </div>
                  </div>
                </div>
              <?php } ?>
              
            </div>

          <?php } ?>








        </div>
      </div>
    </div>
  </div>
</div>
</div>







<?php do_action( 'woocommerce_before_single_variation' ); ?>



<div class="col-lg-4 m-b-25">

 <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>


 <div class="product-info product-info-main-form">
  <div class="product-info--price m-b-15"><span class="m-r-5"><?php echo $product->get_price_html(); ?></span><span class="font-12">each</span></div>
  <div id="product-cp"><?php do_action( 'woocommerce_single_variation' );?></div>




  <div class="product-info--quantity m-b-20">
    <p class="font-12">SELECT QUANTITY</p>
    <div class="incrementers">

      <style type="text/css">

       input[name="quantity"] {
        height: 50px;
        border-radius: 0px;
        font-size: 12px;
      }
    </style>

    <input class="-minus btn" id="sub" value="-" type="button">
    <div class="form-group m-b-0 w-100">
     <?php
     do_action( 'woocommerce_before_add_to_cart_quantity' );

     woocommerce_quantity_input( array(
      'input_id'     => uniqid( 'qty_' ),
      'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array('form-control', 'text-center','valid'  ), $product ),
      'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
      'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
	) );

     do_action( 'woocommerce_after_add_to_cart_quantity' );
     ?>
   </div>
   <input class="-plus btn" id="add" value="+" type="button">


 </div>
</div>
<?php 
$delive_product = get_field('delivery_product', get_option('page_for_posts'));
$pickup_product = get_field('pickup_product', get_option('page_for_posts'));
$delivery_estimate = get_field('delivery_estimate', get_option('page_for_posts'));
$estimate_time = get_field('estimate_time', get_option('page_for_posts'));
?>

<div class="product-info--opt-delivery">
  <p class="font-12 m-b-30">CHOOSE DELIVERY OPTIONS</p>
  <div class="-jquery-tabs delivery-option">
    <ul>


      <?php if( $delivery_estimate == "Y") { ?>
        <li><a class="-homedly btn-opt btn-homedelivery text-center w-100 font-12 d-flex justify-content-center align-items-center" href="#estimateDelivery">
          <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
            <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
          </svg>
        </div>Estimate Home Delivery</a></li>

      <?php } if( $delive_product == "Y") { ?>
        <li><a class="-homedly btn-opt btn-homedelivery text-center w-100 font-12 d-flex justify-content-center align-items-center" href="#homeDelivery">
          <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
            <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
          </svg>
        </div>Home Delivery</a></li>

      <?php } if($pickup_product == "Y") { ?>

        <li><a class="-pickdly btn-opt pickup text-center w-100 font-12 d-flex justify-content-center align-items-center" href="#pickUp">
          <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
            <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
          </svg>
        </div>Pick-up from store</a></li>

      <?php } ?>

    </ul>

    <?php if( $delivery_estimate == "Y") { ?>
      <div class="home-delivery-box" id="estimateDelivery">

        <div class="form-group">

          <?php $dv = get_term_by( 'id', $estimate_time, 'delivery-estimate' ); ?>
          Delivery will be take place in <?php echo $dv->name; ?>
        </div>
      </div>
    <?php }  if( $delive_product == "Y") { ?>
      <div class="home-delivery-box" id="homeDelivery">
        <div class="calendar-ui">
          <p class="text-center font-12 p-t-10 m-b-10">Choose Date & Time</p>
          <input id="calendarValuedelivery" type="hidden" value="" name="date-delivery" required="">
          <input id="timerValuedelivery" type="hidden" value="" name="time-delivery" required="">
          <div type="text" id="datepickerdelivery"></div>
        </div>
        <div class="form-group m-t-15 timercontrol d-flex align-items-center">
          <select class="form-control timerselect" onchange="myFunction(event)">
            <option>9.00 am to 10:00 am</option>
            <option>10.00 am to 11:00 am</option>
            <option>11.00 am to 12:00 pm</option>
            <option>12.00 pm to 1:00 pm</option>
            <option>1.00 pm to 2:00 pm</option>
            <option>2.00 pm to 3:00 pm</option>
            <option>3.00 pm to 4:00 pm</option>
            <option>4.00 pm to 5:00 pm</option>
            <option>5.00 pm to 6:00 pm</option>
            <option>6.00 pm to 7:00 pm</option>
          </select>
        </div>
      </div>
    <?php } if($pickup_product == "Y") { ?>

      <div class="home-delivery-box" id="pickUp">

        <div class="calendar-ui">
          <p class="text-center font-12 p-t-10 m-b-10">Choose Date & Time</p>
          <input id="calendarValuepickup" type="hidden" value="" name="date-pickup" required="">
          <input id="timerValuepickup" type="hidden" value="" name="time-pickup" required="">
          <div type="text" id="datepickerpickup"></div>
        </div>
        <div class="form-group m-t-15 timercontrol d-flex align-items-center">
          <select class="form-control timerselect" onchange="myFunctionpickup(event)">
            <option>9.00 am to 10:00 am</option>
            <option>10.00 am to 11:00 am</option>
            <option>11.00 am to 12:00 pm</option>
            <option>12.00 pm to 1:00 pm</option>
            <option>1.00 pm to 2:00 pm</option>
            <option>2.00 pm to 3:00 pm</option>
            <option>3.00 pm to 4:00 pm</option>
            <option>4.00 pm to 5:00 pm</option>
            <option>5.00 pm to 6:00 pm</option>
            <option>6.00 pm to 7:00 pm</option>
          </select>
        </div>

        <div class="form-group">

          <p class="text-center font-12 p-t-10 m-b-10">Store Info</p>
          <?php echo $name ?>
          <?php echo $store_address ?>
          <?php echo $store_phone ?>
          <?php echo $store_email ?>


        </div>


      </div>

    <?php } ?>

  </div>
</div>
<div class="action d-flex align-items-center">

  <button type="submit" class="btn btn-main btn-solid w-100 p-t-15 p-b-15 tocart" title="Add to Cart"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

  <?php echo do_shortcode("[yith_wcwl_add_to_wishlist]") ?>

<!-- 
                    <a class="icon icon-md m-l-20" href="#"><xml version="1.0" encoding="UTF-8">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1" fill="#60bcf0"><g id="surface1" fill="#60bcf0"><path style=" stroke:none;fill-rule:nonzero;fill-opacity:1" d="M 15 7 C 7.832031 7 2 12.832031 2 20 C 2 34.761719 18.695313 42.046875 24.375 46.78125 L 25 47.3125 L 25.625 46.78125 C 31.304688 42.046875 48 34.761719 48 20 C 48 12.832031 42.167969 7 35 7 C 30.945313 7 27.382813 8.925781 25 11.84375 C 22.617188 8.925781 19.054688 7 15 7 Z M 15 9 C 18.835938 9 22.1875 10.96875 24.15625 13.9375 L 25 15.1875 L 25.84375 13.9375 C 27.8125 10.96875 31.164063 9 35 9 C 41.085938 9 46 13.914063 46 20 C 46 32.898438 31.59375 39.574219 25 44.78125 C 18.40625 39.574219 4 32.898438 4 20 C 4 13.914063 8.914063 9 15 9 Z " fill="#60bcf0"/></g></svg>
</a> -->
</div>
</div>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

</div>

<?php do_action( 'woocommerce_after_single_variation' ); ?>      

<!-- <div class="single_variation_wrap">  -->
 <?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
			//do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				//do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				//do_action( 'woocommerce_after_single_variation' );
       ?>
       <!-- </div>  -->




       <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
       <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
       <input type="hidden" name="variation_id" class="variation_id" value="0" />

     <?php endif; ?>

     <?php do_action( 'woocommerce_after_variations_form' ); ?>
   </div>
 </form>

 <?php
 do_action( 'woocommerce_after_add_to_cart_form' ); ?>


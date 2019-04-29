 <div class="page-content">
      <section>
        <div class="container">

            <?php 
              $args = array(
                'delimiter'   => '',
                'wrap_before' => '<ol class="breadcrumb">',
                'wrap_after'  => '</ol>',
                'before'      => '<li class="breadcrumb-item">',
                'after'       => '</li>'
            );
            woocommerce_breadcrumb($args);

            $vendor_url = new SimpleXMLElement(do_shortcode('[wcfm_store_info id="" data="store_url"]'));

            print_r( $vendor_url);
            $vendor_gravatar = new SimpleXMLElement(do_shortcode('[wcfm_store_info id="" data="store_gravatar"]'));

            print_r($vendor_gravatar);

            ?>

          <form class="pf-form" validate>
            <div class="row">
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="productimg"><img class="img-fluid" src="assets/imgs/whitebuttercreamcake_1.jpg">
                      <div class="productimg--des">Images shown on this page may differ slightly from the actual product.</div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="pf-product">
                      <div class="pf-product--name"><?php the_title() ?></div>
                      <div class="pf-product--sku"><?php party_show_sku() ?></div><a class="pf-product--seller" href="<?php echo $vendor_url['href']; ?>">
                        <div class="pf-product--seller--img"><img class="img-fluid" src="<?php echo $vendor_gravatar['@attributes']['src']; ?>"></div>
                        <div class="pf-product--seller--name"><?php echo do_shortcode('[wcfm_store_info id="" data="store_name"]'); ?></div></a>
                      <p class="pf-product--description">"Naomi" is a name that means "enjoyment, pleasure or gratification" and that captures what Naomi aims to bring with their creative dessert creations. Starting as a tiny food stall at Golden Mile Food Centre, Naomi has gone on to become a cake powerhouse with heaps of loyal fans.</p>
                      <div class="pf-product--btm">
                        <ul class="nav nav-pills m-b-30" id="pills-tab" role="tablist">
                          <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Select Options</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Details</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Policies</a></li>
                        </ul>
                        <div class="tab-content m-b-15">
                          <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1-tab">
                            <div class="row m-b-30">
                              <div class="col-4">
                                <p class="uppercase">Weight dimension<span class="asterisk">*</span></p>
                              </div>
                              <div class="col-8">
                                <div class="form-group">
                                  <select class="form-control hidden-validate" required name="weight-dimension">
                                    <option selected disabled>Choose an Option...</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row m-b-30">
                              <div class="col-4">
                                <p class="uppercase">choose your filling<span class="asterisk">*</span></p>
                              </div>
                              <div class="col-8">
                                <div class="form-group">
                                  <select class="form-control hidden-validate" required name="choose-filling">
                                    <option selected disabled>-- Please Select --</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                    <option>2.5kg/ 20 to 30 pax</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row m-b-30">
                              <div class="col-4">
                                <p class="uppercase m-b-5">personalise this!</p>
                                <p>30 characters</p>
                              </div>
                              <div class="col-8">
                                <div class="form-group">
                                  <input class="form-control" type="text" name="personalise-text">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2-tab">
                            <div class="row m-b-15">
                              <div class="col-4">
                                <div>
                                  <p class="uppercase">WHAT'S INCLUDED</p>
                                </div>
                              </div>
                              <div class="col-8">
                                <div>
                                  <p>Complementary candle(s) included.</p>
                                  <div class="d-flex align-items-center">
                                    <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
</svg>
                                    </div>
                                    <p>Disposable knives</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row m-b-15">
                              <div class="col-4">
                                <div>
                                  <p class="uppercase">notes</p>
                                </div>
                              </div>
                              <div class="col-8">
                                <div>
                                  <ul>
                                    <li>Serving size guideline:</li>
                                    <li>1kg: For up to 10 pax</li>
                                    <li>1.5kg - 2kg: For 10 to 20 pax</li>
                                    <li>2.5kg: For 20 to 30 pax</li>
                                    <li>3kg: For 30 to 40 pax</li>
                                    <li>3.5kg: For 40 to 50 pax</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab-3-tab">
                            <div class="row">
                              <div class="col-4">
                                <div class="d-flex align-items-center">
                                  <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
</svg>
                                  </div>
                                  <p class="uppercase m-b-0">Returns </p>
                                </div>
                              </div>
                              <div class="col-8">
                                <div>
                                  <p><strong>The following item cant't be returned or exchanged.</strong></p>
                                  <p>Because of the nature of these items, unless they arrive damaged or defective, I cant't accept returns.</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 m-b-25">
                <div class="product-info product-info-main-form">
                  <div class="product-info--price m-b-15"><span>$</span><span class="m-r-5">150.00</span><span class="font-12">each</span></div>
                  <div class="product-info--datenote m-b-45">
                    <div class="d-flex align-items-center">
                      <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
</svg>
                      </div>
                      <p class="m-b-0">Delivery will be take place in 4 to 6 working days.</p>
                    </div>
                  </div>
                  <div class="product-info--quantity m-b-20">
                    <p class="font-12">SELECT QUANTITY</p>
                    <div class="incrementers">
                      <input class="-minus btn" onclick="minus()" value="-" readonly>
                      <div class="form-group m-b-0 w-100">
                        <input class="form-control text-center" id="qty" maxlength="12" min="1" value="1" title="Qty" name="quantity" readonly>
                      </div>
                      <input class="-plus btn" onclick="plus()" value="+" readonly>
                    </div>
                  </div>
                  <div class="product-info--opt-delivery">
                    <p class="font-12 m-b-30">CHOOSE DELIVERY OPTIONS</p>
                    <div class="-jquery-tabs delivery-option">
                      <ul>
                        <li><a class="-homedly btn-opt btn-homedelivery text-center w-100 font-12 d-flex justify-content-center align-items-center" href="#homeDelivery">
                            <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
</svg>
                            </div>Home Delivery</a></li>
                        <li><a class="-pickdly btn-opt pickup text-center w-100 font-12 d-flex justify-content-center align-items-center" href="#pickUp">
                            <div class="icon m-r-10">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Bitstream Vera Sans" d="M 1 3 L 1 4 L 1 14 L 1 15 L 2 15 L 3 15 L 3 47 L 3 48 L 4 48 L 46 48 L 47 48 L 47 47 L 47 15 L 48 15 L 49 15 L 49 14 L 49 4 L 49 3 L 48 3 L 2 3 L 1 3 z M 3 5 L 47 5 L 47 13 L 3 13 L 3 5 z M 5 15 L 45 15 L 45 46 L 5 46 L 5 15 z M 17.5 19 C 15.578812 19 14 20.578812 14 22.5 C 14 24.421188 15.578812 26 17.5 26 L 32.5 26 C 34.421188 26 36 24.421188 36 22.5 C 36 20.578812 34.421188 19 32.5 19 L 17.5 19 z M 17.5 21 L 32.5 21 C 33.340812 21 34 21.659188 34 22.5 C 34 23.340812 33.340812 24 32.5 24 L 17.5 24 C 16.659188 24 16 23.340812 16 22.5 C 16 21.659188 16.659188 21 17.5 21 z" overflow="visible" enable-background="accumulate" font-family="Bitstream Vera Sans"/>
</svg>
                            </div>Pick-up from store</a></li>
                      </ul>
                      <div class="home-delivery-box" id="homeDelivery">
                        <div class="calendar-ui">
                          <p class="text-center font-12 p-t-10 m-b-10">Choose Date & Time</p>
                          <input id="calendarValue" type="hidden" value="" name="calendarValue">
                          <input id="timerValue" type="hidden" value="" name="timerValue">
                          <div type="text" id="datepicker"></div>
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
                      <div id="pickUp"></div>
                    </div>
                  </div>
                  <div class="action d-flex align-items-center">
                    <button class="btn btn-main btn-solid w-100 p-t-15 p-b-15 tocart" type="submit" title="Add to Cart" id="">ADD TO CART</button><a class="icon icon-md m-l-20" href="#"><xml version="1.0" encoding="UTF-8">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1" fill="#60bcf0"><g id="surface1" fill="#60bcf0"><path style=" stroke:none;fill-rule:nonzero;fill-opacity:1" d="M 15 7 C 7.832031 7 2 12.832031 2 20 C 2 34.761719 18.695313 42.046875 24.375 46.78125 L 25 47.3125 L 25.625 46.78125 C 31.304688 42.046875 48 34.761719 48 20 C 48 12.832031 42.167969 7 35 7 C 30.945313 7 27.382813 8.925781 25 11.84375 C 22.617188 8.925781 19.054688 7 15 7 Z M 15 9 C 18.835938 9 22.1875 10.96875 24.15625 13.9375 L 25 15.1875 L 25.84375 13.9375 C 27.8125 10.96875 31.164063 9 35 9 C 41.085938 9 46 13.914063 46 20 C 46 32.898438 31.59375 39.574219 25 44.78125 C 18.40625 39.574219 4 32.898438 4 20 C 4 13.914063 8.914063 9 15 9 Z " fill="#60bcf0"/></g></svg>
</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="mightlike-wrap m-b-30">
            <div class="row">
              <div class="col-12">
                <h2 class="text-center">You Might Also Like...</h2>
              </div>
            </div>
            <div class="-carousel p-t-45">
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
                            <div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="#">
                                <div class="tiles--single--img border-line"><img class="img-fluid" src="https://picsum.photos/300/300"></div><a class="tiles--single--achor font-12" href="">Hello Kitty</a></a>
                              <div class="tiles--quatity font-normal">FROM S$210</div>
                            </div>
            </div>
          </div>
        </div>
      </section>
    </div>

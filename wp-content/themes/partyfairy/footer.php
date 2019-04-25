   <footer class="pf-footer">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-lg-9">
            <div class="pf-footer--left">
              <div class="row m-b-25">



<?php $footer_menu = get_field('footer_menu', 'option'); 
if ($footer_menu){
foreach ($footer_menu as $key => $value) {
 
?>
                <div class="col-lg-3">
                  <div class="footer--title">
                    <img src="<?php echo  $value['menu_icon'] ?>" style="margin-right: 5px;width: 30px;height: 30px;">
                   <?php echo  $value['menu_title'] ?>
                  </div>
                  <ul class="footer--list">
                    <?php if($value['sub_menu']) { 
                      
                      foreach ($value['sub_menu'] as $sub_key => $sub_value) {
                      
                      ?>
                    
                    <li><a href="<?php echo $sub_value['sub_menu_link'] ?>" <?php if($sub_value['open_new_tab'] =='y') { echo 'target="_blank"'; } ?>><?php echo $sub_value['title_sub_menu'] ?></a></li>
                  
                  <?php }
                      } ?>
                  </ul>
                </div>

  <?php }  } ?>   
              </div>
              <div class="row">
                <div class="col-lg-4 m-b-10">
                  <div class="footer-btm-title">
                    <h6 class="font-12"><?php the_field('about_as_title', 'option'); ?></h6>
                   <?php the_field('about_as_description', 'option'); ?>
                  </div>
                </div>
                <div class="col-lg-4 m-b-10"> 
                  <div class="footer-btm-title">
                    <h6 class="font-12"><?php the_field('payment_partner_title', 'option'); ?></h6>

                    <?php $payment = get_field('payment_partner_icon', 'option'); 

                      if($payment) {

                        foreach ($payment as $key => $value) {
                          
                          ?>

                            <img src="<?php echo $value['icon']?>" width="55" height="45">

                          <?php

                        }

                      }

                    ?>
                  </div>
                </div>
                <div class="col-lg-4 m-b-10">
                  <div class="footer-btm-title">
                    <h6 class="font-12"><?php the_field('payment_partner_title', 'option'); ?></h6>

                    <?php $secure = get_field('security_certification', 'option'); 

                      if($secure) {

                        foreach ($secure as $key => $value) {
                          
                          ?>

                            <img src="<?php echo $value['icon']?>">

                          <?php

                        }

                      }

                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="pf-footer--right">
              <div class="newsletter-wrap">
                <div class="newsletter-wrap--head">
                  <div class="newsletter-wrap--head--img"><xml version="1.0" encoding="UTF-8" standalone="no">
                    <img src="<?php the_field('footer_logo', 'option'); ?>">
                  </div>
                  <div class="newsletter-wrap--head--text">
                    <h5 class="word"><?php the_field('title_subcribe', 'option'); ?></h5>
                    <p class="word-sub font-normal"><?php the_field('subcribe_description', 'option'); ?></p>
                  </div>
                </div>
                <div class="newsletter-wrap--body">
                  <form class="pf-form" novalidate="novalidate" action="" method="post">
                    <div class="form-group">
                      <div class="newsletter-subscribe">
                        <input name="email" type="email" placeholder="Enter your email address">
                        <button class="action" title="Subscribe" type="submit" disabled="disabled">Join</button>
                      </div>
                    </div>
                  </form>
                  <div class="tnc-agreement"><span class="control">
                      <input class="tnc-agreement-checkbox-newsletter" id="tnc-agreement-checkbox-newsletter" name="tnc-agreement-checkbox-newsletter" type="checkbox"></span>
                    <label class="tnc-label textcolorwhite m-l-30" for="tnc-agreement-checkbox-newsletter">I agree to the <a class="textcolorwhite" href="terms-and-conditions">Terms & Conditions</a> and <a class="textcolorwhite" href="privacy-policy-cookie-restriction-mode">Privacy Policy</a></label>
                  </div>
                </div>
                <div class="newsletter-wrap--footer">
                  <p><?php the_field('copyright', 'option'); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
 <?php wp_footer() ?>
  </body>
</html>
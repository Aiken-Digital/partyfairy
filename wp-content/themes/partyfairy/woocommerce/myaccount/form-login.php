<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

  <h1 class="text-center">Sign In</h1>

<div class="m-t-30">
<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>


            <div class="pf-tab register-tab">
              <ul class="pf-tab--ul">
                <li class="pf-tab--li active" data-target="registerTab">I'm new here</li>
                <li class="pf-tab--li" data-target="loginTab">I have an account</li>
              </ul>
            </div>


            <div class="row justify-content-md-center -info-tab" id="registerTab">
            		<form method="post" class="pf-form col-lg-6" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

         
                <div class="form-group">
                  <label for="firstname">First Name<span class="asterisk m-l-10">*</span></label>
                  <input class="form-control" type="text" placeholder="Enter Your First Name" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                  <label for="lastname">First Name<span class="asterisk m-l-10">*</span></label>
                  <input class="form-control" type="text" placeholder="Enter Your Last Name" id="lastname" name="lastname" required>
                </div>
                <div class="form-group">
                  <label for="reg_email">Email<span class="asterisk m-l-10">*</span></label>
                  <input required placeholder="Enter Your Email Address"  type="email" class="form-control" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>


                </div>
                <div class="form-group">
                  <label for="userpassword">Password<span class="asterisk m-l-10">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter Your Password" id="userpassword" name="password" required>
                  <label for="userpassword">Password Strength: No Password</label>
                </div>
                <div class="form-group">
                  <label for="userpasswordconfirm">Confirm Password<span class="asterisk m-l-10">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter Your Password Again" id="userpasswordconfirm" name="passwordconfirm" required>
                </div>
                <div class="form-group">
                  <div class="m-b-20"><span class="control">
                      <input id="rmbme" name="rememberme" type="checkbox"></span>
                    <label class="tnc-label textcolorwhite m-l-30 m-b-0" for="rmbme">Remember Me <a class="textcolorwhite" href="terms-and-conditions">What's this?</a></label>
                  </div>
                  <div class="tnc-agreement"><span class="control">
                      <input id="singUpNewsletter" name="singUpNewsletter" type="checkbox"></span>
                    <label class="tnc-label textcolorwhite m-l-30 m-b-0" for="singUpNewsletter">Sign Up for Newsletter </label>
                  </div>
                </div>
                	<?php do_action( 'woocommerce_register_form' ); ?>

                <div class="row">
                  <div class="col-lg-6 col-xl-4 col-md-6">
                    <div class="form-group m-t-30">
                      <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                      <button class="btn btn-main btn-solid w-100 p-t-15 p-b-15 tocart" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" type="submit" id="">CREATE ACCOUNT</button>
                    </div>
                  </div>
                </div>

    
			<?php do_action( 'woocommerce_register_form_end' ); ?>


                <div class="divide m-t-30 m-b-25"><span class="divide-text">or</span></div>

		<div class="social-signin m-t-15 m-b-20">
			<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=facebook&redirect=https://fixxstaging.com/partyfairy/my-account/">
				<span class="btn-social btn-social--fb"><span class="svg-icon m-r-15">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" style="fill: rgb(255, 255, 255);">
					<path d="M40,0H10C4.486,0,0,4.486,0,10v30c0,5.514,4.486,10,10,10h30c5.514,0,10-4.486,10-10V10C50,4.486,45.514,0,40,0z M39,17h-3 c-2.145,0-3,0.504-3,2v3h6l-1,6h-5v20h-7V28h-3v-6h3v-3c0-4.677,1.581-8,7-8c2.902,0,6,1,6,1V17z"/>
				</svg></span>Sign in with Facebook</span>
			</a>
		</div>

		<div class="social-signin m-t-15">
			<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=google&redirect=https://fixxstaging.com/partyfairy/my-account/">
				<span class="btn-social btn-social--google"><span class="svg-icon m-r-15">
					<xml version="1.0" encoding="UTF-8">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1">
							<g id="surface1">
								<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 39.0625 17.1875 L 42.1875 17.1875 L 42.1875 29.6875 L 39.0625 29.6875 Z "/>
								<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 34.375 21.875 L 46.875 21.875 L 46.875 25 L 34.375 25 Z "/>
								<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 30.960938 22.1875 L 30.882813 21.875 L 17.1875 21.875 L 17.1875 26.5625 L 26.5625 26.5625 C 25.816406 30.996094 21.832031 34.375 17.1875 34.375 C 12.007813 34.375 7.8125 30.179688 7.8125 25 C 7.8125 19.820313 12.007813 15.625 17.1875 15.625 C 19.53125 15.625 21.667969 16.492188 23.3125 17.914063 L 26.671875 14.625 C 24.171875 12.335938 20.84375 10.9375 17.1875 10.9375 C 9.421875 10.9375 3.125 17.234375 3.125 25 C 3.125 32.765625 9.421875 39.0625 17.1875 39.0625 C 24.953125 39.0625 31.25 32.765625 31.25 25 C 31.25 24.035156 31.148438 23.097656 30.960938 22.1875 Z "/>
							</g>
						</svg>
					</span>Sign in with Google </span>
				</a>
			</div>
      
          

</form>
</div>

<?php endif; ?>



            <div class="row justify-content-md-center -info-tab" id="loginTab">


		<form class="pf-form col-lg-6" method="post">



			<?php do_action( 'woocommerce_login_form_start' ); ?>


                <div class="form-group">
                  <label for="loginemailadd">Email<span class="asterisk m-l-10">*</span></label>
                  <input class="form-control" type="email" name="username" placeholder="Enter Your Email Address" id="loginemailadd" name="loginemailadd" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required>

                </div>
                <div class="form-group">
                  <label for="loginuserpassword">Password<span class="asterisk m-l-10">*</span></label>
                  <input class="form-control" type="password" name="password" placeholder="Enter Your Password" id="loginuserpassword" name="loginuserpassword" required>
                </div>

			<?php do_action( 'woocommerce_login_form' ); ?>

                <div class="row">
                  <div class="col-lg-4 col-xl-3 col-md-5">
                    <div class="form-group m-t-30">

                      <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="btn btn-main btn-solid w-100 p-t-15 p-b-15 tocart" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'SIGN IN', 'woocommerce' ); ?></button>


                    </div>
                  </div>
                  <div class="col-lg-6 col-xl-7 col-md-5">
                    
                    <p class="woocommerce-LostPassword lost_password float-right">
        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
      </p>
                  </div>
                </div>


                <div class="divide m-t-30 m-b-25"><span class="divide-text">or</span></div>
            

            		<div class="social-signin m-t-15 m-b-20">
			<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=facebook&redirect=https://fixxstaging.com/partyfairy/my-account/">
				<span class="btn-social btn-social--fb"><span class="svg-icon m-r-15">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" style="fill: rgb(255, 255, 255);">
					<path d="M40,0H10C4.486,0,0,4.486,0,10v30c0,5.514,4.486,10,10,10h30c5.514,0,10-4.486,10-10V10C50,4.486,45.514,0,40,0z M39,17h-3 c-2.145,0-3,0.504-3,2v3h6l-1,6h-5v20h-7V28h-3v-6h3v-3c0-4.677,1.581-8,7-8c2.902,0,6,1,6,1V17z"/>
				</svg></span>Sign in with Facebook</span>
			</a>
		</div>

		<div class="social-signin m-t-15">
			<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=google&redirect=https://fixxstaging.com/partyfairy/my-account/">
				<span class="btn-social btn-social--google"><span class="svg-icon m-r-15">
					<xml version="1.0" encoding="UTF-8">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1">
							<g id="surface1">
								<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 39.0625 17.1875 L 42.1875 17.1875 L 42.1875 29.6875 L 39.0625 29.6875 Z "/>
								<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 34.375 21.875 L 46.875 21.875 L 46.875 25 L 34.375 25 Z "/>
								<path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 30.960938 22.1875 L 30.882813 21.875 L 17.1875 21.875 L 17.1875 26.5625 L 26.5625 26.5625 C 25.816406 30.996094 21.832031 34.375 17.1875 34.375 C 12.007813 34.375 7.8125 30.179688 7.8125 25 C 7.8125 19.820313 12.007813 15.625 17.1875 15.625 C 19.53125 15.625 21.667969 16.492188 23.3125 17.914063 L 26.671875 14.625 C 24.171875 12.335938 20.84375 10.9375 17.1875 10.9375 C 9.421875 10.9375 3.125 17.234375 3.125 25 C 3.125 32.765625 9.421875 39.0625 17.1875 39.0625 C 24.953125 39.0625 31.25 32.765625 31.25 25 C 31.25 24.035156 31.148438 23.097656 30.960938 22.1875 Z "/>
							</g>
						</svg>
					</span>Sign in with Google </span>
				</a>
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>
          </form>
            </div>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

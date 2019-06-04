 <?php /* Template Name: Page Register */ ?>
 <?php get_header() ?>
 <div class="page-content">
 	<section class="m-b-60">
 		<div class="container">
 			<?php 
 			if(!is_user_logged_in()){  ?>
 				<h1 class="text-center">Sign In</h1>

 				<div class="pf-tab register-tab">
 					<ul class="pf-tab--ul">
 						<li class="pf-tab--li active" data-target="registerTab">I'm new here</li>
 						<li class="pf-tab--li" data-target="loginTab">I have an account</li>
 					</ul>
 				</div>
 				<div class="row justify-content-md-center -info-tab" id="registerTab">
 					<div class="col-lg-6">
 						<?php 

 						echo do_shortcode('[user_registration_form id="252"]'); 

 						?>
 						<div class="divide m-t-30 m-b-25"><span class="divide-text">or</span></div>
 						
 						<div class="social-signin m-t-15 m-b-20">
 							<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=facebook&redirect=https://fixxstaging.com/partyfairy/registration/">
 								<span class="btn-social btn-social--fb"><span class="svg-icon m-r-15">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" style="fill: rgb(255, 255, 255);">
 									<path d="M40,0H10C4.486,0,0,4.486,0,10v30c0,5.514,4.486,10,10,10h30c5.514,0,10-4.486,10-10V10C50,4.486,45.514,0,40,0z M39,17h-3 c-2.145,0-3,0.504-3,2v3h6l-1,6h-5v20h-7V28h-3v-6h3v-3c0-4.677,1.581-8,7-8c2.902,0,6,1,6,1V17z"/>
 								</svg></span>Sign in with Facebook</span>
 							</a>
 						</div>

 						<div class="social-signin m-t-15">
 							<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=google&redirect=https://fixxstaging.com/partyfairy/registration/">
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


 						</div>
 					</div>

 					<div class="row justify-content-md-center -info-tab" id="loginTab">
 						<div class="col-lg-6">
 							<?php echo do_shortcode('[wp_login_form redirect="https://fixxstaging.com/partyfairy/my-account/"]'); ?>


 							<div class="divide m-t-30 m-b-25"><span class="divide-text">or</span></div>
 							
 							<div class="social-signin m-t-15 m-b-20">
 								<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=facebook&redirect=https://fixxstaging.com/partyfairy/registration/">
 									<span class="btn-social btn-social--fb"><span class="svg-icon m-r-15">﻿<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" style="fill: rgb(255, 255, 255);">
 										<path d="M40,0H10C4.486,0,0,4.486,0,10v30c0,5.514,4.486,10,10,10h30c5.514,0,10-4.486,10-10V10C50,4.486,45.514,0,40,0z M39,17h-3 c-2.145,0-3,0.504-3,2v3h6l-1,6h-5v20h-7V28h-3v-6h3v-3c0-4.677,1.581-8,7-8c2.902,0,6,1,6,1V17z"/>
 									</svg></span>Sign in with Facebook</span>
 								</a>
 							</div>

 							<div class="social-signin m-t-15">
 								<a href="https://fixxstaging.com/partyfairy/wp-login.php?loginSocial=google&redirect=https://fixxstaging.com/partyfairy/registration/">
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

 								



 							</div>
 						</div>
 					<?php } else { echo '<row><center>You are Logged</center></row>' ;} ?>
 				</div>
 			</section>
 		</div>
 		<?php get_footer() ?>
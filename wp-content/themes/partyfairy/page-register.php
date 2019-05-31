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

 					</div>
 				</div>

 				<div class="row justify-content-md-center -info-tab" id="loginTab">
 					<div class="col-lg-6">
 						<?php echo do_shortcode('[wp_login_form redirect="https://fixxstaging.com/partyfairy/my-account/"]'); ?>

 					</div>
 				</div>
 			<?php } else { echo '<center>You are Logged</center>' ;} ?>
 		</div>
 	</section>
 </div>
 <?php get_footer() ?>
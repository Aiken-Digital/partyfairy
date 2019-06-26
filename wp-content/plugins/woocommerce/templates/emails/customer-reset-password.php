<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<title>Password Reset</title>
	<style type="text/css">
	body, p div, tr, td{
		font-family: arial;
		font-size: 14px;
		color: #555;
	}
	p { margin: 0 0 14px 0; padding: 0; color: #555; }
	ul li{color: #555;}
	img{max-width: 100%;}
	.container-table{
		-webkit-box-shadow: 6px 4px 5px 0px rgba(0,0,0,0.1);
		-moz-box-shadow: 6px 4px 5px 0px rgba(0,0,0,0.1);
		box-shadow: 6px 4px 5px 0px rgba(0,0,0,0.1);
		background-color: #F5F5F5;
	    border-top: 5px solid #41c7ff;
	}
	</style>
</head>
<body>

<table class="container-table" style="width: 600px; padding: 30px 15px;" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr style="background: #fff;">
		<td style="padding: 15px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 15px;">
				<tr>
					<td>
						<p>Hi <span><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></span>,</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>
<a class="link" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"><?php // phpcs:ignore ?>
		<?php esc_html_e( 'click this link', 'woocommerce' ); ?>
	</a> to change your password. Easy-peasy!</p>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<p>


							If for some reason the link doesn't work, just click and paste the following URL: <a href="#"><?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"</a>.</p>
					</td>
				</tr>
				<tr >
					<td>
						<p>If you didn't request a password change, <a href="<?php echo home_url('contact-us') ?>">Please notify us asap.</a></p>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 30px;">
				<tr>
					<td>
						<p>Happy Shopping!</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Love,</p>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 50px;"> <!-- //footer -->
				<tr>
					<td valign="top" style="width: 150px;">
						<img src="imgs/footer-logo.jpg">
					</td>
					<td  valign="top" style="padding-left: 20px;">
						<table>
							<tr><td width="428" height="40" style="color: #41c7ff; font-size: 18px; font-weight: 700;">KATY | CUSTOMER SERVICE PIXIE</td></tr>
							<tr><td>Need to get in touch with us?</td></tr>
							<tr>
								<td colspan="2">
								<a href="https://www.partyfairy.com" target="_blank" style="color:#41c7ff;text-decoration: none;">www.partyfairy.com</a>
									|
								<a href="https://blog.partyfairy.com" target="_blank" style="color:#41c7ff;text-decoration: none;">www.partyfairy.com</a>
								</td>
							</tr>
							<tr>
								<td height="49" colspan="2"  valign="bottom">
								<a href="#" style="display: inline-block; width: 35px; margin-right: 5px;"><img src="imgs/ig-logo.jpg"></a>
								<a href="#" style="display: inline-block; width: 35px;"><img src="imgs/fb-logo.jpg"></a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>

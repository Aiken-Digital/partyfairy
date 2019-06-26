<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/HTML
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer billing full name */ ?>
<p><?php printf( __( 'You’ve received the following order from %s:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
//do_action( 'woocommerce_email_footer', $email );

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<title>New order for vendor</title>
	<style type="text/css">
	body, p div, tr, td{
		font-family: arial;
		font-size: 14px;
		color: #555;
	}
	p { margin: 0 0 14px 0; padding: 0; color: #555; line-height: 16px; }
	ul li{color: #555;}
	img{max-width: 100%;}
	.nomargin{margin: 0;}
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
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<p>Hi <span>Admin</span>,</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>A new order has been placed. yay!</p>
						<p>Please see details on how you should proceed below:</p>
					</td>
				</tr>
			</table>	

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>


			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 30px;">
				<tr>
					<td><p><b>WHEN YOUR ITEM IS READY TO BE DELIVERED / COLLECTED</b></p></td>
				</tr>
				<tr>
					<td>
						<ol>
							<li style="margin-bottom: 5px;">When an item is ready to be sent to the customer, click the "Ready to Ship" button on the Orders page, and indicate your carrier of choice. If your carrier of choice is not part of the list, you may select "Delivered by Seller".</li>
							<li style="margin-bottom: 5px;">After the delivery has been done, you may go to the Orders page and click "Mark as Delivered" against each item.</li>
						</ol>
					</td>
				</tr>
				<tr>
					<td>
						<ul style="list-style: none; padding-left: 25px;">
							<li>
								<p>If the item is going to be collected from store, make sure you do the following:</p>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<ol>
							<li style="margin-bottom: 5px;">When the item is ready for self-collection: Click "Ready to pick" and the select "Pickup from Store" as your carrier of choice.</li>
							<li style="margin-bottom: 5px;"> Click "Mark as Picked Up" after the customer has collected the item(s).</li>
						</ol>
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
						<img src="https://fixxstaging.com/partyfairy/wp-content/uploads/2019/06/footer-logo.jpg">
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
								<a href="#" style="display: inline-block; width: 35px; margin-right: 5px;"><img src="https://fixxstaging.com/partyfairy/wp-content/uploads/2019/06/ig-logo.jpg"></a>
								<a href="#" style="display: inline-block; width: 35px;"><img src="https://fixxstaging.com/partyfairy/wp-content/uploads/2019/06/fb-logo.jpg"></a>
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
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<title>New Order for Customer</title>
	<style type="text/css">
	body, p div, tr, td{
		font-family: arial;
		font-size: 14px;
		color: #555;
	}
	p { margin: 0 0 14px 0; padding: 0; color: #555; }
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
					<td align="right">
						<p><b>Order PROSESSSS<span><?php printf(esc_html__( 'Just to let you know &mdash; we\'ve received your order #%s, and it is now being processed:', 'woocommerce' ))?></span></b></p>
						<p><b>Customer ID: <span><?php printf( esc_html( $order->get_order_number() ) ); ?></span></b></p>

						
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<p>Hi <span><?php echo $order->get_billing_first_name(); ?></span>,</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Thanks for your order - we hope you got all your needed for your party.</p>
						<p>If you have opted to pick up your order from the store, please refer to the vendor's address below, and ignore the 'Delivered to' address.</p>
						<p>Other than that, we're working on your order right now, and we'll be sure to let you know the moment your items are ready. Now go, relax!</p>
					</td>
				</tr>
			</table>


<?php


do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );


?>
			
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
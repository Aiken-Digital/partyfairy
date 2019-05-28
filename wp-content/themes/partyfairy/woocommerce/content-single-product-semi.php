<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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


/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'page-content', $product ); ?>>
	<section>
		<div class="container">

			<nav aria-label="breadcrumb">
				<?php 
				$args = array(
					'delimiter'   => '',
					'wrap_before' => '<ol class="breadcrumb" id="pf-br">',
					'wrap_after'  => '</ol>',
					'before'      => '<li class="breadcrumb-item">',
					'after'       => '</li>'
				);
				woocommerce_breadcrumb($args);
				?>
			</nav>

			<div class="row">
				<div class="col-lg-8">
					<div class="row">
						<div class="col-lg-4">
							<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>
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
					



				</div>

			</div>



		</div>
	</div>


</div>
</div>
<div class="summary entry-summary col-lg-4 m-b-25">

	<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_templte_single_add_to_carta - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>
</div>

<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
</section>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

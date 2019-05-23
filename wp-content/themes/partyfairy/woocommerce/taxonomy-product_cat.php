<?php get_header(); ?>
<?php

$queried_object = get_queried_object();

$header_image  = get_field('header_image', $queried_object);
$term_id 		= $queried_object->term_id;
$thumbnail_id 	= get_woocommerce_term_meta( $term_id, 'thumbnail_id', true );
$image 			= wp_get_attachment_url( $thumbnail_id );
$the_query 		= new WP_Query( array(
  'post_type' => 'product',
  'tax_query' => array(
    array(
      'taxonomy' => 'product_cat',
      'field' => 'id',
      'terms' => $term_id
    )
  )
) );
$count_post 	= $the_query->found_posts;
?>
<form method="GET" id="filter" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php">
  <input type="hidden" name="action" value="filter_category">
  <input type="submit" name="submit" style="display: none;">
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
      woocommerce_breadcrumb($args); ?>
      <div class="row">


        <?php get_sidebar() ?>

        <div  class="col-lg-10">

         <div class="row">
          <div class="col-12">
            <?php if($header_image) { ?><div class="innner-banner"><img class="img-fluid w-100" src="<?php echo $header_image ?>"></div><?php } ?>
            <div class="inner-page-title m-b-0 lg-m-b-30">
              <h2><?php echo $queried_object->name; ?> <span class="font-12">(<?php echo $count_post ?> total)</span></h2>
              <div class="toolbar-sorter sorter d-none d-lg-block">
                <label class="sorter-label" for="sorter">Sort By</label>
                <select class="sorter-options" data-role="sorter">
                  <option value="position">Position</option>
                  <option value="name" selected="selected">Product Name</option>
                  <option value="price">Price</option>
                </select><a class="sorter-action sort-asc" title="Set Descending Direction" href="#" data-role="direction-switcher" data-value="desc"></a>
              </div>
            </div>
          </div>
        </div>

        <div class="m-filter d-lg-none">
          <div class="filter-by m-filter-child -active-filter-by">Filter By </div>
          <div class="sort-by m-filter-child">Sort By</div>
        </div>


        <div class="row tiles" id="response">


          <?php
          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
          $args = [
            'post_type'       => 'product',
            'posts_per_page'  => 12,
            'paged'           => $paged,
            'tax_query'       => [
              [
                'taxonomy'        => 'product_cat',
                'field'           => 'term_id',
                'terms'           =>  $term_id
              ]
            ]
          ];

          // if(isset($_GET['size'])){
          //   $args['tax_query'][] = array(
          //     array(
          //       'taxonomy' => 'pa_mattress-size',
          //       'field' => 'id',
          //       'terms' => $_GET['size']
          //     )
          //   );
          // }
          // elseif(isset( $_GET['type'] ) ){
          //   $args['tax_query'][] = array(
          //     array(
          //       'taxonomy'  => 'product_cat',
          //       'field'     => 'id',
          //       'terms'     => $_GET['type']
          //     )
          //   );
          // }
          // elseif(isset( $_GET['brand'] ) ){
          //   $args['tax_query'][] = array(
          //     array(
          //       'taxonomy' => 'product_brand',
          //       'field' => 'id',
          //       'terms' => $_GET['brand']
          //     )
          //   );
          // }                
          $loop = new WP_Query($args);
          if ( $loop->have_posts() ):

            while ( $loop->have_posts() ) : $loop->the_post(); 
              global $product; 

              $link =  do_shortcode('[wcfm_store_info id="" data="store_url"]');
              preg_match_all('/<a[^>]+href=([""])(?<href>.+?)\1[^>]*>/i', $link, $result_url_vendor); 
              $name = do_shortcode('[wcfm_store_info id="" data="store_name"]');
              preg_match_all('|<div[^>]*>(?<name>[^<]+)<|', $name, $result_name_vendor);

              ?>

              <div class="col-lg-3 col-md-6 col-6 tiles-box text-center"><a class="tiles--single" href="<?php the_title() ?>">
                <div class="tiles--single--img"><img class="img-fluid" src="<?php if ( has_post_thumbnail() ) {the_post_thumbnail_url('full'); } else { echo get_template_directory_uri().'/images/broken/img-not-available-landscape.png'; } ?>"></div><a class="tiles--single--model" href=""><?php the_title() ?></a></a>
                <div class="tiles--price">$130.00<span>each</span></div>
                <div class="tiles--code">290-000626</div><a class="tiles--seller" href="<?php if (!empty($result_url_vendor)) { echo $result_url_vendor['href'][0]; } ?>"><?php if (!empty($result_name_vendor)) { echo $result_name_vendor['name'][0]; } ?></a><a class="btn btn-rounded btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-20 p-r-20 font-11" href="<?php the_permalink() ?>">DETAILS</a>
              </div>



            <?php endwhile; ?>
          </div>


          <div class="row">
           <div class="col-12 pf-paging">
            <?php pagination_bar( $loop, $paged ); ?>
            <?php	//do_action( 'woocommerce_after_shop_loop' ); ?>

          </div>
        </div>



        <?php wp_reset_postdata();
      else:
                ///include(get_template_directory() . '/inc/empty-product.php');
      endif; 
      wp_reset_query();
      ?>


    </div>



  </div>
</div>
</section>
</div>
</form>

<?php get_footer(); ?>


<script type="text/javascript">


  jQuery(function($){
    $('#filter').submit(function(){
      var filter = $('#filter');
      var imgloading = '<?php echo get_template_directory_uri(); ?>/broken/loading-com.gif';
      $('#ldg').remove();
      $.ajax({
        url:filter.attr('action'),
      data:filter.serialize(), // form data
      type:filter.attr('method'), // POST
      beforeSend:function(xhr){
       $('.aplyfilter').text('Processing...'); // changing the button label
       $('.default-post').remove();
       $('.pl-footer').remove();
       $
       $('#response').append('<div class="col-sm-12" id="ldg"><center><img src="'+imgloading+'" /><center></div>')

     },
     success:function(data){
      $('#ldg').remove();
        $('.aplyfilter').text('Apply filter'); // changing the button label back
        $('#response').html(data); // insert data
      }
    });
      return false;
    });
  });


  $('.autocheckbox').on('change', function() {
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
    
  }); 

</script>
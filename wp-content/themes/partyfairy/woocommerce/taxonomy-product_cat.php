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




        </div>


        <div class="row">
         <div class="col-12 pf-paging">

           <?php	do_action( 'woocommerce_after_shop_loop' ); ?>

         </div>
       </div>


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
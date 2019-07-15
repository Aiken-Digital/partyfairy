<?php get_header(); ?>
<?php

$queried_object = get_queried_object();

$header_image  = get_field('header_image', $queried_object);
$term_id 		= $queried_object->term_id;



$sub_cat = get_terms('product_cat', array('hide_empty' => 0, 'parent' =>$term_id)); 

$count_post 	= count($sub_cat);
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
                <select class="sorter-options autocheckbox" data-role="sorter" name="sorting">

                  <option value="" selected="selected">Sort By</option>
                  <option value="position">Position</option>
                  <option value="NAME-ASC">A - Z </option>
                  <option value="NAME-DESC">Z - A </option>
                  <option value="PRICE-ASC">Low To High</option>
                  <option value="PRICE-DESC">High To Low</option>
                </select>
              <!--   <a class="sorter-action sort-asc" title="Set Descending Direction" href="#" data-role="direction-switcher" data-value="desc"></a>
              -->              </div>
            </div>
          </div>
        </div>

        <div class="m-filter d-lg-none">
          <div class="filter-by m-filter-child -active-filter-by">Filter By </div>
          <div class="sort-by m-filter-child">Sort By</div>
        </div>


        <div id="response">
          <div class="row tiles default-post">

            <?php 
            $sub_cat = get_terms('product_cat', array('hide_empty' => 0, 'parent' =>$term_id)); 
            foreach($sub_cat as $bkey => $value) :

              $thumbnail_id   = get_woocommerce_term_meta( $value->term_id, 'thumbnail_id', true );
              $image      = wp_get_attachment_url( $thumbnail_id );
              
              ?>


              <div class="col-lg-3 col-md-6 col-6 tiles-box text-center default-post"><a class="tiles--single" href="<?php echo get_term_link( $value->slug, $value->taxonomy ); ?>">
                <div class="tiles--single--img"><img class="img-fluid" src="<?php if (  $image  ) { echo  $image ; } else { echo  $image ; } ?>"></div><a class="tiles--single--model" href="<?php echo get_term_link( $value->slug, $value->taxonomy ); ?>"><?php echo $value->name; ?></a></a>

                <div class="tiles--price"><?php echo wp_get_productcat_postcount($value->term_id); ?> products</div>

              </div>


            <?php endforeach ;  ?>







          </div>



        </div>


<div class="container m-t-45 m-b-45">
            <div class="row">
              <div class="col-lg" id="dc-p">

 

             <div class="row m-t-60 m-b-60 justify-content-center">
 <?php the_field('description_for_seo', $queried_object); ?></div>


              </div>
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
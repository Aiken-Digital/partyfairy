 <?php 
 $queried_object = get_queried_object();
 $term_id    = $queried_object->term_id;
// echo $term_id;
 ?>
 <div class="col-lg-2" id="pf-filter">
  <div class="filter-section">
    <div class="close-filter d-block d-lg-none">X</div>
    <div class="filters-clear">
      <div class="filters-clear--head"><span class="font-14"><strong>Active Filters</strong> </span><span class="-clearall font-12">Clear All</span></div>
      <div><span class="font-14">Hello Kity</span></div>
    </div>
    <div class="pf-accordion">

      <?php  
      $wcatTerms1 = get_terms('product_cat', array('hide_empty' => 0, 'parent' =>$term_id)); 
      if($wcatTerms1) : ?>
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">
              <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">Category</button>
            </h5>
          </div>
          <div class="collapse" id="collapse1">
            <div class="card-body">
              <ul>


               <?php 

               foreach($wcatTerms1 as $subkey_x => $wcatTerm2) :

                 ?>
                 <li>
                   <label class="font-12 label-checkbox" for="category-<?php echo $subkey_x ?>"><?php echo $wcatTerm2->name; ?>
                   <input id="category-<?php echo $subkey_x; ?>" name="category[]" class="autocheckbox" type="radio" aria-label="filter checkbox" value="<?php echo $wcatTerm2->term_id?>" ><span class="checkmark"></span>
                 </label>
               </li>

             <?php endforeach ;  

             ?>
           </ul>
         </div>
       </div>
     </div>

   <?php   endif; 



   $wcatTerms1 = get_terms('product_cat', array('hide_empty' => 0, 'parent' =>46)); 
   if($wcatTerms1) :
     ?>

     <div class="card">
      <div class="card-header">
        <h5 class="mb-0">
          <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">Occasions</button>
        </h5>
      </div>
      <div class="collapse" id="collapse2">
        <div class="card-body">
          <ul>



           <?php 
           foreach($wcatTerms1 as $subkey => $wcatTerm1) :

            ?>
            <li>
              <label class="font-12 label-checkbox" for="occasions-<?php echo $subkey ?>"><?php echo $wcatTerm1->name; ?>
              <input id="occasions-<?php echo $subkey ?>" class="autocheckbox" name="category[]" type="radio" aria-label="filter checkbox" value="<?php echo $wcatTerm1->term_id?>" ><span class="checkmark"></span>
            </label>
          </li>

        <?php endforeach ;  

        ?>


      </ul>
    </div>
  </div>
</div>

<?php    

endif;

$wcatTerms1 = get_terms('product_cat', array('hide_empty' => 0, 'parent' =>45)); 
if($wcatTerms1) :
 ?>

 <div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">Themes</button>
    </h5>
  </div>
  <div class="collapse" id="collapse3">
    <div class="card-body">
      <ul>



       <?php 
       foreach($wcatTerms1 as $subkey => $wcatTerm1) :

        ?>
        <li>
          <label class="font-12 label-checkbox" for="themes-<?php echo $subkey ?>"><?php echo $wcatTerm1->name; ?>
          <input id="themes-<?php echo $subkey ?>" class="autocheckbox" name="category[]" type="radio" aria-label="filter checkbox" value="<?php echo $wcatTerm1->term_id?>" ><span class="checkmark"></span>
        </label>
      </li>

    <?php endforeach ;  

    ?>


  </ul>
</div>
</div>
</div>

<?php     endif; 

$wcatTerms1 = get_terms('pa_color', array('hide_empty' => 0)); 
if($wcatTerms1) :
 ?>

 <div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">Colors</button>
    </h5>
  </div>
  <div class="collapse" id="collapse4">
    <div class="card-body">
      <ul class="color-list">
        <?php foreach ($wcatTerms1 as $key => $value) { ?>
          <li>

            <label class="font-12 label-checkbox" for="color-<?php echo $key ?>">

              <img src="<?php the_field('color', $value->taxonomy . '_' . $value->term_id); ?>" alt="<?php echo $value->name; ?>" >

              <input id="color-<?php echo $key ?>" class="autocheckbox" name="color[]" type="radio" aria-label="filter checkbox" value="<?php echo $value->term_id?>" style="display: none;"><span class="checkmark"></span>
            </label>

          <?php } ?>

        </ul>
      </div>
    </div>
  </div>

<?php endif; ?>

<div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">Price</button>
    </h5>
  </div>
  <div class="collapse" id="collapse5">
    <div class="card-body">
      <ul class="price-drag">
        <p>
          <label for="amount"></label>
          <input type="text" id="amount"  readonly style="border:0; color:#f6931f; font-weight:bold;">

          <input type="text" name="price" id="price" value="" style="display: none;">
        </p>

        <div id="slider-range"></div>
      </ul>
    </div>
  </div>
</div>


<?php


$delivery_estimate = get_terms('delivery-estimate', array('hide_empty' => 0)); 
if($delivery_estimate) {
 ?>

 <div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse61" aria-expanded="false" aria-controls="collapse61">Delivery Time</button>
    </h5>
  </div>
  <div class="collapse" id="collapse61">
    <div class="card-body">
      <ul>

        <?php
        $s=1;
        foreach ( $delivery_estimate as $user ) { 

          ?>
          <li>

            <label class="font-12 label-checkbox" for="delivery-estimate-<?php echo $s ?>">
              <?php echo $user->name;?>
              <input id="delivery-estimate-<?php echo $s ?>" class="autocheckbox" name="delivery-estimate[]" type="radio" aria-label="filter checkbox" value="<?php echo $user->term_id?>" ><span class="checkmark"></span>
            </label>
            <?php $s++; } ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

<?php } ?>




<?php


$personalisation = get_terms('personalisation', array('hide_empty' => 0)); 
if($personalisation) {
 ?>

 <div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse62" aria-expanded="false" aria-controls="collapse62">Personalisation</button>
    </h5>
  </div>
  <div class="collapse" id="collapse62">
    <div class="card-body">
      <ul>

        <?php
        $s=1;
        foreach ( $personalisation as $user ) { 

          ?>
          <li>

            <label class="font-12 label-checkbox" for="personalisation-<?php echo $s ?>">
              <?php echo $user->name;?>
              <input id="personalisation-<?php echo $s ?>" class="autocheckbox" name="personalisation[]" type="radio" aria-label="filter checkbox" value="<?php echo $user->term_id?>" ><span class="checkmark"></span>
            </label>
            <?php $s++; } ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

<?php } ?>



<div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">Seller</button>
    </h5>
  </div>
  <div class="collapse" id="collapse6">
    <div class="card-body">
      <ul>

        <?php
        $blogusers = get_users( [ 'role__in' => [ 'wcfm_vendor' ] ] );
// Array of WP_User objects.\
        $s=1;
        foreach ( $blogusers as $user ) { 


          $name = do_shortcode('[wcfm_store_info id="'.$user->ID.'" data="store_name"]');
          preg_match_all('|<div[^>]*>(?<name>[^<]+)<|', $name, $result_name_vendor);


          ?>
          <li>

            <label class="font-12 label-checkbox" for="seller-<?php echo $s ?>">
              <?php if (!empty($result_name_vendor)) { echo $result_name_vendor['name'][0]; } ?>

              <input id="seller-<?php echo $s ?>" class="autocheckbox" name="seller[]" type="checkbox" aria-label="filter checkbox" value="<?php echo $user->ID?>" ><span class="checkmark"></span>
            </label>

          </li>
          <?php $s++; } ?>

        </ul>
      </div>
    </div>
  </div>



  <div class="card">
   <?php if ( is_active_sidebar( 'partyfairy-side-bar' ) ) : ?>
    <?php dynamic_sidebar( 'partyfairy-side-bar' ); ?>
  <?php endif; ?>
</div>

</div>
</div>
</div>



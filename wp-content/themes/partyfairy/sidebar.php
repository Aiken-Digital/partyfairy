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
                   <input id="category-<?php echo $subkey_x; ?>" name="category[]" class="autocheckbox" type="checkbox" aria-label="filter checkbox" value="<?php echo $wcatTerm2->term_id?>" ><span class="checkmark"></span>
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
              <input id="occasions-<?php echo $subkey ?>" class="autocheckbox" name="category[]" type="checkbox" aria-label="filter checkbox" value="<?php echo $wcatTerm1->term_id?>" ><span class="checkmark"></span>
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
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">Themes</button>
    </h5>
  </div>
  <div class="collapse" id="collapse2">
    <div class="card-body">
      <ul>



       <?php 
       foreach($wcatTerms1 as $subkey => $wcatTerm1) :

        ?>
        <li>
          <label class="font-12 label-checkbox" for="themes-<?php echo $subkey ?>"><?php echo $wcatTerm1->name; ?>
          <input id="themes-<?php echo $subkey ?>" class="autocheckbox" name="category[]" type="checkbox" aria-label="filter checkbox" value="<?php echo $wcatTerm1->term_id?>" ><span class="checkmark"></span>
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
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">Colors</button>
    </h5>
  </div>
  <div class="collapse" id="collapse3">
    <div class="card-body">
      <ul class="color-list">
        <?php foreach ($wcatTerms1 as $key => $value) { ?>
          <li>

            <label class="font-12 label-checkbox" for="color-<?php echo $key ?>"><img src="<?php the_field('color', $value->taxonomy . '_' . $value->term_id); ?>" alt="<?php echo $value->name; ?>">
              <input id="color-<?php echo $subkey ?>" class="autocheckbox" name="color[]" type="checkbox" aria-label="filter checkbox" value="<?php echo $value->term_id?>" ><span class="checkmark"></span>
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
      <button class="btn btn-link font-13" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">Price</button>
    </h5>
  </div>
  <div class="collapse" id="collapse4">
    <div class="card-body">
      <ul class="price-drag">
        <li>price</li>
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



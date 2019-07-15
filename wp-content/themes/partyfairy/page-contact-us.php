 <?php /* Template Name: Contact Us Page */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="page-content">
       <section class="account">
          <div class="container m-b-30">
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="<?php echo home_url() ?>">Home</a></li>
                   <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
             </nav>
             <h2 class="text-center">You can also reach us via</h2>
             <div class="row m-t-60 m-b-60 justify-content-center">
                <div class="col-lg-3 text-center">
                   <a class="center-icon-column p-t-30 p-b-30 hover--bglightblue d-inline-block" href="#">
                      <div class="center-icon-column--img">
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1" fill="#60bcf0">
                            <g id="surface1" fill="#60bcf0">
                               <path style=" " d="M 11.976563 4.042969 C 11.976563 4.042969 9.796875 4.042969 7.367188 5.195313 L 7.367188 5.191406 C 5.507813 6.074219 3.941406 7.363281 3.1875 8.417969 C 2.964844 8.707031 2.917969 9.097656 3.0625 9.429688 C 3.210938 9.765625 3.527344 9.992188 3.894531 10.027344 C 4.257813 10.058594 4.609375 9.886719 4.8125 9.582031 C 5.171875 9.078125 6.710938 7.71875 8.226563 7 C 10.246094 6.042969 11.976563 6.042969 11.976563 6.042969 C 12.335938 6.046875 12.671875 5.859375 12.855469 5.546875 C 13.035156 5.234375 13.035156 4.851563 12.855469 4.539063 C 12.671875 4.226563 12.335938 4.039063 11.976563 4.042969 Z M 31.855469 5 C 29.539063 4.996094 26.789063 5.09375 23.699219 5.492188 C 18.820313 6.117188 15.175781 7.0625 12.359375 7.984375 C 9.304688 8.976563 7.277344 10.074219 5.917969 11.03125 C 4.558594 11.988281 3.839844 12.859375 3.574219 13.164063 L 3.570313 13.164063 C 3.027344 13.785156 3.011719 14.445313 3 15.140625 C 2.988281 15.832031 3.066406 16.589844 3.179688 17.34375 C 3.410156 18.851563 3.78125 20.289063 3.992188 20.945313 C 4.492188 22.480469 5.878906 23.300781 7.152344 22.917969 C 7.425781 22.832031 7.792969 22.6875 8.359375 22.46875 C 8.929688 22.246094 9.632813 21.96875 10.339844 21.6875 C 11.757813 21.125 13.238281 20.535156 13.570313 20.414063 L 13.574219 20.414063 C 14.625 20.027344 15.097656 19.042969 15.292969 18.015625 C 15.402344 17.449219 16.214844 14.078125 16.390625 13.339844 C 16.914063 13.105469 19.535156 11.984375 24.480469 11.347656 C 29.441406 10.707031 32.265625 11.074219 32.816406 11.152344 C 33.011719 11.480469 33.425781 12.171875 34.042969 13.207031 C 34.414063 13.835938 34.792969 14.46875 35.078125 14.953125 C 35.222656 15.195313 35.347656 15.398438 35.4375 15.546875 C 35.523438 15.695313 35.53125 15.710938 35.609375 15.832031 C 36.058594 16.519531 36.691406 17.132813 37.617188 17.203125 C 37.914063 17.226563 39.503906 17.425781 41.011719 17.613281 C 41.765625 17.707031 42.519531 17.800781 43.128906 17.871094 C 43.738281 17.941406 44.140625 17.992188 44.457031 18 C 45.765625 18.027344 46.90625 16.910156 47 15.289063 C 47.039063 14.601563 47.023438 13.144531 46.855469 11.65625 C 46.769531 10.914063 46.648438 10.175781 46.453125 9.515625 C 46.261719 8.859375 46.070313 8.238281 45.394531 7.78125 C 44.996094 7.511719 43.972656 6.820313 42.175781 6.230469 C 40.378906 5.640625 37.777344 5.125 34.027344 5.03125 C 33.351563 5.015625 32.628906 5 31.855469 5 Z M 31.847656 7 C 32.601563 7 33.3125 7.015625 33.972656 7.03125 C 37.5625 7.121094 39.96875 7.613281 41.550781 8.132813 C 43.136719 8.652344 43.859375 9.160156 44.277344 9.4375 C 44.164063 9.363281 44.398438 9.609375 44.535156 10.082031 C 44.675781 10.558594 44.789063 11.210938 44.863281 11.882813 C 45.019531 13.230469 45.027344 14.710938 45 15.175781 C 44.960938 15.867188 44.414063 15.996094 44.5 16 C 44.46875 15.996094 43.953125 15.953125 43.359375 15.882813 C 42.757813 15.8125 42.011719 15.722656 41.257813 15.628906 C 39.753906 15.441406 38.300781 15.25 37.773438 15.207031 L 37.769531 15.207031 C 37.789063 15.210938 37.519531 15.101563 37.28125 14.738281 C 37.332031 14.816406 37.238281 14.664063 37.152344 14.519531 C 37.0625 14.371094 36.941406 14.167969 36.796875 13.925781 C 36.507813 13.445313 36.132813 12.8125 35.761719 12.183594 C 35.011719 10.925781 34.273438 9.6875 34.273438 9.6875 L 34.03125 9.285156 L 33.574219 9.210938 C 33.574219 9.210938 29.933594 8.628906 24.222656 9.363281 C 18.5 10.101563 15.113281 11.6875 15.113281 11.6875 L 14.683594 11.890625 L 14.566406 12.355469 C 14.566406 12.355469 13.515625 16.660156 13.328125 17.640625 C 13.21875 18.222656 12.882813 18.535156 12.882813 18.535156 C 12.417969 18.707031 11.015625 19.265625 9.601563 19.828125 C 8.894531 20.109375 8.195313 20.386719 7.636719 20.605469 C 7.078125 20.820313 6.601563 20.992188 6.574219 21 C 6.648438 20.976563 6.113281 20.996094 5.894531 20.328125 L 5.894531 20.324219 C 5.75 19.878906 5.367188 18.414063 5.15625 17.042969 C 5.054688 16.359375 4.992188 15.679688 5 15.175781 C 5.007813 14.671875 5.179688 14.367188 5.078125 14.484375 C 5.414063 14.101563 5.894531 13.496094 7.070313 12.664063 C 8.246094 11.832031 10.089844 10.828125 12.980469 9.882813 C 15.699219 8.996094 19.199219 8.085938 23.953125 7.476563 C 26.933594 7.089844 29.585938 6.996094 31.847656 7 Z M 19 16 C 18.449219 16 18 16.449219 18 17 L 18 19.578125 C 17.554688 19.996094 14.230469 23.125 9.742188 28.347656 C 6.753906 31.824219 5.992188 34.535156 6 37.027344 C 6.003906 38.109375 6.261719 40.050781 6.511719 41.828125 C 6.761719 43.609375 7.015625 45.15625 7.015625 45.15625 C 7.089844 45.644531 7.507813 46 8 46 L 13 46 C 13.550781 46 14 45.550781 14 45 L 14 44 L 38 44 L 38 45 C 38 45.550781 38.449219 46 39 46 L 44 46 C 44.488281 46 44.90625 45.644531 44.984375 45.160156 C 44.984375 45.160156 45.238281 43.605469 45.488281 41.824219 C 45.738281 40.042969 45.996094 38.09375 46 37 C 46.003906 34.511719 45.238281 31.816406 42.257813 28.347656 C 37.769531 23.125 34.445313 19.996094 34 19.578125 L 34 17 C 34 16.449219 33.550781 16 33 16 L 29 16 C 28.449219 16 28 16.449219 28 17 L 28 19 L 24 19 L 24 17 C 24 16.449219 23.550781 16 23 16 Z M 20 18 L 22 18 L 22 20 C 22 20.550781 22.449219 21 23 21 L 29 21 C 29.550781 21 30 20.550781 30 20 L 30 18 L 32 18 L 32 20 C 32 20.277344 32.117188 20.542969 32.320313 20.734375 C 32.320313 20.734375 36.015625 24.152344 40.738281 29.652344 C 43.511719 32.878906 44.003906 34.875 44 37 C 44 37.730469 43.753906 39.785156 43.507813 41.546875 C 43.324219 42.855469 43.222656 43.480469 43.140625 44 L 40 44 L 40 43 C 40 42.449219 39.550781 42 39 42 L 13 42 C 12.449219 42 12 42.449219 12 43 L 12 44 L 8.859375 44 C 8.777344 43.480469 8.675781 42.859375 8.492188 41.550781 C 8.246094 39.792969 8.003906 37.746094 8 37.015625 C 7.992188 34.894531 8.480469 32.886719 11.261719 29.652344 C 15.984375 24.152344 19.679688 20.734375 19.679688 20.734375 C 19.882813 20.542969 20 20.277344 20 20 Z M 37.996094 19.042969 C 37.570313 19.039063 37.1875 19.308594 37.046875 19.707031 C 36.902344 20.109375 37.03125 20.554688 37.359375 20.824219 C 38.234375 21.546875 39.476563 21.910156 40.9375 22 C 42.695313 22.105469 43.515625 21.902344 44.40625 21.5625 C 44.921875 21.359375 45.175781 20.78125 44.976563 20.265625 C 44.777344 19.75 44.199219 19.492188 43.683594 19.691406 C 42.855469 20.011719 42.679688 20.101563 41.0625 20 C 39.898438 19.929688 38.972656 19.5625 38.636719 19.28125 C 38.457031 19.128906 38.230469 19.042969 37.996094 19.042969 Z M 18 25 L 18 27 L 22 27 L 22 25 Z M 24 25 L 24 27 L 28 27 L 28 25 Z M 30 25 L 30 27 L 34 27 L 34 25 Z M 18 29 L 18 31 L 22 31 L 22 29 Z M 24 29 L 24 31 L 28 31 L 28 29 Z M 30 29 L 30 31 L 34 31 L 34 29 Z M 18 33 L 18 35 L 22 35 L 22 33 Z M 24 33 L 24 35 L 28 35 L 28 33 Z M 30 33 L 30 35 L 34 35 L 34 33 Z " fill="#60bcf0"/>
                            </g>
                         </svg>
                      </div>
                      <p class="font-12 bold m-b-5"><?php the_field('phone', get_option('page_for_posts')); ?></p>
                      <p class="font-12"><?php the_field('operation_hour_for_phone', get_option('page_for_posts')); ?></p>
                   </a>
                </div>
                <div class="col-lg-3 text-center">
                   <a class="center-icon-column p-t-30 p-b-30 hover--bglightblue d-inline-block" href="mailto:customercare@partyfairy.com">
                      <div class="center-icon-column--img">
                        
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1" fill="#60bcf0">
                            <g id="surface1" fill="#60bcf0">
                               <path style=" " d="M 0 7 L 0 43 L 50 43 L 50 7 Z M 2 9 L 48 9 L 48 11.5 C 47.609375 11.839844 30.074219 27.136719 28.4375 28.5625 L 28.34375 28.65625 C 27.046875 29.785156 25.71875 30 25 30 C 24.285156 30 22.953125 29.785156 21.65625 28.65625 C 21.285156 28.332031 18.613281 26.023438 16.6875 24.34375 C 10.972656 19.359375 2.292969 11.757813 2 11.5 Z M 2 14.15625 C 3.734375 15.667969 9.886719 21.023438 15.125 25.59375 L 2 35.96875 Z M 48 14.15625 L 48 35.96875 L 34.875 25.59375 C 40.113281 21.023438 46.265625 15.667969 48 14.15625 Z M 16.65625 26.9375 C 17.871094 27.996094 20.066406 29.914063 20.34375 30.15625 L 20.375 30.1875 C 22.066406 31.640625 23.863281 32 25 32 C 26.144531 32 27.957031 31.636719 29.65625 30.15625 C 29.9375 29.914063 32.148438 28.007813 33.375 26.9375 L 48 38.5 L 48 41 L 2 41 L 2 38.5 Z " fill="#60bcf0"/>
                            </g>
                         </svg>
                      </div>
                      <p class="font-12 bold m-b-5"><?php the_field('email', get_option('page_for_posts')); ?></p>
                      <p class="font-12"><?php the_field('operation_hour_for_email', get_option('page_for_posts')); ?></p>
                   </a>
                </div>
                <div class="col-lg-3 text-center">
                   <a class="center-icon-column p-t-30 p-b-30 hover--bglightblue d-inline-block" hre="#">
                      <div class="center-icon-column--img">
                         
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1" fill="#60bcf0">
                            <g id="surface1" fill="#60bcf0">
                               <path style=" " d="M 25 4.070313 C 12.367188 4.070313 2.070313 12.921875 2.070313 24 C 2.070313 30.429688 5.59375 36.027344 11.003906 39.6875 C 10.996094 39.902344 11.011719 40.25 10.730469 41.296875 C 10.378906 42.589844 9.671875 44.414063 8.238281 46.46875 L 7.21875 47.929688 L 9 47.929688 C 15.171875 47.929688 18.742188 43.90625 19.296875 43.261719 C 21.132813 43.691406 23.023438 43.929688 25 43.929688 C 37.632813 43.929688 47.929688 35.078125 47.929688 24 C 47.929688 12.921875 37.632813 4.070313 25 4.070313 Z M 25 5.929688 C 36.769531 5.929688 46.070313 14.078125 46.070313 24 C 46.070313 33.921875 36.769531 42.070313 25 42.070313 C 22.960938 42.070313 21.039063 41.875 19.234375 41.402344 L 18.65625 41.25 L 18.277344 41.714844 C 18.277344 41.714844 15.390625 44.972656 10.78125 45.757813 C 11.617188 44.25 12.234375 42.84375 12.519531 41.78125 C 12.921875 40.300781 12.929688 39.300781 12.929688 39.300781 L 12.929688 38.789063 L 12.5 38.515625 C 7.21875 35.15625 3.929688 29.957031 3.929688 24 C 3.929688 14.078125 13.230469 5.929688 25 5.929688 Z M 15 22 C 13.894531 22 13 22.894531 13 24 C 13 25.105469 13.894531 26 15 26 C 16.105469 26 17 25.105469 17 24 C 17 22.894531 16.105469 22 15 22 Z M 25 22 C 23.894531 22 23 22.894531 23 24 C 23 25.105469 23.894531 26 25 26 C 26.105469 26 27 25.105469 27 24 C 27 22.894531 26.105469 22 25 22 Z M 35 22 C 33.894531 22 33 22.894531 33 24 C 33 25.105469 33.894531 26 35 26 C 36.105469 26 37 25.105469 37 24 C 37 22.894531 36.105469 22 35 22 Z " fill="#60bcf0"/>
                            </g>
                         </svg>
                      </div>
                      <p class="font-12 bold m-b-5"><?php the_field('live_chat', get_option('page_for_posts')); ?></p>
                      <p class="font-12"><?php the_field('operation_hour_for_live_chat', get_option('page_for_posts')); ?></p>
                   </a>
                </div>
             </div>
          </div>
       </section>
    </div>

<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>
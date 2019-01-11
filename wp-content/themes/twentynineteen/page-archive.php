<?php
/* 
Template Name: Archives
*/
get_header(); ?>

 
<div id="primary" class="site-content">
<div id="content" role="main">
 
<?php while ( have_posts() ) : the_post(); ?>
                 
<h1 class="entry-title"><?php the_title(); ?></h1>
 
<div class="entry-content">
 
<?php the_content(); ?>
 
/* Custom Archives Functions Go Below this line */
 
 <p> Hello world </p>
/* Custom Archives Functions Go Above this line */
 
</div><!-- .entry-content -->
 
<?php endwhile; // end of the loop. ?>
<ul class="reviews__content" id="reviews__content">
</ul>
<div id="service-helper"></div>

</div><!-- #content -->
</div><!-- #primary -->
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMvY3m6TFpj0-fqTnQLzH8WpFOQNzB_vU&libraries=places&callback=getRelevantGoogleReviews"></script>
 <script type="text/javascript">
   window.getRelevantGoogleReviews = function(){
     var service = new google.maps.places.PlacesService($('#service-helper').get(0)); // note that it removes the content inside div with tag '#service-helper'

     service.getDetails({
         placeId: 'ChIJAwEf5VFQqEcRollj8j_kqnE'  // get a placeId using https://developers.google.com/places/web-service/place-id
        }, function(place, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
              var resultcontent = '';
              for (i=0; i<place.reviews.length; ++i) {
                window.alert('Name:' + place.name + '. ID: ' + place.place_id + '. address: ' + place.formatted_address);
                resultcontent += '<li class="reviews__item">'
                resultcontent += '<div class="reviews__review-er">' + place.reviews[i].author_name + '</div>';
                var reviewDate = new Date(place.reviews[i].time * 1000);
                var reviewDateMM = reviewDate.getMonth() + 1;
                var reviewDateFormatted = reviewDate.getDate() + '/' + reviewDateMM + '/' + reviewDate.getFullYear(); 
                resultcontent += '<div class="reviews__review-date">' + reviewDateFormatted + '</div>';
                resultcontent += '<div class="reviews__review-rating reviews__review-rating--' + place.reviews[i].rating +'"></div>';
                if (!!place.reviews[i].text){
                  resultcontent += '<div class="reviews__review-comment">' + place.reviews[i].text + '</div>';
                }
                resultcontent += '</li>'
              }
              $('#reviews__content').append(resultcontent);
            }
        });
    }
</script>

<?php get_footer(); ?>
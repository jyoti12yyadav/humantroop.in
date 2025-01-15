 <div class="blog-wrap">
 	<h1 class="heading-title mb-20"><?php the_title(); ?></h1>
    <div class="image-part mb-25">
         <?php
        if(has_post_thumbnail()){
            the_post_thumbnail(); 
        } ?>
    </div>
    <div class="content-part p-0">
          <?php the_content();
		  wp_link_pages(); ?>        
    </div>
</div>
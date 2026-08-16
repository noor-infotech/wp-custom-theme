<?php
/*
Template Name: Full Width
*/

get_header();
?>

<main id="primary" class="site-main full-width">
    <div class="container-fluid">
        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
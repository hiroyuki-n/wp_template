<?php get_header(); ?>
<?php if (have_posts()) : the_post(); ?>
    <div class="page_single">
        <article>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    </div>
<?php endif; ?>
<?php get_footer(); ?>
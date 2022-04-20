<?php get_header(); ?>
<ul>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <div class="img_box"><?php the_post_thumbnail('');  ?></div>
          <div class="day"><?php the_time('Y/m/d'); ?></div>
          <h2><?php the_title(); ?></h2>
        </a>
      </li>
  <?php endwhile;
  endif; ?>
</ul>
<?php get_footer(); ?>
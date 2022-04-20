<?php get_header(); ?>

<div class="page_top">
    <div class="news">
        <h2>投稿タイプ1</h2>
        <ul class="post_list">
            <?php
            $args = array(
                'post_type' => 'news', // 投稿タイプ
                'posts_per_page' => 3, // 表示する投稿数
                'orderby' => 'date', //日付で並び替え
                'order' => 'DESC' // 降順 or 昇順
            );
            $my_posts = get_posts($args);
            ?>
            <?php foreach ($my_posts as $post) : setup_postdata($post); ?>
                <li>
                    <div class="data">
                        <span>
                            <?php $terms = get_the_terms($post->ID, 'category_news');
                            foreach ($terms as $term) {
                                echo $term->name;
                            }
                            ?>
                        </span>
                        <span><?php the_time('Y/m/d'); ?></span>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </li>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
        <div class="link_btn"><a href="/news/">ニュース一覧</a></div>
    </div>
    <div class="faq">
        <h2>よくあるご質問</h2>
        <ul class="post_list">
            <?php
            $args = array(
                'post_type' => 'faq', // 投稿タイプ
                'posts_per_page' => 3, // 表示する投稿数
                'orderby' => 'date', //日付で並び替え
                'order' => 'DESC' // 降順 or 昇順
            );
            $my_posts = get_posts($args);
            ?>
            <?php foreach ($my_posts as $post) : setup_postdata($post); ?>
                <li>
                    <span>
                        <?php $terms = get_the_terms($post->ID, 'category_faq');
                        foreach ($terms as $term) {
                            echo $term->name;
                        }
                        ?>
                    </span>
                    <div class="Q"><?php the_title(); ?></div>
                    <div class="A"><?php the_content(); ?></div>
                </li>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
        <div class="link_btn"><a href="/faq/">よくある質問一覧</a></div>
    </div>
</div>






<?php get_footer(); ?>
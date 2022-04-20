<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon.ico">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">


    <title><?php bloginfo('name');
            wp_title('|', true, 'left'); ?></title>
    <?php
    if (is_single()) { //投稿ページの場合
        if (have_posts()) : while (have_posts()) : the_post();
                echo '<meta name="description" content="' . mb_substr(get_the_excerpt(), 0, 100) . '" />';
                echo "\n"; //抜粋を表示
            endwhile;
        endif;
    } else { //投稿ページ以外の場合（アーカイブページやホームなど）
        echo '<meta name="description" content="';
        bloginfo('description');
        echo '" />';
        echo "\n"; //「一般設定」管理画面で指定したブログの説明文を表示
    }
    ?>

    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:url" content="<?php the_permalink(); ?>">
    <meta property="og:title" content="<?php bloginfo('name');
                                        wp_title('|', true, 'left'); ?>">
    <?php
    if (is_single()) { //投稿ページの場合
        if (have_posts()) : while (have_posts()) : the_post();
                echo '<meta property="og:description" content="' . mb_substr(get_the_excerpt(), 0, 100) . '" />';
                echo "\n"; //抜粋を表示
            endwhile;
        endif;
    } else { //投稿ページ以外の場合（アーカイブページやホームなど）
        echo '<meta property="og:description" content="';
        bloginfo('description');
        echo '" />';
        echo "\n"; //「一般設定」管理画面で指定したブログの説明文を表示
    }
    ?>
    <?php
    $str = $post->post_content;
    $searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i'; //投稿にイメージがあるか調べる
    if (has_post_thumbnail() && !is_archive()) { //投稿にサムネイルがある場合の処理
        $image_id = get_post_thumbnail_id();
        $image = wp_get_attachment_image_src($image_id, 'full');
        echo '<meta property="og:image" content="' . $image[0] . '" />';
        echo "\n";
    } else if (preg_match($searchPattern, $str, $imgurl) && !is_archive()) { //投稿にサムネイルは無いが画像がある場合の処理
        echo '<meta property="og:image" content="' . $imgurl[2] . '" />';
        echo "\n";
    } else { //投稿にサムネイルも画像も無い場合、もしくはアーカイブページの処理
        $ogp_image = home_url() . '/wp-content/themes/' . esc_html(get_template()) . '/img/parts/ogp/ogp.png';
        echo '<meta property="og:image" content="' . $ogp_image . '" />';
        echo "\n";
    }
    ?>


    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css?<?= strtotime('now') ?>">





    <?php wp_head(); ?>
</head>

<body>
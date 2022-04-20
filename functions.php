<?php

// ================================================================
// 管理画面用のJS
// ================================================================
add_action('admin_enqueue_scripts', 'my_admin_script');
function my_admin_script()
{
    wp_enqueue_script('my_admin_script', get_template_directory_uri() . '/js/wp_editor.js', '', '', true);
}
// ================================================================
// アイキャッチ有効
// ================================================================
add_theme_support('post-thumbnails');

// ================================================================
// ブロックエディタ用CSS
// ================================================================
add_theme_support('wp-block-styles'); //ブロックエディタ用のCSS

//ブロックエディタのレイアウトCSSの無効
add_action('wp_enqueue_scripts', 'remove_block_library_style');
function remove_block_library_style()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}

// ================================================================
// headの不要タグ削除
// ================================================================
// remove_action('wp_head', 'wp_enqueue_scripts', 1);
remove_action('wp_head', 'rest_output_link_wp_head'); //REST API のエンドポイントを出力させない
remove_action('wp_head', 'wp_oembed_add_discovery_links'); //REST API のエンドポイントを出力させない
remove_action('wp_head', 'wp_oembed_add_host_js'); //Embed機能を無効化する
remove_action('wp_head', 'rel_canonical'); //rel=”canonical”タグ
remove_action('wp_head', 'wp_generator'); //WPバージョン表記停止
remove_action('wp_head', 'rsd_link'); //ブログ編集ツール連携停止
remove_action('wp_head', 'wlwmanifest_link'); //Windows Live Write連携停止
remove_action('wp_head', 'wp_shortlink_wp_head'); //短縮URL表記停止

//絵文字関連タグ
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
add_filter('emoji_svg_url', '__return_false');

//フィード関連のタグ
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

//「link rel=next」等のタグ
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

remove_filter('wp_robots', 'wp_robots_max_image_preview_large'); //<meta name='robots' content='max-image-preview:large' />非表示


// ================================================================
// 記事編集ページ 不要項目
// ================================================================
add_action('init', 'remove_block_editor_options');
function remove_block_editor_options()
{
    remove_post_type_support('post', 'author');              // 投稿者
    remove_post_type_support('post', 'post-formats');        // 投稿フォーマット
    remove_post_type_support('post', 'revisions');           // リビジョン
    remove_post_type_support('post', 'excerpt');             // 抜粋
    remove_post_type_support('post', 'comments');            // コメント
    remove_post_type_support('post', 'trackbacks');          // トラックバック
    remove_post_type_support('post', 'custom-fields');       // カスタムフィールド
    unregister_taxonomy_for_object_type('category', 'post'); // カテゴリー
    unregister_taxonomy_for_object_type('post_tag', 'post'); // タグ
}

// ================================================================
// カスタム投稿
// ================================================================
//カスタム投稿タイプの追加
add_action('init', 'create_post_type');
function create_post_type()
{
    register_post_type(
        'news',
        array(
            'label' => 'お知らせ', // メニューに表示されるラベル
            'public' => true, // カスタム投稿をを使えるように
            'menu_position' => 5, //サイドメニューでの表示位置
            'has_archive' => true, // アーカイブを有効
            'show_in_rest' => true, // ブロックエディターを使えるように
            'supports' => array(
                'title', // タイトル
                'editor', // 内容
                'thumbnail' // アイキャッチ
            )
        )
    );
    register_post_type(
        'faq',
        array(
            'label' => 'よくあるご質問', // メニューに表示されるラベル
            'public' => true, // カスタム投稿をを使えるように
            'menu_position' => 5, //サイドメニューでの表示位置
            'has_archive' => true, // アーカイブを有効
            'show_in_rest' => true, // ブロックエディターを使えるように
            'supports' => array(
                'title', // タイトル
                'editor', // 内容
                'thumbnail' // アイキャッチ
            )
        )
    );
}

//====== タクソノミー ======
function taxonomy_news()
{
    register_taxonomy(
        'category_news', // タクソノミーの名前
        'news', // このタクソノミーが使われる投稿タイプ
        array(
            'public' => true, // タクソノミーを使えるように
            'show_in_rest' => true, //編集画面にタクソノミーを選択できるように
            'hierarchical' => true // 階層構造にするかどうか（カテゴリとして扱うので true）
        )
    );
    register_taxonomy(
        'category_faq', // タクソノミーの名前
        'faq', // このタクソノミーが使われる投稿タイプ
        array(
            'public' => true, // タクソノミーを使えるように
            'show_in_rest' => true, //編集画面にタクソノミーを選択できるように
            'hierarchical' => true // 階層構造にするかどうか（カテゴリとして扱うので true）

        )
    );
}
add_action('init', 'taxonomy_news');

//====== パーマリンク ======
function post_type_link_news($link, $post)
{
    if ($post->post_type === 'news') {
        return home_url('/news/' . $post->ID);
    } else {
        return $link;
    }
}
add_filter('post_type_link', 'post_type_link_news', 1, 2);

function rewrite_rules_array_news($rules)
{
    $new_rewrite_rules = array(
        'news/([0-9]+)/?$' => 'index.php?post_type=news&p=$matches[1]',
    );
    return $new_rewrite_rules + $rules;
}
add_filter('rewrite_rules_array', 'rewrite_rules_array_news');

//====== パーマリンク ======
function post_type_link_faq($link, $post)
{
    if ($post->post_type === 'faq') {
        return home_url('/faq/' . $post->ID);
    } else {
        return $link;
    }
}
add_filter('post_type_link', 'post_type_link_faq', 1, 2);

function rewrite_rules_array_faq($rules)
{
    $new_rewrite_rules = array(
        'faq/([0-9]+)/?$' => 'index.php?post_type=faq&p=$matches[1]',
    );
    return $new_rewrite_rules + $rules;
}
add_filter('rewrite_rules_array', 'rewrite_rules_array_faq');

// ================================================================
// アーカイブページ　表示数
// ================================================================
add_action('pre_get_posts', 'my_pre_get_posts');
function my_pre_get_posts($query)
{
    if (is_admin() || !$query->is_main_query()) return;

    if ($query->is_post_type_archive('news')) {
        $query->set('posts_per_page', 1);
    }
    if ($query->is_tax('category_news')) {
        $query->set('posts_per_page', 2);
    }
    if ($query->is_post_type_archive('faq')) {
        $query->set('posts_per_page', 1);
    }
    if ($query->is_tax('category_faq')) {
        $query->set('posts_per_page', 2);
    }
}

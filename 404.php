<?php get_header(); ?>
<style>
    .error404 {
        text-align: center;
        padding-top: 60px;
    }
</style>
<div class="error404">
    <h1>404エラー</h1>
    <p>ページが見つかりませんでした</p>
    <p><a href="<?php echo home_url(); ?>">トップページ</a></p>
</div>
<?php get_footer(); ?>
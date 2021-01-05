<?php
/**
 * @var App\View $this
 */
?>
<?php get_header(); ?>

<div class="Site">
    <header class="SiteHeader"></header>

    <main class="SiteBody">
        <?php echo $this->section('content'); ?>
    </main>

    <footer class="SiteFooter"></footer>
</div>

<?php get_footer();
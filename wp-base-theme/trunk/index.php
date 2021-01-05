<?php
/**
 * @var App\View $this
 */
?>
<?php get_header(); ?>

<?php  if (have_posts()) : ?>
    <?php if (is_singular()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php echo partial('article-body'); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php echo partial('article-card'); ?>
        <?php endwhile; ?>
    <?php endif; ?>
<?php else : ?>
    <article>
        <?php _e('Aucun contenu à afficher', 'theme'); ?>
    </article>
<?php endif; ?>

<?php get_footer();
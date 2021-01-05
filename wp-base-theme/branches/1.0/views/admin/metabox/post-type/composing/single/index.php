<?php
/**
 * @var tiFy\Contracts\Metabox\MetaboxView $this
 * @var WP_Post $wp_post
 * @var App\Wordpress\QueryPost $post
 */
?>
    <table class="form-table">
        <tr>
            <th><?php _e('Activation de la bannière d\'entête', 'theme'); ?></th>
            <td>
                <?php echo field('toggle-switch', [
                    'attrs' => [
                        'id'          => 'SingleHeader-switcher',
                        'data-target' => '#SingleHeader-customizer',
                    ],
                    'name'  => '_single_show[header]',
                    'value' => $post->getSingleShow('header') ? 'on' : 'off',
                ]); ?>
            </td>
        </tr>
        <tr id="SingleHeader-customizer">
            <th>
                <label style="display:block;"><?php _e('Image d\'entête personnalisé', 'theme'); ?></label>
                <i style="font-weight:normal;font-size:0.9em;color:#999;line-height:1;">
                    <?php _e('Utilise l\'image représentative par défaut de l\'onglet [Général]', 'theme'); ?>
                </i>
            </th>
            <td>
                <?php echo field('media-image', [
                    'default' => $post->getMetaSingle('_thumbnail_id') ?: app()->img()->src('holder/single.jpg'),
                    'width'   => 1920,
                    'height'  => 1080,
                    'name'    => '_header_img',
                    'value'   => $post->getMetaSingle('_header_img'),
                ]); ?>
            </td>
        </tr>
    </table>

<?php if ($post->getType()->hierarchical) : ?>
    <h3><?php _e('Liste des publications apparentés', 'theme'); ?></h3>
    <table class="form-table">
        <tr>
            <th><?php _e('Activation de l\'affichage', 'theme'); ?></th>
            <td>
                <?php echo field('toggle-switch', [
                    'name'  => '_single_show[children]',
                    'value' => $post->getSingleShow('children') ? 'on' : 'off',
                ]); ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Titre haut (requis) *', 'theme'); ?></th>
            <td>
                <?php echo field('text', [
                    'attrs' => [
                        'class'       => 'widefat',
                        'placeholder' => __('Texte par défaut : En relation avec', 'theme'),
                    ],
                    'name'  => '_child_top_title',
                    'value' => $post->getMetaSingle('_child_top_title'),
                ]); ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Titre bas (requis) *', 'theme'); ?></th>
            <td>
                <?php echo field('text', [
                    'attrs' => [
                        'class'       => 'widefat',
                        'placeholder' => __('Texte par défaut : {{ Titre de la page }}', 'theme'),
                    ],
                    'name'  => '_child_bottom_title',
                    'value' => $post->getMetaSingle('_child_bottom_title'),
                ]); ?>
            </td>
        </tr>
    </table>
<?php endif;
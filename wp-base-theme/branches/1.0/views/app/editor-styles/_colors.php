<?php
/**
 * @var App\View $this
 * @var string $base_tmpl
 * @var array $styles
 */
?>
<div class="EditorStyles-colors">
<?php foreach($this->get('styles.colors', []) as $name => $hex) : ?>
    <div class="EditorStyles-color">
        <a href="#" style="display:block;content: ' ';background-color:<?php echo $hex; ?>"></a><?php echo $hex; ?>
    </div>
<?php endforeach; ?>
</div>

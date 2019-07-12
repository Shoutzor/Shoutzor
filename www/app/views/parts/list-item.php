<figure class="uk-overlay">
    <img src="<?= $view->url()->getStatic('shoutzor:assets/images/music-placeholder.png'); ?>">

    <figcaption class="uk-overlay-panel" data-music="<?= $item->id; ?>">
        <h3><?= $item->title ?></h3>
        <?php if($item->artist): ?>
            <p><?= $item->artist->name ?></p>
        <?php endif; ?>
    </figcaption>
</figure>

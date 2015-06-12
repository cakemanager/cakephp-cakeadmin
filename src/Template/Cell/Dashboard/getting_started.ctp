<h4>Getting Started</h4>
<ul>
    <?php foreach ($list as $title => $item): ?>

        <li>
            <a href="<?= $item['url'] ?>" target="_blank"><?= $title ?></a>
            <ul>
                <li><?= $item['description'] ?></li>
            </ul>
        </li>

    <?php endforeach; ?>
</ul>
<hr>
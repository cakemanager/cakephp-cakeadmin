<?php

?>
<?php foreach ($notifications as $notification): ?>
    <ul>
        <li>
            <?php if ($notification->unread): echo '<b>'; endif; ?>
            <?= h($notification->get('title')) ?>
            <?php if ($notification->unread): echo '</b>'; endif; ?>
            <ul>
                <li><?= h($notification->get('body')) ?></li>
                <li> <?= h($notification->get('created')->timeAgoInWords([
                        'accuracy' => ['month' => 'month'],
                        'end' => '1 year'
                    ])) ?></li>
            </ul>
        </li>
    </ul>
<?php endforeach ?>
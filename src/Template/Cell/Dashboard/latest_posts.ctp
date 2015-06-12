<?php

use Cake\I18n\Time;
?>
<h4>Latest Posts</h4>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="<?= $post['link'] ?>" target="_blank"><?= $post['title'] ?></a>
            <ul>
                <?php $time = new Time($post['pubDate']); ?>
                <li><?= "Author: " . $post['dc:creator'] . " | " . $time->timeAgoInWords() ?></li>
            </ul>
        </li>

    <?php endforeach; ?>
</ul>
<hr>
Read more at <a href="http://cakemanager.org">cakemanager.org</a>.
<br><br>
<a href="https://twitter.com/CakeManager" target="_blank" class="twitter-follow-button" data-show-count="false">Follow @CakeManager</a>
<hr>
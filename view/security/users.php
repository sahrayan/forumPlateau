<?php
$users = $result["data"]["users"];

foreach ($users as $user) { ?>
    <p><?= $user->getPseudo() ?></p>
    <?php if ($user->getBan() == 0) { ?>
       <?php $p=$user->getBan(); ?>
       <?php var_dump($p); ?>
        <form action="index.php?ctrl=forum&action=banUser&id=<?= $user->getId() ?>" method="POST">
            <button type="submit" name="ban">Ban</button>
        </form>
    <?php } else { ?>
        <form action="index.php?ctrl=forum&action=unbanUser&id=<?= $user->getId() ?>" method="POST">
            <button type="submit" name="unban">UnBan</button>
        </form>
    <?php } ?>
<?php } ?>
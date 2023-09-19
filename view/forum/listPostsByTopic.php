<?php

$posts = $result["data"]['posts'];
$topics = $result["data"]['topics'];
$categoryId = $_GET['id'];
    
?>

<h1>Tous les Posts</h1>

<?php
if (!empty($posts)) {
    foreach ($posts as $post) {
        ?>
        <p><?= $post->getText() ?> <?= $post->getDatePost() ?>
            <form action="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>" method="POST">
                <button type="submit" name="submit">Supprimer</button>
            </form>
        </p>
        <?php
    }
} else {
    echo "Il n'y a pas de post pour le moment.";
}
?>

<p>Ajouter un Post</p>

<form action="index.php?ctrl=forum&action=addPost&id=<?= $id ?>" method="POST">
    <label>Texte</label>
    <input type="text" name="text" id="text">
    <button type="submit" name="submit">Ajouter</button>
</form>


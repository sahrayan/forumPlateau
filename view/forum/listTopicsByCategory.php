<?php

$topics = $result["data"]['topics'];
$categories = $result["data"]["categories"];
// $category = $_GET['id'];
    
?>

<h1>Liste sujets</h1>

<?php
if (!empty($topics)) {
    foreach ($topics as $topic) { ?>
        <p><a href="index.php?ctrl=forum&action=ListPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic->getTopicName() ?></a><a><?= $topic->getTopicDate() ?></a>
            <form action="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>" method="POST">
                <button type="submit" name="submit">Supprimer</button>
            </form>
        </p>
    <?php
    }
} else {
    echo "Il n'y a pas de sujet pour le moment.";
}
?>

<p>Ajouter un Sujet</p>

<form action="index.php?ctrl=forum&action=addTopic&id=<?= $id ?>" method="POST">
    <label></label>
    <input type="text" name="topicName">
    <button type="submit" name="submit">Ajouter</button>
</form>


  
   
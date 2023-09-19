<?php
$categories=$result["data"]["categories"];
?>
<h1>Catégories</h1>
<?php

foreach($categories as $categorie)
{?>
   <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $categorie->getId()?>"><?= $categorie->getCategoryName() ?></a>
   <form action="index.php?ctrl=forum&action=deleteCategory&id=<?= $categorie->getId()?> " method = POST >
      <button type ="submit" name= "submit">Supprimer</button>
   </form></p>

<?php } ?>

<p>Ajouter une Catégorie</p>

<form action="index.php?ctrl=forum&action=addCategory" method = POST>
   <label ></label>
   <input type="text" name="categoryName" >
   <button type ="submit" name="submit">Ajouter</button>

</form>
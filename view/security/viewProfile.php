<?php
// Assurez-vous que l'utilisateur est connecté et que ses informations sont disponibles
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    ?>

    <h1>Profil de <?= $user->getPseudo() ?></h1>
    <p>Nom : <?= $user->getNom() ?></p>
    <p>Prénom : <?= $user->getPrenom() ?></p>
    <p>Email : <?= $user->getEmail() ?></p>
    <!-- Vous pouvez afficher d'autres informations de l'utilisateur ici -->
    <?php
} else {
    // Si l'utilisateur n'est pas connecté, vous pouvez afficher un message ou le rediriger vers la page de connexion.
    echo "Vous n'êtes pas connecté. Veuillez vous connecter pour accéder à votre profil.";
}
?>

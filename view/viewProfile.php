<?php
// Assurez-vous que l'utilisateur est connecté et que ses informations sont disponibles
if (isset($_SESSION['user']) && $_SESSION['user'] instanceof \Model\Entities\User) {
    $user = $_SESSION['user'];
    ?>

    <h1>Profil de <?= $user->getPseudo() ?></h1>
    <p>Email : <?= $user->getEmail() ?></p>
    
    <?php
    // Vérifiez si l'âge de l'utilisateur est disponible
    if ($user->getAge()) {
        ?>
        <p>Âge : <?= $user->getAge() ?></p>
        <?php
    }
    // Vous pouvez afficher d'autres informations de l'utilisateur ici
} else {
    // Si l'utilisateur n'est pas connecté ou que les informations ne sont pas disponibles, vous pouvez afficher un message ou le rediriger vers la page de connexion.
    echo "Vous n'êtes pas connecté. Veuillez vous connecter pour accéder à votre profil.";
}
?>

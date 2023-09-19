<div id="user-profile">
    <h2>Mon Profil</h2>
    <p><strong>Pseudo:</strong> <?= App\Session::getUser() ?></p>
    <p><strong>Email:</strong> <?= App\Session::getEmail() ?></p>
    <p><strong>Date de création du compte:</strong> <?= App\Session::getRegistrationDate() ?></p>
</div>

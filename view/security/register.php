
<p>S'inscrire</p>


<form action="index.php?ctrl=Security&action=register" method = POST>

    <label >Pseudo</label>
    <input type ="text" name="pseudo" required>

    <label >Email</label>
    <input type ="email" name="email" required placeholder="....@....">
    
    <label >Mot de Passe</label>
    <input type="password" name="password"  required placeholder="*****">

    <label >Confirmer du mot de Passe</label>
    <input type="password" name="confirmPassword"  required placeholder="*****">
    
    <input type="submit" name="submit" >
    

</form>

<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{

        private $id;
        private $registrationDate;
        private $pseudo;
        private $password;
        private $role;
        private $email;
        private $ban;
    
        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of RegistrationDate
         */ 
        
        public function getRegistrationDate(){
            $registDate = $this->registrationDate->format("d/m/Y, H:i:s");
            return $registDate;
        }
        /**
         * Set the value of RegistrationDate
         *
         * @return  self
         */ 
       

        public function setRegistrationDate($registartionDate){
            $this->registrationDate = new \DateTime($registartionDate);
            return $this;
        }


        /**
         * Get the value of pseudo
         */ 
        public function getPseudo()
        {
                return $this->pseudo;
        }

        /**
         * Set the value of pseudo
         *
         * @return  self
         */ 
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;

                return $this;
        }

        public function __toString()
        {
                return $this->pseudo;
        }


          /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

       
        /**
         * Get the value of role
         */ 
	public function getRole()
	{
		return json_decode($this->role);
	}

 

	/**
	 * Set the value of role
	 *
	 * @return  self
	 */
	public function setRole($role)
	{
		$this->role = json_encode($role);

 

		return $this;
	}

 

	public function hasRole($role)
	{
		$result = $this->getRole() == json_encode($role);
		return $result;
	}

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }



    public function getBan()
        {
                // la logique
                return $this->ban;
        }
        // Dans la classe Model\Entities\User

        public function updatePassword($newPassword)
        {
                // Vous devez sécuriser le mot de passe ici (hachage, salage, etc.)
                // Par exemple, vous pouvez utiliser password_hash pour hacher le nouveau mot de passe.
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Enregistrez le nouveau mot de passe dans la base de données ou dans votre système de stockage de données.
                // Par exemple, si vous utilisez une classe UserManager, vous pouvez appeler sa méthode pour mettre à jour le mot de passe.
                $userManager = new UserManager();
                $userManager->updatePassword($this->id, $hashedPassword);

                // Vous pouvez également mettre à jour la propriété $password de l'objet User si nécessaire.
                $this->password = $hashedPassword;
    
                // Vous pouvez renvoyer un message de succès ou une indication que le mot de passe a été mis à jour avec succès.
        return "Mot de passe mis à jour avec succès";
}


    
    
}
    
    
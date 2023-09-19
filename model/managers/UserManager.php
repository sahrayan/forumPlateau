<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    //  use Model\Managers\UserManager;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        public function findOneByEmail($email){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.email = :email";
                    

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

        public function findOneByPseudo($pseudo){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.pseudo = :pseudo";
                    

            return $this->getOneOrNullResult(
                DAO::select($sql, ['pseudo' => $pseudo], false), 
                $this->className
            );
        }

        public function retrievePassword($email){

            $sql = "SELECT password
            FROM user u
            WHERE u.email = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

        // public function findOneByEmail($email){

        //     $sql = "SELECT pseudo
        //     FROM user u
        //     WHERE u.email = :email";

        //     return $this->getOneOrNullResult(
        //         DAO::select($sql, ['email' => $email], false), 
        //         $this->className
        //     );
        // }

        public function ban($id){
            $sql = "UPDATE user
                    SET ban = 1
                    WHERE id_user = :id
                    ";

            return DAO::update($sql, ['id' => $id]); 
        }

        }
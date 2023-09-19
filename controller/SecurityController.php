<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;

    
    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){}

        public function toRegister(){
            return [
                "view" => VIEW_DIR."security/register.php"              
            ];
        }

        public function toLogin(){
            return [
                "view" => VIEW_DIR."security/login.php"              
            ];
        }
    

        public function register(){
            $userManager = new UserManager();

            var_dump("test");
            if(isset ($_POST['submit']) ){  // Vérifie si le formulaire a été soumis
                // Récupération et validation des données utilisateur
                $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
               
                // Vérification des données entrées par l'utilisateur
                if ($pseudo && $email && $password && $confirmPassword){
                    $userManager = new UserManager();
                    // Vérification que l'adresse e-mail n'est pas déjà utilisée
                    if (!$userManager->findOneByEmail($email)){
                        var_dump("test");
                        // Vérification que le pseudo n'est pas déjà utilisé
                        if (!$userManager->findOneByPseudo($pseudo)){
                            // Vérification que le mot de passe correspond à la confirmation et est suffisamment long
                            (($password == $confirmPassword) && strlen($password) > 7 );
                            // Hachage du mot de passe
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);                 
                        }
                        // Ajout de l'utilisateur à la base de données,
                    $user = $userManager->add([
                        "pseudo" => $pseudo,
                        "email"=>$email, 
                        "password"=> $hashedPassword,
                        "role"=> json_encode(["ROLE_USER"]),
                        
                    ]);
                                       
                    return[
                        "view" => VIEW_DIR . "security/login.php"
                    ];
                    }
                }
                
            }
            
        }

        public function login(){
            $userManager = new UserManager();
            $categoryManager = new CategoryManager();

            if(isset($_POST['submit'])){
                $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password= filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                if($email && $password){
                    // retrouver le mot de passe de l'utilisateur correspondant au mail
                    $dbPass= $userManager->retrievePassword($email);
                    var_dump("test");
                    // si le mot de passe retrouvé
                    if($dbPass){
                        // récupération du mot de passe
                        $hash= $dbPass->getPassword();
                        // retrouver l'utilisateur par son email
                        $user= $userManager->findOneByEmail($email);
                        // comparaison du hash de la base de données et le mot de passe renseigné
                        if(password_verify($password, $hash)){
                            // si l'utilisateur n'est pas banni 
                            Session::setUser($user);
                            // if($user->getStatus()){
                            // placer l utilisateur en Session 
                            // Session::setUser($user);
                            // }
                            // App\Session::isAdmin()
                            return [
                                "view" => VIEW_DIR."forum/listCategories.php",
                                "data" => [ "categories" => $categoryManager->findAll(["categoryName", "ASC"])
                               
                                ]
                            ];
                            Session::getFlash("success");
                        }
                    }

                }

            }

        }
            
        public function logout(){
            $user = null;
            Session::setUser($user);
        
            // Instanciez le gestionnaire de catégorie ici
            $categoryManager = new CategoryManager();
        
            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [ "categories" => $categoryManager->findAll(["categoryName", "ASC"]) ]
            ];
        }                   
         

        


    }











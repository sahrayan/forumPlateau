<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CategoryManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface
{
    // Méthode pour afficher la liste des catégories
    public function ListCategories()
    {
        $categoryManager = new CategoryManager();
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->findAll(["categoryName", "ASC"])
            ]
        ];
    }

    // Méthode pour afficher la liste des sujets par catégorie
    public function listTopicsByCategory($id)
    {
        if (isset($_SESSION['user'])) {
            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();
    
            return [
                "view" => VIEW_DIR . "forum/listTopicsByCategory.php",
                "data" => [
                    "topics" => $topicManager->topicByCategory($id),
                    "categories" => $categoryManager->findOneById($id)
                ]
            ];
        } else {
            $_SESSION["error"] = "Vous devez vous connecter pour voir la liste";
            $this->redirectTo('forum', 'listCategories');                
        }
    }

    // Méthode pour afficher la liste des messages par sujet
    public function listPostsByTopic($id)
    {
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $locked = '0';
        $statut = $topicManager->findOneById($id)->getLocked();
        
        if ($_SESSION['user'] && $locked == $statut) {
            return [
                "view" => VIEW_DIR . "forum/listPostsByTopic.php",
                "data" => [
                    "posts" => $postManager->postByTopic($id),
                    "topics" => $topicManager->findOneById($id)
                ]
            ];
        } else {
            if ($statut == '1') {
                $_SESSION["error"] = "Le sujet est verrouillé";
                $this->redirectTo('forum', 'listCategories');
            } else {                          
                $_SESSION["error"] = "Vous devez vous connecter pour voir la liste";
                $this->redirectTo('forum', 'listCategories');                
            }
        }
    }

    
    // Méthode pour ajouter une catégorie
    public function addCategory()
    {
        // Vérifiez si l'utilisateur est connecté et a le rôle d'administrateur
    if (isset($_SESSION['user']) && $_SESSION['user']->getRole() == 'admin') {
        $categoryManager = new CategoryManager();
        $categoryName = filter_input(INPUT_POST, "categoryName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($categoryName) {
            // Ajoutez la nouvelle catégorie à la base de données
            $newCategory = $categoryManager->add(["categoryName" => $categoryName]);
            $this->redirectTo('forum', 'listCategories', $newCategory);
        }
    } else {
        $_SESSION["error"] = "Vous n'avez pas l'autorisation d'ajouter une Catégorie";
        $this->redirectTo('forum', 'listCategories');
    }
    }

    

    // Méthode pour ajouter un sujet
    public function addTopic($id)
    {
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $idcategory = $categoryManager->findOneById($id)->getId();
        $userManager = new UserManager();
        
        // Vérifiez si l'utilisateur est connecté
        if (isset($_SESSION['user']) && isset($_POST['submit']) && !$_SESSION['user']->getRole() == 'admin') {
            $idUser = $_SESSION['user']->getId();
            $locked = 0;
            $topicName = filter_input(INPUT_POST, "topicName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($topicName) {
                // Ajoutez le nouveau sujet à la base de données
                $newTopic = $topicManager->add(['topicName' => $topicName, 'category_id' => $idcategory, 'user_id' => $idUser, 'locked' => 0]);
                $this->redirectTo('forum', 'listCategories', $newTopic);
            }
        } else { 
            $_SESSION["error"] = "Vous êtes Banni ou n'avez pas l'autorisation de créer un sujet";
            $this->redirectTo('forum', 'listCategories');
        }
    }
    

// Méthode pour ajouter un message
public function addPost($id)
{
    $postManager = new PostManager();
    $topicManager = new TopicManager();
    $idTopic = $topicManager->findOneById($id)->getId();
    
    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['user'])) {
        $idUser = $_SESSION['user']->getId();
        $postContent = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Vérifiez si l'utilisateur est banni
        if ($_SESSION['user']->getBan() == 0 || $_SESSION['user']->getRole() == 'admin') {
            if ($postContent) {
                $newPost = $postManager->add(["text" => $postContent, "topic_id" => $idTopic, "user_id" => $idUser]);
                $this->redirectTo('forum', 'listCategories', $newPost);
            }
        } else { 
            $_SESSION["error"] = "Vous êtes Banni";
            $this->redirectTo('forum', 'listCategories');
        }
    } else { 
        $_SESSION["error"] = "Vous devez vous connecter pour ajouter un message";
        $this->redirectTo('forum', 'listCategories');
    }
}


    // Méthode pour supprimer un sujet
    public function deleteTopic($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $pseudo = $topic->getUser()->getPseudo();
        $user = $_SESSION['user']->getPseudo();
        
        // Vérifiez si l'utilisateur est l'auteur du sujet ou un administrateur
        if ($pseudo == $user || $_SESSION['user']->getRole() == 'admin') {
            $topicManager->delete($id);
        } else {
            $_SESSION["error"] = "Vous n'êtes pas autorisé";
        }
        
        $this->redirectTo('forum', "listCategories", $topic);
    }
    

    // Méthode pour supprimer un message
    public function deletePost($id)
    {
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);
        $pseudo = $post->getUser()->getPseudo();
        $user = $_SESSION['user']->getPseudo();
        
        // Vérifiez si l'utilisateur est l'auteur du message ou un administrateur
        if ($pseudo == $user || $_SESSION['user']->getRole() == 'admin') {
            $postManager->delete($id);
        } else {
            $_SESSION["error"] = "Vous n'êtes pas autorisé";
        }
        
        $this->redirectTo('forum', "listCategories", $post);
    }
    // Méthode pour supprimer une catégorie
    public function deleteCategory($id)
    {
        // Vérifiez si l'utilisateur est connecté et a le rôle d'administrateur
        if (isset($_SESSION['user']) && $_SESSION['user']->getRole() == 'admin') {
            $categoryManager = new CategoryManager();
            $category = $categoryManager->findOneById($id);

        if ($category) {
            // Supprimez la catégorie de la base de données
            $categoryManager->delete($id);
        } else {
            $_SESSION["error"] = "La catégorie spécifiée n'existe pas.";
        }
    } else {
        $_SESSION["error"] = "Vous n'avez pas l'autorisation de supprimer une catégorie.";
    }

    $this->redirectTo('forum', 'listCategories');
}

    

}

    
    










    
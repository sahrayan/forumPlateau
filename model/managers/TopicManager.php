<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }

    public function topicByCategory($id)
    {

        $sql = "SELECT id_topic, topicName, topicDate
                         
        FROM topic
       
        WHERE topic.category_id = :id
       
        ORDER BY topic.topicDate DESC";


        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }
    public function findOneById($id){

        $sql = "SELECT *
                FROM ".$this->tableName." a
                WHERE a.id_".$this->tableName." = :id
                ";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), 
            $this->className
        );
    }

  



    }

    
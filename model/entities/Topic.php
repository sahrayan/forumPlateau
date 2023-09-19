<?php
    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private $id;
        private $topicName;
        private $topicDate;
        private $user;
        private $category;
        private $locked;

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
         * Get the value of topicName
         */ 
        public function getTopicName()
        {
                return $this->topicName;
        }

        /**
         * Set the value of topicName
         *
         * @return  self
         */ 
        public function setTopicName($topicName)
        {
                $this->topicName = $topicName;

                return $this;
        }
        
        public function __toString()
        {
                return $this->topicName;
        }
        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }


          /**
         * Get the value of category
         */ 
        public function getCategory()
        {
                return $this->category;
        }

        /**
         * Set the value of category
         *
         * @return  self
         */ 
        public function setCategory($category)
        {
                $this->category = $category;

                return $this;
        }

        public function getTopicDate(){
            $formattedDate = $this->topicDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setTopicDate($topicDate){
            $this->topicDate = new \DateTime($topicDate);
            return $this;
        }

        /**
         * Get the value of locked
         */ 
        public function getLocked()
        {
                return $this->locked;
        }

        /**
         * Set the value of locked
         *
         * @return  self
         */ 
        public function setLocked($locked)
        {
                $this->locked = $locked;

                return $this;
        }
    }

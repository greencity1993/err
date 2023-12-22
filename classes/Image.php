<?php
    require_once "Entity.php";

    class Image extends Entity {

        public $id;
        public $original_name;
        public $unique_name;
        public $title;
        public $description;
        public $creator;
        public $country;
        public $caption_abstract;
        public $object_name;

      

        public function getOriginalName(){
            return $this->original_name;
        }

        public function setOriginalName($originalName){
            $this->original_name = $originalName;
        }

        public function generteUniqueName() {
            $this->unique_name = sha1_file('/var/www/html/uploads/' . $this->original_name) . time();
        } 

        public function getUniqueName(){
            return $this->unique_name;
        }

        public function setUniqueName($uniqueName){
            $this->unique_name = $uniqueName;
        }

        public function getTitle(){
            return $this->title;
        }

        public function setTitle($title){
            $this->title = $title;
        }

        public function getDescription(){
            return $this->description;
        }

        public function setDescription($description){
            $this->description = $description;
        }

        public function getCreator(){
            return $this->creator;
        }

        public function setCreator($creator){
            $this->creator = $creator;
        }

        public function getCountry(){
            return $this->country;
        }

        public function setCountry($country){
            $this->country = $country;
        }

        public function getCaptionAbstract(){
            return $this->caption_abstract;
        }

        public function setCaptionAbstract($captionAbstract){
            $this->caption_abstract = $captionAbstract;
        }

        public function getObjectName(){
            return $this->object_name;
        }

        public function setObjectName($objectName){
            $this->object_name = $objectName;
        }


  }

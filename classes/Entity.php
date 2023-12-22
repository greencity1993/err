<?php
    require_once 'Database.php';

    abstract class Entity {

        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
            $this->db->getConnection();
        }


        public function save() {

            $class = new \ReflectionClass($this);
            $tableName = strtolower($class->getShortName());

            $propsToImplode = [];
            $dataToImplode = [];

            foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                $propertyName = $property->getName();
                $propsToImplode[] = '`'.$propertyName.'` = ?';
                $dataToImplode[] = $this->{$propertyName};
            }


            $setClause = implode(',',$propsToImplode);


            $sqlQuery = '';

            if ($this->id > 0) {
                $sqlQuery = 'UPDATE `'.$tableName.'` SET '.$setClause.' WHERE id = '.$this->id;
            } else {
                $sqlQuery = 'INSERT INTO `'.$tableName.'` SET '.$setClause;
            }

            $stmt = $this->db->prepare($sqlQuery);
            $stmt->execute($dataToImplode);


        }


        public function morph(array $object) {
            $class = new \ReflectionClass(get_called_class());
            $entity = $class->newInstance();

            foreach($class->getProperties() as $prop) {
                if (isset($object[$prop->getName()])) {
                    $prop->setValue($entity,$object[$prop->getName()]);
                }
            }

            return $entity;
        }



        public function find($param, $value) {
            $query = 'SELECT * FROM `image` ' .  'WHERE ' . $param . " = \"" . $value . "\"";
            $raw = $this->db->sendQuerry($query);

            $result = false;

            foreach ($raw as $rawRow) {
                $result = $this->morph($rawRow);
            }

            return $result;
        }


    }
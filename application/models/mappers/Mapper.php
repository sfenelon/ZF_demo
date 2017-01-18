<?php

abstract class Application_Model_Mapper_Mapper {

    /**
     * @var \Zend_Db_Table_Abstract
     */
    protected $table;

    /**
     * @var Mapper
     */
    protected static $instances;

    /**
     * @return \Zend_Db_Table_Abstract
     */
    protected abstract function getDbTable();

    /**
     * @param array $data
     * @return \Application\Models\Entity
     */
    protected abstract function createEntityClass(array $data);

    public function __construct() {
        $this->table = $this->getDbTable();
    }

    public static function instance() {
        if (!isset(self::$instances)) {
            self::$instances = array();
        }
        $cls = get_called_class();
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }
        return self::$instances[$cls];
    }

    /**
     * @param $id
     * @return \Application\Models\Entity
     */
    public function get($id) {
        if (empty($id)) {
            return null;
        }
        $result = $this->table->find($id);
        if (empty($result) || count($result) != 1) {
            return null;
        }
        return $this->createEntityClass($result->current()->toArray());
    }

    /**
     * @return \Application\Models\Entity[]
     */
    public function getAll() {
        $resultSet = $this->table->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entries[] = $this->createEntityClass($row->toArray());
        }
        return $entries;
    }


    /**
     * @param $id
     * @return \Application\Models\Entity|null
     * convenience method to grab one of the object that the subclass maps to.
     */
    public static function fetchOne($id) {
        return self::instance()->get($id);
    }

    /**
     * @return \Application\Models\Entity[]
     * convenience method to grab all instances of an object that the subclass maps to.
     */
    public static function fetchAll() {
        return self::instance()->getAll();
    }

}


<?php

class Application_Model_DbTable_CountryTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'Country';
    protected $_primary = 'Code'; // unique 3-char code
}

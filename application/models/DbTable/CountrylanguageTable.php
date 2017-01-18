<?php

class Application_Model_DbTable_CountrylanguageTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'CountryLanguage';
    
    // primary key is CountryCode + Language
}

<?php
class Application_Model_City extends Application_Model_Entity
{
    protected $_id;  
    protected $_name;
    protected $_countrycode;
    protected $_district;
    protected $_population;
    
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName($text)
    {
        $this->_name = (string) $text;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setCountrycode($text)
    {
        $this->_countrycode = (string) $text;
        return $this;
    }

    public function getCountrycode()
    {
        return $this->_countrycode;
    }

    public function setDistrict($text)
    {
        $this->_district = (string) $text;
        return $this;
    }

    public function getDistrict()
    {
        return $this->_district;
    }
    
    public function setPopulation($int)
    {
        $this->_population = (int) $int;
        return $this;
    }

    public function getPopulation()
    {
        return $this->_population;
    }
    
}
<?php

class Application_Model_Countrylanguage extends Application_Model_Entity
{
    protected $_countrycode;
    protected $_language;
    protected $_isofficial;
    protected $_percentage;
    
    public function setCountrycode($text)
    {
        $this->_countrycode = (string) $text;
        return $this;
    }

    public function getCountrycode()
    {
        return $this->_countrycode;
    }

    public function setLanguage($text)
    {
        $this->_language = (string) $text;
        return $this;
    }

    public function getLanguage()
    {
        return $this->_language;
    }
    
    public function setIsofficial($char)
    {
        $this->_isofficial = $char;
        return $this;
    }

    public function getIsofficial()
    {
        return $this->_isofficial;
    }
    
    public function setPercentage($float)
    {
        $this->_percentage = $float;
        return $this;
    }

    public function getPercentage()
    {
        return $this->_percentage;
    }
}
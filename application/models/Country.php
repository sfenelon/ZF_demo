<?php

class Application_Model_Country extends Application_Model_Entity
{
    protected $_code;  // 3-char, primary key, must be provided on insert, must be unique
    protected $_name;
    protected $_continent;
    protected $_region;
    protected $_surfacearea;
    protected $_indepyear;
    protected $_population;
    protected $_lifeexpectancy;
    protected $_gnp;
    protected $_gnpold;
    protected $_localname;
    protected $_governmentform;
    protected $_headofstate;
    protected $_capital;  // int id of capital city
    protected $_code2;
    
    
    /**
     * single city object
     */
    protected $capitalcity = null;
    
    /**
     * array of City Objects in this country
     */
    protected $cities = array();

    /**
     * array of Countrylanguage Objects in this country
     */
    protected $languages = array();
    
    
   /* public function toArray() 
    {
        $dataArr = Application_Model_Mapper_CountryMapper::instance()->toArray($this);
    }
    */
    /**
     * Return Model_City for capital city
     */
    public function getCapitalcity()
    {
        if ($this->capitalcity == null) {
            $this->capitalcity = Application_Model_Mapper_CityMapper::instance()->fetchOne($this->getCapital());
        }
        return $this->capitalcity;
    }
    
    /**
     * Return array of city names
     */
    public function getCitylist()
    {
        $list = array();
        $cities = $this->getCities();
        foreach ($cities as $c) {
            $list[] = $c->getName();
        }
        return $list;
    }
    
    /**
     *  Return array of City Objects
     */
    public function getCities()
    {
        if (empty($this->cities)) {
            // fetch the objects
            $this->cities = Application_Model_Mapper_CityMapper::instance()->fetchCityNamesInCountry($this->getCode());
        }
        return $this->cities;
    }
    
    /**
     * Return array of Languages
     */
    public function getLanguagelist()
    {
        $list = array();
        $languages = $this->getLanguages();
        foreach ($languages as $l) {
            $list[] = $l->getLanguage();
        }
        return $list;
    }
    
    /*
     * Return array of CountryLanguages Objects
     */
    public function getLanguages()
    {
        if (empty($this->languages)) {
            // fetch the objects
            $this->languages = Application_Model_Mapper_CountrylanguageMapper::instance()->fetchLanguagesInCountry($this->getCode());
        }
        return $this->languages;
    }
    
    public function setCode($text)
    {
        $this->_code = (string) $text;
        return $this;
    }

    public function getCode()
    {
        return $this->_code;
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

    public function setContinent($text)
    {
        $this->_continent = $text;
        return $this;
    }

    public function getContinent()
    {
        return $this->_continent;
    }

    public function setRegion($text)
    {
        $this->_region = (string) $text;
        return $this;
    }

    public function getRegion()
    {
        return $this->_region;
    }
    
    public function setSurfaceArea($float)
    {
        $this->_surfacearea = $float;
        return $this;
    }

    public function getSurfaceArea()
    {
        return $this->_surfacearea;
    }

    public function setIndepYear($int)
    {
        $this->_indepyear = (int) $int;
        return $this;
    }

    public function getIndepYear()
    {
        return $this->_indepyear;
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

    public function setLifeExpectancy($float)
    {
        $this->_lifeexpectancy = $float;
        return $this;
    }

    public function getLifeExpectancy()
    {
        return $this->_lifeexpectancy;
    }

    public function setGNP($float)
    {
        $this->_gnp = $float;
        return $this;
    }

    public function getGNP()
    {
        return $this->_gnp;
    }
    
    public function setGNPOld($float)
    {
        $this->_gnpold = $float;
        return $this;
    }

    public function getGNPOld()
    {
        return $this->_gnpold;
    }
    
    public function setLocalName($text)
    {
        $this->_localname = (string) $text;
        return $this;
    }

    public function getLocalName()
    {
        return $this->_localname;
    }
    
    public function setGovernmentForm($text)
    {
        $this->_governmentform = (string) $text;
        return $this;
    }

    public function getGovernmentForm()
    {
        return $this->_governmentform;
    }
    
    public function setHeadOfState($text)
    {
        $this->_headofstate = (string) $text;
        return $this;
    }

    public function getHeadOfState()
    {
        return $this->_headofstate;
    }
   
    public function setCapital($int)
    {
        $this->_capital = (int) $int;
        return $this;
    }

    public function getCapital()
    {
        return $this->_capital;
    }

   
    public function setCode2($text)
    {
        $this->_code2 = (string) $text;
        return $this;
    }

    public function getCode2()
    {
        return $this->_code2;
    }
    
    
}


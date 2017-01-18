<?php

class Application_Model_Mapper_CountryMapper extends Application_Model_Mapper_Mapper
{
    const CODE = 'Code';
    const NAME = 'Name';
    const CONTINENT = 'Continent';
    const REGION = 'Region';
    const SURFACEAREA = 'SurfaceArea';
    const INDEPYEAR = 'IndepYear';
    const POPULATION = 'Population';
    const LIFEEXPECTANCY = 'LifeExpectancy';
    const GNP = 'GNP';
    const GNPOLD = 'GNPOld';
    const LOCALNAME = 'LocalName';
    const GOVERNMENTFORM = 'GovernmentForm';
    const HEADOFSTATE = 'HeadOfState';
    const CAPITAL = 'Capital';
    const CODE2 = 'Code2';
    
    protected function getDataMap(Application_Model_Country $country)
    {
        return array(
            self::CODE => $country->getCode(),
            self::NAME => $country->getName(),
            self::CONTINENT => $country->getContinent(),
            self::REGION => $country->getRegion(),
            self::SURFACEAREA => $country->getSurfaceArea(),
            self::INDEPYEAR => $country->getIndepYear(),
            self::POPULATION => $country->getPopulation(),
            self::LIFEEXPECTANCY => $country->getLifeExpectancy(),
            self::GNP => $country->getGNP(),
            self::GNPOLD => $country->getGNPOld(),
            self::LOCALNAME => $country->getLocalName(),
            self::GOVERNMENTFORM => $country->getGovernmentForm(),
            self::HEADOFSTATE => $country->getHeadOfState(),
            self::CAPITAL => $country->getCapital(),
            self::CODE2 => $country->getCode2(),
        );
        
    }
    
    protected function getDbTable()
    {
        return new Application_Model_DbTable_CountryTable;
    }

    protected function createEntityClass(array $data) {
        return new Application_Model_Country($data);
    }
    
    public function insert(Application_Model_Country $country)
    {
        $data = $this->getDataMap($country);
        $this->table->insert($data);
        return $country;
    }
    
    public function update(Application_Model_Country $country) {
        $data = $this->getDataMap($country);
        return $this->table->update($data, array(self::CODE . '=?' => $country->getCode()));
    }
    
    public function remove($code) {
        $this->table->delete(
            $this->table->getAdapter()->quoteInto(self::CODE . "=?",$code)
        );
    }
    
/*
    public function find($code, Application_Model_Country $country)
    {
        $result = $this->getDbTable()->find($code);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $country->setCode($row->Code)
                ->setContinent($row->Continent)
                ->setRegion($row->Region)
                ->setSurfacearea($row->SurfaceArea)
                ->setIndepyear($row->IndepYear)
                ->setPopulation($row->Population)
                ->setLifeexpectancy($row->LifeExpectancy)
                ->setGnp($row->GNP)
                ->setGnpold($row->GNPOld)
                ->setLocalname($row->LocalName)
                ->setGovernmentform($row->GovernmentForm)
                ->setHeadofstate($row->HeadOfState)
                ->setCapital($row->Capital)
                ->setCode2($row->Code2);
    }
*/

    /**
     * Fetch all countries.
     * @param $orderclause - column ASC|DESC 
     *        Ex: 'population ASC'
     * @return Country[]
     */
    public function fetchAllByOrder($orderclause = '')
    {
        if ($orderclause == '') {
            $resultSet = $this->table->fetchAll();
        } else {
            $select = $this->table->select()->order($orderclause);
            $resultSet = $this->table->fetchAll($select);
        }

        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = new Application_Model_Country($row->toArray());
        }
        return $entries;
    }
    
    public function toArray(Application_Model_Country $country)
    {
        return($this->getDataMap($country));
        
    }    
}


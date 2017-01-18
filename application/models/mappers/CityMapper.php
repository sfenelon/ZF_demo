<?php

class Application_Model_Mapper_CityMapper extends Application_Model_Mapper_Mapper
{
    const ID = 'ID';
    const NAME = 'Name';
    const COUNTRYCODE = 'CountryCode';
    const DISTRICT = 'District';
    const POPULATION = 'Population';
    
    protected function getDataMap(Application_Model_City $city)
    {
        return array(
            self::NAME => $city->getName(),
            self::COUNTRYCODE => $city->getCountrycode(),
            self::DISTRICT => $city->getDistrict(),
            self::POPULATION => $city->getPopulation(),
        );
    }
    
    protected function getDbTable()
    {
        return new Application_Model_DbTable_CityTable;
    }
    
    protected function createEntityClass(array $data) 
    {
        return new Application_Model_City($data);
    }
    
    public function insert(Application_Model_City $city)
    {
        $data = $this->getDataMap($city);
        $newId = $this->table->insert($data);
        $city->setId($newId);
        return $city;
    }
    
    public function update(Application_Model_City $city) {
        $data = $this->getDataMap($city);
        return $this->table->update($data, array(self::CODE . '=?' => $city->getId()));
    }
    
    public function remove($id) {
        $this->table->delete(
            $this->table->getAdapter()->quoteInto(self::ID . "=?",$id)
        );
    }
    
   /**
     * Return array of city object for a given country.
     * @param $countrycode 
     * @return array of Application_Model_City
     */
    public function fetchCityNamesInCountry($countrycode = '')
    {
        $select = $this->table->select(self::NAME)->where(self::COUNTRYCODE . ' = ?', $countrycode);
        $resultSet = $this->table->fetchAll($select);

        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = new Application_Model_City($row->toArray());
        }
        return $entries;
        
    }
}
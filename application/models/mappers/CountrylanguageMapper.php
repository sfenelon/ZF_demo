<?php
class Application_Model_Mapper_CountrylanguageMapper extends Application_Model_Mapper_Mapper
{
    const COUNTRYCODE = 'CountryCode';
    const LANGUAGE = 'Language';
    const ISOFFICIAL = 'IsOfficial';
    const PERCENTAGE = 'Percentage';
    
    protected function getDataMap(Application_Model_Countrylanguage $colang)
    {
        return array(
            self::COUNTRYCODE => $colang->getCountrycode(),
            self::LANGUAGE => $colang->getLanguage(),
            self::ISOFFICIAL => $colang->getIsOfficial(),
            self::PERCENTAGE => $colang->getPercentage(),
        );
    }
    
    protected function getDbTable()
    {
        return new Application_Model_DbTable_CountrylanguageTable;
    }
    
    protected function createEntityClass(array $data) 
    {
        return new Application_Model_Country($data);
    }
    
    /**
     * Return array of cities in a given country.
     * @param $countrycode 
     * @return arrary of city names
     */
    public function fetchLanguagesInCountry($countrycode = '')
    {
        $select = $this->table->select()->where(self::COUNTRYCODE . ' = ?', $countrycode);
        $resultSet = $this->table->fetchAll($select);

        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = new Application_Model_Countrylanguage($row->toArray());
        }
        return $entries;
    }
}
    
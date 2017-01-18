<?php
/**
 * World DB demo
 * 
 * @author Sheila Fenelon (sheila@shefen.com)
 *
 */

/**
 * 
 *  Create a form for collecting input for this table:

CREATE TABLE IF NOT EXISTS `Country` (
  `Code` char(3) NOT NULL DEFAULT '',
  `Name` char(52) NOT NULL DEFAULT '',
  `Continent` enum('Asia','Europe','North America','Africa','Oceania','Antarctica','South America') NOT NULL DEFAULT 'Asia',
  `Region` char(26) NOT NULL DEFAULT '',
  `SurfaceArea` float(10,2) NOT NULL DEFAULT '0.00',
  `IndepYear` smallint(6) DEFAULT NULL,
  `Population` int(11) NOT NULL DEFAULT '0',
  `LifeExpectancy` float(3,1) DEFAULT NULL,
  `GNP` float(10,2) DEFAULT NULL,
  `GNPOld` float(10,2) DEFAULT NULL,
  `LocalName` char(45) NOT NULL DEFAULT '',
  `GovernmentForm` char(45) NOT NULL DEFAULT '',
  `HeadOfState` char(60) DEFAULT NULL,
  `Capital` int(11) DEFAULT NULL,
  `Code2` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`Code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


 *  Code is our primary key but the user needs to enter it when adding a new Country.
 *  When editing a record, Code becomes a hidden field.
 *  
 *  The field for Capital city needs extra handling. 
 *  The Model and Table take an int (foreign key to the City table).
 *  When adding a country we want to allow city name to be entered as text.
 *  When editing a country we will display a list of all cities in the country 
 *  as a select-option.
 * 
 */

class Application_Form_Country extends Zend_Form
{

    protected $continents = array('Asia','Europe','North America','Africa','Oceania','Antarctica','South America');
    
    // form elements
    protected $code;  // 3-char, primary key, must be provided on insert, must be unique, must be uppercase alpha
    protected $hiddenCode;  // 3-char, primary key, can not be edited
    protected $name;
    protected $continent;
    protected $region;
    protected $surfacearea;
    protected $indepyear;
    protected $population;
    protected $lifeexpectancy;
    protected $gnp;
    protected $gnpold;
    protected $localname;
    protected $governmentform;
    protected $headofstate;
    protected $capitalSelect;
    protected $capitalName;
    protected $code2;
    protected $submit;

    public function __construct()
    {
        $this->setName("country");
        $this->setMethod('post');
        $this->clearDecorators();
        
        //$this->setDecorators(array('FormErrors'));
        
        $code = $this->createElement('text', 'Code');
        $code->setRequired(true);
        $code->setLabel("Country Code (required):");
        // next line doesn't seem to do anything so added "(required)" to label
        //$code->getDecorator('Label')->setReqSuffix(' *');
        $code->maxLength = 3;
        $code->minLength = 3;
        $code->size = 3;
        $code->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StringToUpper(),
            ));
        $code->addValidator(new Zend_Validate_Alpha);
        $this->code = $code;
        
        $this->hiddenCode = new Zend_Form_Element_Hidden('Code');
        
        $name = $this->createElement('text', 'Name');
        $name->setRequired(true);
        $name->setLabel("Country Name (required):"); 
        $name->maxLength = 52;
        $name->minLength = 3;
        $name->size = 25;
        $name->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        //$name->addValidator(new Zend_Validate_Alpha(true));
        $this->name = $name;
        
        $localname = $this->createElement('text', 'LocalName');
        $localname->setLabel("Local Name:"); 
        $localname->maxLength = 45;
        $localname->size = 25;
        $localname->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $this->localname = $localname;
        
        // when adding a new country we need to enter a name and add a new city too
        $capital = $this->createElement('text', 'CapitalName');
        $capital->setLabel("Capital:"); 
        $capital->maxLength = 35;
        $capital->size = 25;
        $capital->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $this->capitalName = $capital;

        // when editing we show list of cities
        // setup an empty select element, add the cities when populating the form
        // since that's when we know which country we are editing
        $capitalSelect = $this->createElement('select', 'Capital');
        $capitalSelect->setLabel("Capital:");
        $capitalSelect->setRegisterInArrayValidator(false);
        $this->capitalSelect = $capitalSelect;
        
        $code2 = $this->createElement('text', 'Code2');
        $code2->setLabel("Abreviation:");
        $code2->maxLength = 2;
        $code2->minLength = 2;
        $code2->size = 2;
        $code2->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StringToUpper(),
        ));
        $code2->addValidator(new Zend_Validate_Alpha);
        $this->code2 = $code2;
        
        $govtform = $this->createElement('text', 'GovernmentForm');
        $govtform->setLabel("Government Form:"); 
        $govtform->maxLength = 45;
        $govtform->size = 25;
        $govtform->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $this->governmentform = $govtform;
        
        $headofstate = $this->createElement('text', 'HeadOfState');
        $headofstate->setLabel("Head Of State:"); 
        $headofstate->maxLength = 60;
        $headofstate->size = 25;
        $headofstate->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $this->headofstate = $headofstate;
        
        $continent = $this->createElement('select', 'Continent');
        $continent->setRequired(true);
        $continent->setLabel("Continent (required):");
        foreach ($this->continents AS $c) {
            $continent->addMultiOption($c, $c);
        }
        $this->continent = $continent;
        
        $region = $this->createElement('text', 'Region');
        $region->setLabel("Region:"); 
        $region->maxLength = 26;
        $region->size = 25;
        $region->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $this->region = $region;
        
        $sa = $this->createElement('text', 'SurfaceArea');
        $sa->setLabel("Surface Area:"); 
        $sa->maxLength = 10;
        $sa->size = 10;
        $sa->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_PregReplace(array('match' => '/,/', 'replace' => ''))
            ));
        $sa->addValidator(new Zend_Validate_Float);
        $this->surfacearea = $sa;
        
        $yr = $this->createElement('text', 'IndepYear');
        $yr->setLabel("Independence Year:"); 
        $yr->maxLength = 4;
        $yr->size = 4;
        $yr->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $yr->addValidator(new Zend_Validate_Int());
        $yr->addValidator(new Zend_Validate_Date(array('format' => 'yyyy')));
        $this->indepyear = $yr;
        
        $pop = $this->createElement('text', 'Population');
        $pop->setLabel("Population:"); 
        $pop->maxLength = 10;
        $pop->size = 10;
        $pop->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_PregReplace(array('match' => '/,/', 'replace' => ''))
        ));
        $pop->addValidator(new Zend_Validate_Int);
        $this->population = $pop;
        
        $le = $this->createElement('text', 'LifeExpectancy');
        $le->setLabel("Life Expectancy:"); 
        $le->maxLength = 5;
        $le->size = 5;
        $le->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_PregReplace(array('match' => '/,/', 'replace' => ''))
            ));
        $this->lifeexpectancy = $le;
        
        $gnp = $this->createElement('text', 'GNP');
        $gnp->setLabel("GNP:"); 
        $gnp->maxLength = 10;
        $gnp->size = 10;
        $gnp->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_PregReplace(array('match' => '/,/', 'replace' => ''))
            ));
        $gnp->addValidator(new Zend_Validate_Float);
        $this->gnp = $gnp;

        $gnpold = $this->createElement('text', 'GNPOld');
        $gnpold->setLabel("GNP (old):"); 
        $gnpold->maxLength = 10;
        $gnpold->size = 10;
        $gnpold->addFilters(array(
            new Zend_Filter_StringTrim(),
            ));
        $gnpold->addValidator(new Zend_Validate_Float);
        $this->gnpold = $gnpold;
        
       // add submit button without a label
        $submit = $this->createElement('submit', 'Submit');
        $submit->setDecorators(array(
            array('ViewHelper'),
            array('Description'),

        ));
        $submit->class = 'btn btn-primary';
        $this->submit = $submit;        
         
    }
        
    public function buildAddForm()
    {
        // add another validation test for $code, can't have duplicates
        $this->code->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
        		'table' => 'Country',
        		'field' => 'Code'
            )));
       
        $this->addElements(
            array(
                $this->code,
                $this->name,
                $this->localname,
                $this->capitalName,
                $this->code2,
                $this->governmentform,
                $this->headofstate,
                $this->continent,
                $this->region,
                $this->surfacearea,
                $this->indepyear,
                $this->population,
                $this->lifeexpectancy,
                $this->gnp,
                $this->gnpold
                )
        );
        
        $this->finishForm();

        // now add the submit button - this gets us a button without <label></label>
        $this->addElement($this->submit); 
        
    }

    protected function finishForm() 
    {
        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('separator'=>'<br/>')),
            array('HtmlTag', array('tag' => 'div', 'class'=>'form-group')),
        ));
        
        // wrapper for elements
        $this->addDecorator('FormElements')
         ->addDecorator('HtmlTag', array('tag' => '<div>', 'class'=>'center-block'))
         ->addDecorator('Form');
        
    }

    public function buildEditForm()
    {
        $this->addElements(
            array(
                $this->name,
                $this->localname,
                $this->capitalSelect,
                $this->code2,
                $this->governmentform,
                $this->headofstate,
                $this->continent,
                $this->region,
                $this->surfacearea,
                $this->indepyear,
                $this->population,
                $this->lifeexpectancy,
                $this->gnp,
                $this->gnpold
            )
        );
        
        $this->finishForm();
        
        // add the hidden element
        $this->addElement($this->hiddenCode);
        // now add the submit button - this gets us a button without <label></label>
        $this->addElement($this->submit); 
        
    }
    
    /**
     * 
     * @param Application_Model_Country $countryModel
     */
    public function populateFromModel(Application_Model_Country $countryModel)
    {
        // convert data in Mapper to an array
        $formData = Application_Model_Mapper_CountryMapper::instance()->toArray($countryModel);
        $this->populate($formData);
        
        // create select list for cities in this country
        // TODO: decide what to do if no cities have been assigned to this country,
        //   so there are no cities to choose from when editing
        // Options are
        //   (1) display text input, like when adding a country
        //   (2) provide link to "Add City"
        //   (3) display all cities and allow a city to be moved from another country
        //   (4) change initial insert of new country and do not allow NULL Capital 
        //       in table so this doesn't happen
        $cities = $this->getCities($countryModel->getCode());
        foreach ($cities AS $k => $v) {
            $this->capitalSelect->addMultiOption($k, $v);
        }

        // find the capital select element and set it's value to capital id
        $this->capitalSelect->setValue($countryModel->getCapital());

        // set the value for the hidden field
        $this->hiddenCode->setValue($countryModel->getCode());
    }

    protected function getCities($code='') 
    {
        $cityList = array();
        $cityList[0] = '';  // table allows country.capital to be null
        
        // TODO: change this to use City Model
        $sql = "SELECT `ID`,`Name` FROM City WHERE `CountryCode` = '$code' ORDER BY `Name`";
        $db = Zend_Db_Table::getDefaultAdapter();
        $row = $db->fetchAll($sql);
        foreach ($row AS $r) {
            $cityList[$r['ID']] = $r['Name'];
        }
        return $cityList;
    }

}

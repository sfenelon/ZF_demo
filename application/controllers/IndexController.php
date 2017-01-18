<?php
/**
 * World DB demo
 * 
 * @author Sheila Fenelon (sheila@shefen.com)
 *
 */
class IndexController extends Zend_Controller_Action
{

    protected $_flashMessenger = null;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('bootstrap');
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        // need 'current' for the menu
        $this->view->current = $this->getRequest()->getActionName();
    }

    /**
     * Home page - lists all countries in db
     */
    public function indexAction()
    {
        $this->view->messages = $this->_flashMessenger->getMessages();
        $this->view->countries = Application_Model_Mapper_CountryMapper::instance()->fetchAllByOrder('Name');
    }

    /**
     * Display info about country whose code is passed as GET parameter.
     */
    public function viewAction()
    {
        $code = $this->_getParam('code', '');
        $this->view->code = $code;
        // fetch the country info
        $countryModel = Application_Model_Mapper_CountryMapper::fetchOne($code);
        $this->view->title = 'Country Info';
        $this->view->countryModel = $countryModel;    
    }
    
    /**
     * Display some info about this application.
     */
    public function aboutAction()
    {
        $this->view->title = 'About';
        $this->view->phpversion = phpversion();
        $this->view->zfversion = Zend_Version::VERSION;
    }

    public function addcountryAction()
    {
        $this->view->title = 'Add another Country';
        $form = new Application_Form_Country();
        $form->buildAddForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                
                // add new city for capital, use returned id in $country
                $capitalName = $form->getValue('CapitalName');
             
                $countryCode = $form->getValue('Code');
                if ($capitalName !== '') {
                    $city = new Application_Model_City();
                    $city->setName($capitalName);
                    $city->setCountrycode($countryCode);
                    $city->setDistrict('');
                    $city->setPopulation(0);
                    $cityMapper  = new Application_Model_Mapper_CityMapper();
                    $newCityModel = $cityMapper->insert($city);
                    $cityId = $newCityModel->getId();                     
                } else {
                    $cityId = null;
                }
                
                $country = new Application_Model_Country($form->getValues());
                $country->setCapital($cityId);
                $countryName = $country->getName();
                $mapper  = new Application_Model_Mapper_CountryMapper();
                $mapper->insert($country);
                
                $this->_flashMessenger->addMessage("$countryName Added");
                return $this->_helper->redirector('index');
            }
        }
        $this->view->form = $form;
    }

    
    /**
     * TODO: allow "add another city" when editing the country's capital city
     */
    public function editcountryAction()
    {
        $this->view->title = 'Edit Country';
        $code = $this->_getParam('code', '');
        
        $form = new Application_Form_Country();
        $form->buildEditForm();
            
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->getElement('Capital')->setRegisterInArrayValidator(false);
            if ($form->isValid($request->getPost())) {
                
                $formdata = $form->getValues();
                $capitalId = $form->getValue('Capital');
                $country = new Application_Model_Country($form->getValues());
                $country->setCapital($capitalId);
                $countryName = $country->getName();
                $country = Application_Model_Mapper_CountryMapper::instance()->update($country);
                
                $this->_flashMessenger->addMessage("$countryName Updated");
                return $this->_helper->redirector('index');
            }

        }

        // display the form
        $countryModel = Application_Model_Mapper_CountryMapper::fetchOne($code);
        $form->populateFromModel($countryModel);
        $this->view->form = $form;
        
    }

    
    public function delcountryAction()
    {
        $this->view->title = 'Edit Country';
        $code = $this->_getParam('code', '');
        // fetch the record so we can echo the country name
        $countryModel = Application_Model_Mapper_CountryMapper::fetchOne($code);
        if ($countryModel !== null) {
            $countryName = $countryModel->getName();
            // TODO: delete the associated cities too?
            Application_Model_Mapper_CountryMapper::instance()->remove($code);
            $this->view->msg = "$countryName has been removed. <br>Note: associated cities have not been removed.";
        } else {
            $this->view->msg = "Unable to find $countryName in the database.";
        }
                
    }
    
}


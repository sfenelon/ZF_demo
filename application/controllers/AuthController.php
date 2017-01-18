<?php
/**
 * World DB demo
 * 
 * @author Sheila Fenelon (sheila@shefen.com)
 *
 */
class AuthController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('bootstrap');
        $this->view->current = 'auth';
    }
    
    /**
     * Display login form and process input 
     */
    public function loginAction() 
    {
        $this->view->title = 'Login';
        $form = new Application_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    // Login is OK 
                    // Redirect to home page - where additional features are now available
                    $this->_helper->redirector('index', 'index');
                } else {
                    $this->view->msg = 'No match found for that username-password combination.';
                    error_log("no match found for username = [{$form->getValue('username')}] password = [{$form->getValue('password')}]");
                }
            }
        }
        $this->view->form = $form;
    }
    
    /**
     * Process login attempt
     * 
     * @param array $values - POSTed input
     */   
    protected function _process($values)
    {
        // get authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);
        $adapter->setCredentialTreatment('SHA1(CONCAT(?,salt))');

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    /**
     * Constructs Zend_Auth_Adapter_DbTable object for the `user` table
     * to check for authorized user.
     */
    protected function _getAuthAdapter() 
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');
/**
 *  doesn't work here, moved to _process()                    
 *                    ->setCredentialTreatment('SHA1(CONCAT(?,salt))');
 * 
 */

        return $authAdapter;
    }
    
    public function logoutAction() 
    {
        Zend_Auth::getInstance()->clearIdentity();
    }
    
}

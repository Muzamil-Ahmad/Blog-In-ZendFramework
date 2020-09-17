<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Registration for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */



         // <-- Add this import
       // <-- Add this import







namespace Registration\Controller;
use Registration\Model\Userregisteration;
use Zend\Mvc\Controller\AbstractActionController;
use Registration\Model\Registration;
use Registration\Form\RegForm;
use Registration\Model\RegModel;
use Zend\View\Model\ViewModel;
use Application\Entity\Userregistration;
use Registration\Form\LoginForm;


class RegistrationController extends AbstractActionController
{
//     public function indexAction()
//     {
    	
//         return array();
//     }
    public function registerAction()
    {

    	$form= new RegForm();
    	$data = new Userregistration();
    	$form->bind($data);
    	$request = $this->getRequest();
    	if($request->isPost())
    	{
    		$form->setData($request->getPost());
    		if($form->isValid())
    		{
    			$em = $this->getServiceLocator()
    			->get('doctrine.entitymanager.orm_default');
    			$regModel = new regModel($em);
    			$regModel->regUser($data);
    			return $this->redirect()->toRoute('blog');
    				
    		}
    		
    	}
    	session_start();
    	return new ViewModel(['form'=>$form]);
    	
    	
    	}
    	public function loginAction()
    	{
    		
    		$form= new LoginForm();
    		$data = new Userregistration();
    		$form->bind($data);
    		$request = $this->getRequest();
    		if($request->isPost())
    		{
    			$em = $this->getServiceLocator()
    			->get('doctrine.entitymanager.orm_default');
    			$regModel = new regModel($em);
    			$form->setData($request->getPost());
    			if($form->isValid()){
    				$result = $regModel->checkUser($data->getUsername());
    				if($result)
    				{
    					session_start();
    					$_SESSION['username']= $result->getUsername();
    					$_SESSION['userid']=$result->getUserid();
//     					echo $_SESSION['username'];
//     					die;
    					return $this->redirect()->toRoute('blog');
    				}
    				else 
    				{

    					echo "<script>alert('Enter valid username!')</script>";
    					
    				}
    			}

    		}
    		
    		
    		return new ViewModel(['form'=>$form]);
    	}
    	public function logoutAction()
    	{
    		session_start();
    		unset($_SESSION['username']);
    		session_destroy(); 
    		return $this->redirect()->toRoute('blog');
    		
    	}
    	
    
}

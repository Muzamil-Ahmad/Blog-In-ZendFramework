<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Checklist for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Checklist\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Checklist\Model\TaskModel;
use Checklist\Form\TaskForm;
use Application\Entity\TaskItem;


use Zend\Http\Response;
class TaskController extends AbstractActionController
{
    public function indexAction()
    { 
    	
    	$form=new TaskForm();
    	$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    	$taskModel= new TaskModel($em);
    	$tasks=$taskModel->getAllTasks();
    	
    	echo "hello";
    	 
    	return new ViewModel(['form'=>$form,'tasks'=>$tasks]);
    	
     
    }
    public function addAction()
    {
    	
    	$form = new TaskForm();
    	$task = new TaskItem();
    	$form->bind($task);
    	 
    	$request = $this->getRequest();
    	if($request->isPost())
    	{
    		$form->setData($request->getPost());
    	}
    	if($form->isValid())
    	{
    		$em = $this->getServiceLocator()
    		->get('doctrine.entitymanager.orm_default');
    		$taskModel = new TaskModel($em);
    		$taskModel->addTask($task);
// echo "muzamil";
// die;
    		return $this->redirect()->toRoute('checklist');
    		
    	}
    	 
    	return new ViewModel(['form'=>$form]);
    
    	 
    }
    
    public function editAction()
    {
//     	echo "editAction call";
//     	die();
    	$id = $this->params('id');
    	$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    	$taskModel = new TaskModel($em); 
    	$task_result = $taskModel->editTask($id);
    	$form = new TaskForm();
    	$task = new TaskItem();
    	$form->bind($task);
    	$form->setData($task_result);
    	
//     	echo $request->isPost();
//     	die;
// The above code brings the data of the id at the form 
// and the rest of the function code is used to update the  data.
    	$request = $this->getRequest();
    	if($request->isPost()){
    		$form->setData($request->getPost());
    
    		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    
    		$task = $em->getRepository(TaskItem::class)->findOneBy(['id'=>$id]);
    
    		if($form->isValid())
    		{
    			$taskModel->updateTask($task,(array)$request->getPost());
    			return $this->redirect()->toRoute('checklist');
    		}
    		else
    		{
    			 
    		}
    	}
    	return new ViewModel(array('form'=>$form,'id'=>$id));
    	 
    }
    
    
    public function deleteAction()
    {
    	 
    	$id = $this->params('id');
    	 
    	// $form = new TaskForm();
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		if ($request->getPost()->get('del') == 'Yes') {
    			$em =$this->getServiceLocator()
    			->get('doctrine.entitymanager.orm_default');
    			$taskModel=new TaskModel($em);
    			$ret = 	$taskModel->deleteTask($id);
//     			echo $ret;
//     			die;
    			 
    			if($ret>0)
    			{
    				$this->redirect()->toRoute('checklist');
    			}
    			else
    			{
    				 
    				echo "couldn't find any record having Id like this....".$id;
    				header('refresh:5;url=http://nhost/task');
    			}
    
    		}
    		else
    			return $this->redirect()->toRoute('checklist');
    	}
    
    
    
    	return new ViewModel(array('id'=>$id));
    	return(array());
    }

//     public function fooAction()
//     {
//         // This shows the :controller and :action parameters in default route
//         // are working when you browse to /task/task/foo
//         $mapper = $this->getTaskMapper();
// //         echo "dddddddd";die();
//        return new ViewModel(array('tasks'=>$mapper->fetchAll()));
//     }
    
}

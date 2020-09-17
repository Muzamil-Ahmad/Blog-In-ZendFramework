<?php 
namespace Checklist\Model;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Db\Sql\Delete;
use Application\Entity\TaskItem;
	
class TaskModel
{
	public $doctMgr;

	public function __construct(EntityManager $doctObj)
	{
		$this->doctMgr=$doctObj;

	}
	public function getAllTasks()
	{
		return $this->doctMgr->getRepository('Application\Entity\TaskItem')->findAll();
	}

	public function addTask(TaskItem $task)
	{
			
		$task->setCompleted(0);
		$task->setCreated(date_create(date('d-m-Y h:i:s')));
			
		$this->doctMgr->persist($task);
		$this->doctMgr->flush();
			
	}
	
	public function editTask($id)
	{
			
	
		$query = $this->
		doctMgr->createQuery('select t from Application\Entity\TaskItem t where t.id = :id');
		$query->setParameter('id', $id);
	
	
		$result =  $query->getArrayResult();
	
		if(!count($result)){
			throw new \PDOException();
	
		}
		return $result[0];
			
	}
	
	public function deleteTask($id)
	{
			
		$query =   $this->doctMgr->createQuery('delete  from Application\Entity\TaskItem t where t.id=:id');
		$query->setParameter('id', $id);
		return $query->execute();
// 		die();
	}
	
	public function updateTask(TaskItem $task, array $form)
	{
			
		$task->setTitle($form['title']);
		$task->setCompleted($form['completed']);
		$task->setCreated(date_create(date('d-m-Y h:i:s')));
			
		//echo $task->getTitle();die();
	
		$this->doctMgr->persist($task);
		$this->doctMgr->flush();
	
	
	}

}



?>
<?php
namespace Registration\Model;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Db\Sql\Delete;
use Application\Entity\Userregistration;
use Application;
class RegModel
{
	public $doctMgr;

	public function __construct(EntityManager $doctObj)
	{
		$this->doctMgr=$doctObj;

	}
	
	public function regUser(Userregistration $data)
	{
	
        $this->doctMgr->persist($data);
		$this->doctMgr->flush();
			
	}
	public function checkUser($username)
	{
		try{
			$query = $this->doctMgr->createQuery('SELECT r FROM Application\Entity\Userregistration r WHERE r.username =?1');
			$query->setParameter(1, $username);
			$result=$query->getResult();
			if($result)
			{
				return $result[0];	
			}
			else 
			{
				return 0;
			}
			
		}catch(\Exception $e){
			print_r($e->getMessage());
			die;
		}
		
	}

}
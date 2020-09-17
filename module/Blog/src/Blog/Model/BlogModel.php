<?php
namespace Blog\Model;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Db\Sql\Delete;
use Application\Entity\Blogtable;
use Application\Entity\Comenttable;
use Application\Entity\Userregistration;
use Application\Entity\Likes;
use Application\Entity\Tasklist;
use Application;
use Application\Entity\Followers;
use Application\Entity\Privacy;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;

class BlogModel
{
	public $doctMgr;

	public function __construct(EntityManager $doctObj)
	{
		$this->doctMgr=$doctObj;

	}
	public function getAllTasks()
	{
// 		return $this->doctMgr->getRepository('Application\Entity\Blogtable')->findAll();
		$query=$this->doctMgr->createQuery('select p,u from Application\Entity\BlogTable p JOIN p.userid u ORDER BY p.postdate DESC');
		$result =  $query->getResult();
		if(!count($result)){
			throw new \PDOException();
		}
		return $result;
	
	}
	
	public function addPost(Blogtable $post,$userid,$fileName)
	{
		try{
		$uid=new Userregistration();
		$query=$this->doctMgr->
		createQuery('select u from Application\Entity\userregistration 
				u where u.userid=:userid');
		$query->setParameter('userid', $userid);
		$uid= $query->getResult()[0];
        $post->setUserid($uid);
        $post->setPostdate(date_create(date('d-m-Y h:i:s')));
        $post->setUserphoto($fileName);
//         echo "<pre>";
//         print_r($post);
//         die();
        $this->doctMgr->persist($post);
		$this->doctMgr->flush();
		}catch(\Exception $e){
			print_r($e->getMessage());
			die();
		}
	}
	
	public function editPost($id)
	{
		
		$query = $this->
		doctMgr->createQuery('select t from Application\Entity\Blogtable t where t.blogid = :id');
		$query->setParameter('id', $id);
		$result =  $query->getArrayResult();
		if(!count($result)){
			throw new \PDOException();
	
		}
		return $result;
	}
	public function updatePost($request,$id,$fileName)
	{
			
		// 		echo "<pre>";
		// 		print_r($request->getFiles());
		// 		die;
		$data = new Blogtable();
		$data =$request->getPost();
		$title = $data['title'];
		$userpost=$data['userpost'];
	
		$query=$this->doctMgr->createQuery('update  Application\Entity\Blogtable p set p.title= :title,p.userpost=:userpost,p.userphoto=:userphoto where p.blogid=:id');
		$query->setParameter('id',$id);
		$query->setParameter('title', $title);
		$query->setParameter('userpost', $userpost);
		$query->setParameter('userphoto', $fileName);
		$query->getArrayResult();
		return 1;
	
	
	
	}
	public function getData($id)
	{
		$query=$this->doctMgr->createQuery('select p,u from Application\Entity\BlogTable p JOIN  p.userid u  where p.blogid=:id  ORDER BY p.postdate DESC');
		$query->setParameter('id', $id);   
		$result =  $query->getResult()[0];
// 		echo "<pre>";
// 		print_r($result->getUserid()->getuserid());
// 		die;
		if(!count($result)){
			throw new \PDOException();
		}
		return $result;
	}
	public function getMyposts($id)
	{
		$query=$this->doctMgr->createQuery('select t from Application\Entity\Blogtable t where t.userid=:id');
		$query->setParameter('id',$id);
		$myposts =  $query->getResult();
// 		print_r($myposts);
// 		die;
		if(!count($myposts)){
			throw new \PDOException();
		
		}
		return $myposts;
	}

	public function submitComment($data)
	{	
		try {
		$comment=$data['comment'];
		$postid=$data['postid'];
		$userid=$_SESSION['userid'];
		$blogid =  new Blogtable();
		$userid = $this->doctMgr->find('Application\Entity\Userregistration',$userid);
		$comobj = new Comenttable();
// 		$query=$this->doctMgr->createQuery('select t from Application\Entity\userregistration t where t.userid=:uid');
// 		$query->setParameter('uid',$userid);
// 		$userid =  $query->getResult()[0];
  		$blogid = $this->doctMgr->find('Application\Entity\Blogtable',$postid);
		$comobj->setCreatedAt(date_create(date('d-m-Y h:i:s')));
		$comobj->setBlogid($blogid);
		$comobj->setUserid($userid);
		$comobj->setComment($comment);
		$this->doctMgr->persist($comobj);
		$this->doctMgr->flush();
		}catch(\Exception $e){
			print_r($e->getMessage());
			die();
		}
	}
	public function getComment($id)
	{
		$query=$this->doctMgr->createQuery('select t.comment,t.commentid,t.createdat,u.username,u.userid from Application\Entity\comenttable t JOIN  t.userid u  where t.blogid=:id ORDER BY t.commentid DESC');
		$query->setParameter('id',$id);
		$mycomments =  $query->getResult();
// 				echo "<pre>";
// 				print_r($mycomments);
// 				die;
		return $mycomments;
	}
	public function addLike($uid,$bid)
	{
		$like = new Likes();
		$blogid =  new Blogtable();
		$userid = new Userregistration();
	
		try{
		$query=$this->doctMgr->createQuery('select t from Application\Entity\userregistration t where t.userid=:uid');
		$query->setParameter('uid',$uid);
		$userid =  $query->getResult()[0];
	
		$query=$this->doctMgr->createQuery('select p from Application\Entity\Blogtable p where p.blogid=:bid');
		$query->setParameter('bid',$bid);
		$blogid =  $query->getResult()[0];
		$like->setBlogid($blogid);
		$like->setUserid($userid);
		$like->setUpdatedAt(date_create(date('d-m-Y h:i:s')));
		$this->doctMgr->persist($like);
		$this->doctMgr->flush();
		}catch (\Exception $ex)
		{
			echo $ex->getMessage();
			die();
		}
	}
	public function CountLike($blogid)
	{
		$query=$this->doctMgr->createQuery('select count(L.id) as c from Application\Entity\Likes L where L.blogid=:blogid');
		$query->setParameter('blogid',$blogid);
// 		$count =  $query->getResult()[0];
// 		return $count['c'];
		$count = $query->execute();
		return $count;
	
	}
	public function deleteLike($userid,$blogid)
	{
		$query=$this->doctMgr->createQuery('delete from Application\Entity\Likes l where l.userid=:userid AND l.blogid=:blogid');
		$query->setParameter('userid',$userid);
		$query->setParameter('blogid',$blogid);
		$query->execute();		
	}
	public function checklikestatus($userid,$blogid)
	{
	
		$query=$this->doctMgr->createQuery('select L.id,u.userid,p.blogid from Application\Entity\Likes L JOIN  L.userid u JOIN L.blogid p where L.userid=:userid AND L.blogid=:blogid');
		$query->setParameter('userid',$userid);
		$query->setParameter('blogid',$blogid);
		$userid =  $query->getArrayResult();
		if($userid)
		{
			return 1;
		}
		else
		{
			return 0;
		}
// 				echo "<prev>";
// 				print_r($userid);
// 				die;
	}
	
	public function checkUserLike($userid,$blogid)
	{
		
		$query=$this->doctMgr->createQuery('select L from Application\Entity\Likes L where L.userid=:userid AND L.blogid=:blogid');
		$query->setParameter('userid',$userid);
		$query->setParameter('blogid',$blogid);
		$userid =  $query->getArrayResult();
// 		echo "<prev>";
// 		print_r($userid);
// 		die;
		return $userid;
	}
	
	
	public function editComment($id)
	{
	
		$query = $this->
		doctMgr->createQuery('select c from Application\Entity\comenttable c where c.blogid = :id');
		$query->setParameter('id', $id);
		$result =  $query->getArrayResult();

		if(!count($result)){
			throw new \PDOException();
		
		}
		return $result;	
	}
	
	Public function updateComment($request)
	{
		$data = new Comenttable();
		$data =$request->getPost();
		$comment = $data['comment'];
		$id= $data['commentid'];
		$query=$this->doctMgr->createQuery('update  Application\Entity\comenttable p set p.comment= :comment where p.commentid=:id');
		$query->setParameter('id',$id);
		$query->setParameter('comment', $comment);
		$query->execute();
		
	}
	public function getMytasks()
	{    
		try {
			$value=0;
		$query= $this->doctMgr->createQuery('select t from Application\Entity\tasklist t where t.taskstatus=:zero order by t.duedate ASC');
		$query->setParameter('zero',$value);
		$res = $query->execute();
// 	    print_r($res);
// 	    die;
		}catch (\Exception $ex)
		{
			echo $ex->getMessage();
			die();
		}
	    return $res;
	    
	}
	public function addTask($data)
	{
		$task = new Tasklist();
		$task->setTaskstatus(0);
		$date =$data['duedate'];
	    $date1=date_create($date);
		$task->setDuedate($date1);	
	    $task->setTaskname($data['taskname']);
		$this->doctMgr->persist($task);
		$this->doctMgr->flush();
	}
	public function updatetable($data)
	{
		try{
			$objtasklist = new Tasklist();
			$id=$data['id'];
			$status=1;
			$cdate=date_create(date('d-m-Y'));
			$query=$this->doctMgr
			->createQuery('update Application\Entity\tasklist t set t.taskstatus=:status,t.completeddate=:completed where t.taskid=:taskid');
			$query->setParameter('status',$status);
			$query->setParameter('completed',$cdate);
			$query->setParameter('taskid',$id);
			$query->execute();
			return $cdate;
			}
			catch (\Exception $e){
				print_r($e->getMessage());
				die;
			}
		
	}
	public function undotable($data)
	{
		try{
			$objtasklist = new Tasklist();
			$id=$data['id'];
			$status=0;
			$query=$this->doctMgr
			->createQuery('update Application\Entity\tasklist t set t.taskstatus=:status where t.taskid=:taskid');
			$query->setParameter('status',$status);
			$query->setParameter('taskid',$id);
			$query->execute();
		   }
		catch (\Exception $e)
		   {
			print_r($e->getMessage());
			die;
		   }	
		
	}
	public function getmycompletedTasks()
	{
		try {
			$value=1;
			$query= $this->doctMgr->createQuery('select t from Application\Entity\tasklist t where t.taskstatus=:one order by t.taskid DESC');
			$query->setParameter('one',$value);
			$res = $query->execute();
			// 	    print_r($res);
			// 	    die;
		}catch (\Exception $ex)
		{
			echo $ex->getMessage();
			die();
		}
		return $res;	
	}
	public function updateProfile($data,$userid,$filename)
	{
		try
			{
				$username=$data['username'];
				$password=$data['password'];
				$email=$data['email'];
				$mobileno=$data['phoneno'];
				$address=$data['address'];
				$gender=$data['gender'];
				$profession=$data['profession'];
// 				$file=$data['profile'];
				$query=$this->doctMgr->createQuery('update Application\Entity\Userregistration r set r.username=:uname,r.password=:pwd,r.email=:email,r.phoneno=:phoneno,r.address=:address,r.profile=:profile,r.gender=:gender,r.profession=:prof where r.userid=:id');
				$query->setParameter('id',$userid);
				$query->setParameter('uname',$username);
				$query->setParameter('email',$email);
				$query->setParameter('phoneno',$mobileno);
				$query->setParameter('profile',$filename);
				$query->setParameter('address',$address);
				$query->setParameter('pwd',$password);
				$query->setParameter('gender',$gender);
				$query->setParameter('prof',$profession);
				$result = $query->execute();
			}
		catch(\Exception $exc)
			{
				echo $exc->getMessage();
				die();
			}
		return $result;
	}
	public function getUserprofile($userid)
	{
		try {
		$query=$this->doctMgr->createQuery('select u from Application\Entity\userregistration u where u.userid=:id');
		$query->setParameter('id',$userid);
		$res=$query->execute();
		}
		catch(\Exception $exc)
		{
			echo $exc->getMessage();
			die();
		}
		return $res[0];
		
	}
	public function checkFollower($data)
	{
		try {
			$userid = $_SESSION['userid'];
			$followid = $data['id'];
			$query=$this->doctMgr
			->createQuery('select count(f.id) as c from Application\Entity\followers f where f.userid=:userid AND f.followsid=:followid');
			$query->setParameter('userid',$userid);
			$query->setParameter('followid',$followid);
			$res =  $query->getArrayResult()[0];
			
			
		}
		catch(\Exception $exc)
		{
			echo $exc->getMessage();
			die();
		}
		if($res['c'])
		{
		return  1;
		}
		else 
		{
			return 0;
		}
		
		
	}
	public function setFollower($data)
	{
		$userobj = new Followers();
		$useridobj = new Userregistration();
		$userregobj = new Userregistration();
		$userid =  $_SESSION['userid'];
		$followid = $data['id'];
		$useridobj = $this->doctMgr->find('Application\Entity\userregistration',$followid);
		$userregobj= $this->doctMgr->find('Application\Entity\userregistration',$userid);
		$userobj->setFollowsid($useridobj);
		$userobj->setUserid($userregobj);
		$userobj->setUpdatedAt(date_create(date('d-m-Y h:i:s')));
		$this->doctMgr->persist($userobj);
		$this->doctMgr->flush();
		return 0;
	
	}
  public function deleteFollower($data)
  {
		$userid = $_SESSION['userid'];
		$followid = $data['id'];
		$query=$this->doctMgr->createQuery('delete from Application\Entity\Followers f where f.userid=:userid AND f.followsid=:followid');
		$query->setParameter('userid',$userid);
		$query->setParameter('followid',$followid);
		$res=$query->execute();
// 		echo "<pre>";
// 		print_r($res);
// 		die;
	
  }
  public function getUserdata($userid)
  {
		try {
			$query=$this->doctMgr->createQuery('select u from Application\Entity\userregistration u where u.userid=:id');
			$query->setParameter('id',$userid);
			$res=$query->execute();
		}
		catch(\Exception $exc)
		{
			echo $exc->getMessage();
			die();
		}
	
		return $res[0];
		
  } 
  public function changePhoto($data,$filename)
  {
		$userid=$_SESSION['userid'];
		$query=$this->doctMgr->createQuery('select u.profile from Application\Entity\Userregistration u where u.userid=:id');
		$query->setParameter('id',$userid);
		$res=$query->getArrayResult();
		
		$query=$this->doctMgr->createQuery('update Application\Entity\Userregistration r set r.profile=:profile where r.userid=:id');
		$query->setParameter('profile',$filename);
		$query->setParameter('id',$userid);
		$query->getArrayResult();
		return $res;
  }
  public function checkfollowstatus($followid)
  {
		$userid=$_SESSION['userid'];
		$query=$this->doctMgr->createQuery('select f.id from Application\Entity\followers f where f.userid=:id AND f.followsid=:followid');
		$query->setParameter('id',$userid);
		$query->setParameter('followid',$followid);
		$count =  $query->getArrayResult();
		if($count)
		{
			return 1;
		}
		else
		{
			return 0;
		}
		// 				echo "<prev>";
		// 				print_r($userid);
		// 				die;
   }
   public function getFollowers($id)
   {
// 		$userid=$_SESSION['userid'];
		$query=$this->doctMgr->createQuery('select f,u from Application\Entity\followers f JOIN  f.userid u where f.followsid=:userid');
		$query->setParameter('userid',$id);
		$result =  $query->getArrayResult();
		return $result;
		
   }
   public function countFollowers($id)
   {

		try {
			$query=$this->doctMgr
			->createQuery('select count(f.id) as c from Application\Entity\followers f where f.followsid=:userid');
			$query->setParameter('userid',$id);
			$res =  $query->getArrayResult();	
			return $res[0]['c'];
		}
		catch(\Exception $exc)
		{
			echo $exc->getMessage();
			die();
		}	
	}
	public function followingTo($id)
	{
		$query=$this->doctMgr->createQuery('select u,f from Application\Entity\followers f JOIN  f.followsid u where f.userid  =:id');
		$query->setParameter('id',$id);
		$result = $query->getArrayResult();
// 		echo "<pre>";
// 		print_r($result);
// 		die;
		return $result;
	}
	public function countFollowing($id)
	{
		try 
		{
			$query=$this->doctMgr
			->createQuery('select count(f.id) as c from Application\Entity\followers f  where f.userid=:userid');
			$query->setParameter('userid',$id);
			$res =  $query->getArrayResult();
			return $res[0]['c'];
		}
		catch(\Exception $exc)
		{
			echo $exc->getMessage();
			die();
		}
		
	}
	public function getFollowingActivities()
	{
		
		$userid=$_SESSION['userid'];
		
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f JOIN  f.followsid u where f.userid  =:userid');
		$query->setParameter('userid',$userid);
		$result = $query->getArrayResult();
	

		$result= array_map(function($data){
			return $data['userid'];
		},$result);

// 			$result = implode(',',$result);
			$query=$this->doctMgr
			->createQuery('select \'post\' as type,b.blogid,b.userphoto,b.postdate as createDate,u.userid,u.username,u.profile from Application\Entity\blogtable b Join b.userid u WHERE b.userid IN (:ids) ORDER BY b.postdate DESC');
			$query->setParameter('ids',$result);

			
			$result = $query->getArrayResult();
		
	
		return $result;
		
		
		
		
	
	}
	public function getFollowingCommentActivities($userid)
	{
		
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f JOIN  f.followsid u where f.userid  =:userid');
		$query->setParameter('userid',$userid);
		$result = $query->getArrayResult();

		$result= array_map(function($data){
			return $data['userid'];
		},$result);
			$query=$this->doctMgr
			->createQuery('select  \'comment\' as type,c.comment,c.commentid,c.createdat as createDate,u.username,u.profile,u.userid,b.blogid from Application\Entity\comenttable c Join c.userid u Join c.blogid b WHERE c.userid IN (:ids) ORDER BY c.createdat DESC');
			$query->setParameter('ids',$result);
			$result = $query->getArrayResult();
// 			echo "<pre>";
// 			print_r($result);
// 			die;
		
			return $result;
			

		
	}
	public function getFollowingLikesActivities()
	{
		$userid=$_SESSION['userid'];
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f JOIN  f.followsid u where f.userid  =:userid');
		$query->setParameter('userid',$userid);
		$result = $query->getArrayResult();
		
		$result= array_map(function($data){
			return $data['userid'];
		},$result);
		$query=$this->doctMgr
		->createQuery('select  \'like\' as type,l.updatedAt as createDate,u.username,u.profile,u.userid,b.blogid from Application\Entity\likes l Join l.userid u Join l.blogid b WHERE l.userid IN (:ids)'); //ORDER BY l.updated_at DESC
		$query->setParameter('ids',$result);
		$result = $query->getArrayResult();
		
		return $result;
			
	
	
	}
	public function getMyFollowers($id)
	{
		$query=$this->doctMgr->createQuery('select \'follower\' as type,f.updatedat as createDate,u.username,u.profile,u.userid from Application\Entity\followers f JOIN  f.userid u where f.followsid=:userid');
		$query->setParameter('userid',$id);
		$result =  $query->getArrayResult();
// 					echo "<pre>";
// 					print_r($result);
// 					die;
		
		return $result;
		
	}
	public function checkPrivacy($id)
	{
		$userid=$_SESSION['userid'];
		$accessid=$id;
		$query=$this->doctMgr->createQuery('select count(p.id) as c from Application\Entity\privacy p Join p.userid u Join p.accessid uv where p.userid=:userid AND p.accessid=:accessid');
		$query->setParameter('userid', $userid);
		$query->setParameter('accessid', $accessid);
		$res=$query->getArrayResult();
// 		echo "<pre>";
// 		print_r($res);
// 		die;
		return $res;

	
	}
	public function setPrivacy($data)
	{
		$userid=$_SESSION['userid'];
		$accessid=$data['id'];
	
		$privacyobject=new Privacy();
		$userid = $this->doctMgr->find('Application\Entity\userregistration',$userid);
		$accessid= $this->doctMgr->find('Application\Entity\userregistration',$accessid);
		$privacyobject->setUserid($userid);
		$privacyobject->setAccessid($accessid);
		$this->doctMgr->persist($privacyobject);
		$this->doctMgr->flush();
		return 1;
		
		
		
	}
	public function deletePrivacy($data)
	{
		$userid=$_SESSION['userid'];
		$accessid=$data['id'];
		$query=$this->doctMgr->createQuery('delete from Application\Entity\privacy p where p.userid=:userid AND p.accessid=:accessid');
		$query->setParameter('userid',$userid);
		$query->setParameter('accessid',$accessid);
		$res=$query->getResult();
		return $res;
	}
	public function getPrivacy($accessid)
	{
		
		$userid=$_SESSION['userid'];
		$query=$this->doctMgr->createQuery('select p from Application\Entity\privacy p where p.userid=:accessid AND p.accessid=:userid');
		$query->setParameter('userid',$userid);
		$query->setParameter('accessid',$accessid);
		$res=$query->getArrayResult();
// 		echo "<pre>";
// 		print_r($res[0]['id']);
// 		die;
		

        return $res;
		
		
	}
	public function setPrivacyOnToAllFlg($userid)
	{
// 		$privacyobj=new Privacy();
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f join f.followsid u where f.userid=:userid');
		$query->setParameter('userid',$userid);
		$result=$query->getArrayResult();
		$userid = $this->doctMgr->find('Application\Entity\userregistration',$userid);
		foreach ($result as $value)
		{
			$privacyobj=new Privacy();
			
		$accessid= $this->doctMgr->find('Application\Entity\userregistration',$value);
		$privacyobj->setUserid($userid);
		$privacyobj->setAccessid($accessid);
		$this->doctMgr->persist($privacyobj);
		$this->doctMgr->flush();
		}
	return 0;
	}
	public function deletePrivacyOnToAllFlg($userid)
	{
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f join f.followsid u where f.userid=:userid');
		$query->setParameter('userid',$userid);
		$result=$query->getArrayResult();
		//$userid = $this->doctMgr->find('Application\Entity\userregistration',$userid);
		foreach ($result as $value)
		{
		$query=$this->doctMgr->createQuery('delete from Application\Entity\privacy p where p.userid=:userid AND p.accessid=:accessid ');
		$query->setParameter('userid',$userid);
		$query->setParameter('accessid',$value);
		$result=$query->getArrayResult();
		}
		return 0;
	}
	public function checkPrivacyToAllFlg($userid)
	{
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f join f.followsid u where f.userid=:userid');
		$query->setParameter('userid',$userid);
		$result=$query->getArrayResult();
	
	    foreach ($result as $value)
		{
		$query=$this->doctMgr->createQuery('select count(p.id) as c from Application\Entity\privacy p where p.userid=:userid AND p.accessid=:accessid ');
		$query->setParameter('userid',$userid);
		$query->setParameter('accessid',$value);
		$result=$query->getArrayResult();
		
		}
	return $result[0][c];
	
	}
	public function getCheckboxResultForFlg($userid)
	{
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f join f.followsid u where f.userid=:userid');
		$query->setParameter('userid',$userid);
		$result=$query->getArrayResult();
		foreach ($result as $value)
		{
			$query=$this->doctMgr->createQuery('select count(p.id) as c from Application\Entity\privacy p where p.userid=:userid AND p.accessid=:accessid ');
			$query->setParameter('userid',$userid);
			$query->setParameter('accessid',$value);
			$result=$query->getArrayResult();
		
		}
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}

		
	}
	public function setPrivacyOnToAllFlrs($userid)
	{
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f Join f.userid u where f.followsid=:userid');
		$query->setParameter('userid', $userid);
		$result=$query->getArrayResult();
	    $userid = $this->doctMgr->find('Application\Entity\userregistration',$userid);
		foreach ($result as $value)
		{
	    $privacyobj=new Privacy();
		$accessid= $this->doctMgr->find('Application\Entity\userregistration',$value);
		$privacyobj->setUserid($userid);
		$privacyobj->setAccessid($accessid);
		$this->doctMgr->persist($privacyobj);
		$this->doctMgr->flush();
		}
		return 0;
	}
	public function checkPrivacyToAllFlrs($userid)
	{
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f Join f.userid u where f.followsid=:userid');
		$query->setParameter('userid', $userid);
		$result=$query->getArrayResult();
		foreach ($result as $value)
		{
			$query=$this->doctMgr->createQuery('select count(p.id) as c from Application\Entity\privacy p where p.userid=:userid AND p.accessid=:accessid ');
			$query->setParameter('userid',$userid);
			$query->setParameter('accessid',$value);
			$result=$query->getArrayResult();
		
		}
		return $result;
// 				echo "<pre>";
// 				print_r($result);
// 				die;
		
	}
	public function deletePrivacyOnToAllFlrs($userid)
	{
		$query=$this->doctMgr->createQuery('select u.userid from Application\Entity\followers f Join f.userid u where f.followsid=:userid');
		$query->setParameter('userid', $userid);
		$result=$query->getArrayResult();
		foreach ($result as $value)
		{
			$query=$this->doctMgr->createQuery('delete from Application\Entity\privacy p where p.userid=:userid AND p.accessid=:accessid ');
			$query->setParameter('userid',$userid);
			$query->setParameter('accessid',$value);
			$result=$query->getArrayResult();
		}
		return 0;
		
	}
}


?>
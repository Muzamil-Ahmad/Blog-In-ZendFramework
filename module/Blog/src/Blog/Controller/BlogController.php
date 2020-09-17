<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Blog for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Model\Blog;          // <-- Add this import
use Blog\Form\BlogForm;       // <-- Add this import
use Blog\Model\BlogModel;
use Blog\Form\BlogFormReg;
use Application\Entity\Blogtable;
use Blog\Form\ReadForm;
use Application\Entity\Commenttable;
use Application\Entity\Comenttable;
use Doctrine\ORM\EntityManager;
use Application\Entity\Likes;
use Application\Entity\Tasklist;
use Blog\Form\AddTaskForm;
use Blog\Form\MytaskForm;
use Zend\View\Model\JsonModel;
use Blog\Form\UserProfile;
use Blog\Form\EditProfile;
use Blog\Form\EditProfileForm;
class BlogController extends AbstractActionController
{
	public  function __construct()
	{
		
	}
    public function indexAction()
    {
    	session_start();
    	$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    	$blogModel = new blogModel($em);
    	$postdata = $blogModel->getAllTasks();
    	
    	if(isset($_SESSION['userid']))
    	{
    		$userid=$_SESSION['userid'];
    		$getfollowingactivities=$blogModel->getFollowingActivities();
    		$getFollowingComment=$blogModel->getFollowingCommentActivities($userid);
    		$likesactivities=$blogModel->getFollowingLikesActivities();
    		$myfollowers=$blogModel->getMyFollowers($userid);
    		$getactivities=array_merge($getfollowingactivities,$getFollowingComment,$likesactivities,$myfollowers);
    		$size=count($getactivities);
    		for($i=0; $i<$size-1; $i++)
    		{
    		for($j=$i+1;$j<=$size-1;$j++)
    		{
    		$dateToNumberConversion1=strtotime(date_format($getactivities[$i]['createDate'],'Y-m-d h:i:s'));
    				$dateToNumberConversion2=strtotime(date_format($getactivities[$j]['createDate'],'Y-m-d h:i:s'));
    				if($dateToNumberConversion2 > $dateToNumberConversion1)
    				{
    				$min = $getactivities[$j];
    				$getactivities[$j] = $getactivities[$i];
    				$getactivities[$i] = $min;
    				}
    				} 
    				}

    				return new ViewModel(['records'=>$postdata,'activities'=>$getactivities]);
        }
        return new ViewModel(['records'=>$postdata]);
    	
    }
	public function newpostAction()
	{
		session_start();
		$form= new BlogForm();
		$data = new Blogtable();
		$form->bind($data);
		$request = $this->getRequest();		
		if($request->isPost())
		{
			$form->setData($request->getPost());
			if($form->isValid())
			{
				$em = $this->getServiceLocator()
				->get('doctrine.entitymanager.orm_default');
				$blogModel = new BlogModel($em);
				if(isset($_SESSION['userid']))
				{
					$user = $_SESSION['userid'];
					
				}
				$ispicture=$_FILES['userphoto']['name'];
				if ($ispicture)
				{
				$fileName =time().'-'. $_FILES['userphoto']['name'];
				$tempfile =$_FILES['userphoto']['tmp_name'];
				
				 
				$filePath ="public/img/".$fileName;
				move_uploaded_file($tempfile,$filePath);
				
				$blogModel->addPost($data,$user,$fileName);
				return $this->redirect()->toRoute('blog');
				}
				else 
				{
					$blogModel->addPost($data,$user,null);
					return $this->redirect()->toRoute('blog');
				}
			}
		}
           
		return new ViewModel(['form'=>$form]);
		
		
	}
	public function readmoreAction()
	{
		session_start();
		$form=new ReadForm();
    	$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    	$blogModel= new blogModel($em);
    	
    	$id=$this->params('id');
 		try{
    		
    		$result = $blogModel->getData($id);
    		$comments = $blogModel->getComment($id);
    		$count=$blogModel->CountLike($id);
    		$uid=$_SESSION['userid'];
    		if(isset($_SESSION['userid']))
    		{
    		$checkuser=$blogModel->checklikestatus($uid,$id);
    		}

    	   }
    	catch (\PDOException $e)
    		{
    		return $this->redirect()->toRoute('blog');
    		}
    	return new ViewModel(['form'=>$form,'iddata'=>$result,'mycomments'=>$comments,'count'=>$count,'likestatus'=>$checkuser]);
	}
	public function mypostsAction()
	{
	
		session_start();
		$form=new ReadForm();
		if(isset($_SESSION['userid']))
		{	
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$blogModel= new blogModel($em);
		$id=$_SESSION['userid'];
		  try{
			$result = $blogModel->getMyposts($id);
		     }
		    catch (\PDOException $e)
		    {
			return $this->redirect()->toRoute('blog');
		    }
		        return new ViewModel(['myposts'=>$result]);
		    }
		   else
		      {
		      	echo "<script>alert('You are a unknown person!')</script>";
		        die;
			      return $this->redirect()->toRoute('blog');
			      
		      }
	
	}
public function editAction()
{
		
		session_start();
		$form= new BlogForm();
		$data = new Blogtable();
		$form->bind($data);
		$id = $this->params('id');
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$blogModel = new BlogModel($em); 
		try{
			$data = $blogModel->editPost($id);
			$dat=$data[0]['userphoto'];
			}
		catch (\PDOException $e)
			{
			return $this->redirect()->toRoute('blog');
			}
				$form->setData($data[0]);
				
			
	$request = $this->getRequest();
	if($request->isPost())
	{
				
				$form->setData($request->getPost());
				if($form->isValid())
				{
					$em = $this->getServiceLocator()
					->get('doctrine.entitymanager.orm_default');
					
					$blogModel = new BlogModel($em);
					
					$ispicture=$_FILES['userphoto']['name'];
					if ($ispicture)
					{
					$fileName =time().'-'. $_FILES['userphoto']['name'];
					$tempfile =$_FILES['userphoto']['tmp_name'];
					
						
					$filePath ="public/img/".$fileName;
					move_uploaded_file($tempfile,$filePath);
					$blogModel->updatePost($request,$id,$fileName);
					$cres=unlink("public/img/".$dat);
					return $this->redirect()->toRoute('blog');
					}
					else
					{
						$blogModel->updatePost($request, $id, null);
						return $this->redirect()->toRoute('blog');
					}
				}			
	}	
		return new ViewModel(array('form'=>$form,'id'=>$id));
}
public function commentAction()
{
	session_start();
	$request=$this->getRequest();
	If($request->isPost())
	{
		$data=$request->getPost();
		$postid=$data['postid'];
		$_SESSION['postid']=$postid;  //not used in commentAction check later
		$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$blogModel=new BlogModel($em);
		$blogModel->submitComment($data);
// 		$result = $blogModel->getComment($postid);
// 		$postid=$data['postid'];
// 		echo $postid;
// 		die;
//    echo "<prev>";
//    print_r($result);
//    die;
	echo json_encode($data);
	die;
	}
}
public function likeAction()
{
	session_start();
	$request = $this->getRequest(); // it is used at page refresh
	if($request->getPost())
	{
		    $data=$request->getPost();
			$em = $this->getServiceLocator()
			->get('doctrine.entitymanager.orm_default');
			$blogModel = new BlogModel($em);
			if(isset($_SESSION['userid']))
			{
				$userid = $_SESSION['userid'];
			}		
					$postid = $data['id'];
					$count=$blogModel->checkUserLike($userid,$postid);
					if(!$count)
					{
				      $blogModel->addLike($userid,$postid);
					}
					else 
					{
						$blogModel->deleteLike($userid,$postid);
					}
// 					$countlike = $blogModel->CountLike($postid);
// 					echo "<prev>";
// 					print_r($countlike);
// 					die;
// 					echo json_encode(countlike);
//                    die;	
	}
// 	$buttontext=$blogModel->buttonstatus($userid,$postid);
	$countlike = $blogModel->CountLike($postid);
// 	return new JsonModel(['countlike'=>$countlike]);
	
	echo json_encode($countlike[0]);
	die;
}
Public function editcommentAction()
{
	
	    session_start();
	    $postid=$_SESSION['postid'];
		$form= new BlogForm();
		$data = new Comenttable();
		$form->bind($data);
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$blogModel = new BlogModel($em); 
		$request = $this->getRequest();
		if($request->isPost())
		{
			$form->setData($request->getPost());		
				$em = $this->getServiceLocator()
				->get('doctrine.entitymanager.orm_default');
				$blogModel = new BlogModel($em);
				$blogModel->updateComment($request);
				return $this->redirect()->toUrl('readmore/'.$postid);
// 				return $this->redirect()->toRoute('blog');
		
        }
}

   public function addtaskAction()
   {     
   
   		session_start();
	   	$form = new AddTaskForm();
	   	$em = $this->getServiceLocator()
	   	->get('doctrine.entitymanager.orm_default');
	   	$blogModel = new BlogModel($em);
	   	$request = $this->getRequest();
	   	   	if($request->isPost())
		   	{
		   		$data= $request->getPost();
// 		   	if($form->isValid())
// 		   	{
		   	     $blogModel->addTask($data);
// 		   	}
              echo json_encode("true");
              die;
		   	}
		   	else{
		   
		   	$result=$blogModel->getMytasks();
		   	$completed=$blogModel->getmycompletedTasks();
		   	
    		return new ViewModel(['form'=>$form,'results'=>$result,'completed'=>$completed]);
		   	}
    	}
    	public function updatetaskstatusAction()
    	{
//     		echo date("Y-m-d");
//     		die;
    		$request = $this->getRequest();
    		$data= $request->getPost();
    		$em = $this->getServiceLocator()
    		->get('doctrine.entitymanager.orm_default');
    		$blogModel = new BlogModel($em);
    		$completeddate=$blogModel->updatetable($data);
    		echo json_encode($completeddate);
    		die;
    	}
    public function undotaskstatusAction()
    {
            $request = $this->getRequest();
    		$data= $request->getPost();
    		$em = $this->getServiceLocator()
    		->get('doctrine.entitymanager.orm_default');
    		$blogModel = new BlogModel($em);
    		$blogModel->undotable($data);
    		
//     		if($status == 0){
//     			print_r('error');
//     			die;
//     		}else{
    		echo json_encode("true");
    		die;
//     			return new JsonModel();
//     		}
    		
    }	
    Public function userprofileAction()
    {
	    	session_start();
	    	$id=$this->params('id');
	    	$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    	$blogModel=new BlogModel($em);
	    	$result=$blogModel->getUserprofile($id);
	    	$checkstatus=$blogModel->checkfollowstatus($id);// it returns no of following row 
	    	$followerCounter=$blogModel->countFollowers($id);
	    	$followingCounter=$blogModel->countFollowing($id);

	    	if ($_SESSION['userid']==$id)
		    	{
		    	$checkprivacy=$blogModel->getCheckboxResultForFlg($_SESSION['userid']);
	    	   	$checkprivacyflw=$blogModel->checkPrivacyToAllFlrs($_SESSION['userid']);
	    	   	if($checkprivacyflw[0]['c']>0)
	    	   	{
	    	   		$setFlw=true;
	    	   	}
	    	   	else 
	    	   	{
	    	   		$setFlw=false;
	    	   	}
	    	   	if($checkprivacyflw>0)
	    	   	{
	    	   		$setFlr=true;
	    	   	}
	    	   	else
	    	   	{
	    	   		$setFlr=false;
	    	   	}
		    	$followers=$blogModel->getFollowers($id);
	    	   	$following=$blogModel->followingTo($id);
	    	   	$newFollowing=[];
	    	   	$newFollower=[];
	    	   	foreach ($following as $follow)// Not checked.
	    	   	{
	    	   		$resultswitch=$blogModel->checkPrivacy($follow['followsid']['userid']);
	    	   		if($resultswitch)
	    	   		{
	    	   			array_push(
	    	   			$newFollowing,
	    	   			array_merge($follow,['checked'=>$resultswitch[0]['c']]));
	    	   	
	    	   		}
	    	   		else
	    	   		{
	    	   			array_push(
	    	   			$newFollowing,
	    	   			array_merge($follow,['checked'=>$resultswitch[0]['c']]));
	    	   		}
	    	   		 
	    	   	}
// 	    	   	echo "<pre>";
// 	    	   	print_r($followers);
// 	    	   	die;
	    	   	foreach ($followers as $follow)
	    	   	{
	    	   		
	    	   		$resultswitch=$blogModel->checkPrivacy($follow['userid']['userid']);
	    	   		if ($resultswitch)
	    	   		{
	    	   			array_push(
	    	   			$newFollower,
	    	   			array_merge($follow,['checked'=>$resultswitch[0]['c']]));
	    	   	
	    	   		}
	    	   		else
	    	   		{
	    	   			array_push(
	    	   			$newFollower,
	    	   			array_merge($follow,['checked'=>$resultswitch[0]['c']]));
	    	   		}
	    	   	
	    	   	}

	    	   	
	    	    return new ViewModel(['result'=>$result,'followstatus'=>$checkstatus,'followers'=>$newFollower,'followerCounter'=>$followerCounter,'following'=>$newFollowing,'followingCounter'=>$followingCounter,'all'=>$setFlw,'allFlr'=>$setFlr]);
		    	}
	    	    else
		    	{
		    		
		    		$res=$blogModel->getPrivacy($id);
	    			    	  
		    		if($res)// problem here.
		    		{
		    			
		    			
		    			$followers=$blogModel->getFollowers($id);
		    			$following=$blogModel->followingTo($id);
// 		    			echo "<pre>";
// 		    			print_r($following);
// 		    			die;
		    			
		    			return new ViewModel(['result'=>$result,'followstatus'=>$checkstatus,'followers'=>$followers,'followerCounter'=>$followerCounter,'following'=>$following,'followingCounter'=>$followingCounter]);
		    		}
		    		
		    	}
	    	return new ViewModel(['result'=>$result,'followstatus'=>$checkstatus,'followerCounter'=>$followerCounter,'followingCounter'=>$followingCounter]);
   }
   public function editprofileAction()
   {
//    	echo "editprofile";
//    	die;
	   	session_start();
	   	$userprofileform = new EditProfileForm();
	   	$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	   	$blogModel=new BlogModel($em);
	   	$request=$this->getRequest();
	   	$userid=$this->params('id');
	   
	   	if($request->isPost())
	   	{
	   		$data=$request->getPost();
	   		$ispicture=$_FILES['profile']['name'];
	   		if ($ispicture)
	   		{
	   			$fileName =time().'-'. $_FILES['profile']['name'];
	   			$tempfile =$_FILES['profile']['tmp_name'];
	   			$filePath ="public/img/".$fileName;
	   			move_uploaded_file($tempfile,$filePath);
	   			$blogModel->updateProfile($data,$userid,$fileName);
	   		}
	   		return $this->redirect()->toUrl('/blog/userprofile/'.$userid);
	   	}
	   	$results=$blogModel->getUserdata($userid);
// 	   	return json_encode("true");
// 	   	die;
	   	return new ViewModel(['form'=>$userprofileform,'results'=>$results]);
	 
   	
   }
   public function followAction()
   { 
   	 session_start();
   	 $request=$this->getRequest();
   	 if($request->isPost())
   	 {
   	 	$data=$request->getPost();
   	 	$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
   	 	$blogModel=new BlogModel($em);
   	    $count=$blogModel->checkFollower($data);
   	    if($count)
   	    {
   	    	$blogModel->deleteFollower($data);
   	    }
   	    else
   	    {
   	    	$blogModel->setFollower($data);
   	    	
   	    }
   	    $followerCounter=$blogModel->countFollowers($data['id']);
   	    echo $followerCounter;
   	    die;
//    	   return json_encode($followerCounter);
//    	   die;
   	 
   	 }
   	 
   	
   	
   }
   public function changePhotoAction()
   {
   		session_start();
   	    $request=$this->getRequest();
   	    $data=$request->getPost();
    	if ( 0 < $_FILES['file']['error'] ) {
   		echo 'Error: ' . $_FILES['file']['error'] . '<br>';
   	    }
   	    else {
   	   	$em = $this->getServiceLocator()
   	   	->get('doctrine.entitymanager.orm_default');
   	   	$blogModel = new BlogModel($em);
   	   	$fileName =time().'-'. $_FILES['file']['name'];
   	   	$tempfile =$_FILES['file']['tmp_name'];
   	   	$filePath ="public/img/".$fileName;
   	   	move_uploaded_file($tempfile,$filePath);
   	    $res=$blogModel->changePhoto($data,$fileName);
//    	    print_r($res[0]['profile']);
//    	    die();
   	    $ret  =  unlink("public/img/".$res[0]['profile']);
   	    echo $fileName;
   	    die;
   	   }	
   }
   public function changePrivacyAction()
   {
	   	session_start();
	   	$request=$this->getRequest();
	   	if($request->isPost())
	   	{
		    $data=$request->getPost();
		    $em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		    $blogModel= new BlogModel($em);
		    $id=$data['id'];
		    $result=$blogModel->checkPrivacy($id);
		    if($result[0]['c']>0)
		    {
		    	$result=$blogModel->deletePrivacy($data);
		    }
		    else 
		    {
		    	$result=$blogModel->setPrivacy($data);
		    }
	   	}
   	
   }
   public function changePrivacyToAllFlgAction()
   {
   	     session_start();
   		$userid=$_SESSION['userid'];
   		$request=$this->getRequest();
   		if($request->getPost())
   		{
   			$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
   			$blogModel=new BlogModel($em);
   			$result=$blogModel->checkPrivacyToAllFlg($userid);
   			if($result>0)
   			{
   				$blogModel->deletePrivacyOnToAllFlg($userid);
   				return json_encode(false);
   				 
   			}
   			else
   			{
   				$blogModel->setPrivacyOnToAllFlg($userid);
   				return json_encode(true);
   				 
   			}
   			
   		}
   		
   }
   public function changePrivacyToAllFlrsAction()
   {
   	session_start();
   	$userid=$_SESSION['userid'];
   	$request=$this->getRequest();
   	if($request->getPost())
   	{
   		$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
   		$blogModel=new BlogModel($em);
   		$result=$blogModel->checkPrivacyToAllFlrs($userid);
   		if($result[0]['c']>0)
   		{
   			$blogModel->deletePrivacyOnToAllFlrs($userid);
   			return json_encode(false);
   
   		}
   		else
   		{
   			$blogModel->setPrivacyOnToAllFlrs($userid);
   			return json_encode(true);
   
   		}
   
   	}
   	 
   }
} 
 
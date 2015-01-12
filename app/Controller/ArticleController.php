<?php
//this is controller
class ArticleController extends AppController{
	
	//set layout for all action in this controller
	//var $layout = 'masterLayout';
	//set helper
	public $helpers = array('Html', 'Form', 'Js','Text' );
	//set object model
	var $uses = array('Location','Article','ArticleContent','ArticleContentImage','Anime','User','ArticleLocation','Comment'); 
	//set JSON
	public $components = array('RequestHandler','Session');
	
//action
	
	public function index(){		
		return $this->redirect(
			array('action' => 'Home')
		);
	}
	
	public function Home(){
		//echo $check = $this->Session->read('check');
		$this->set('UserId',$this->Session->read('UserId'));
		
		$this->set('UrlName',$this->U);
		
		$this->set('ArticleData',$this->Article->find('all'));
		$this->set('ArticleCount',$this->Article->find('count'));
		$this->set('UserData',$this->User->find('all'));
		$this->set('UserCount',$this->User->find('count'));
		
		$AnimeData = $this->Anime->find('all');
		$AnimeCount = count($AnimeData);
		
		$this->set('AnimeData',$AnimeData);
		$this->set('AnimeCount',$AnimeCount);

		//Count comment
		$CommentData = $this->Comment->find('all');
		$this->set('CommentData',$CommentData);
		$this->set('CommentCount',count($CommentData));
		$CommentCount = count($CommentData);
		
		//sort amount of Comment to find Article
		
		//find all of article id into array
		for($i=0;$i<$CommentCount;$i++)
		{			
			$CommentArticle[$i] = $CommentData[$i]['Comment']['article_id'];
		}
		
		//count the frequency of amount of array
		$CommentAmount = array_count_values($CommentArticle);
		//sort array from high to low
		arsort($CommentAmount);
		//change format array find the id of Article high to low
		$Ranking = array_keys($CommentAmount);
		
		$this->set('Ranking',$Ranking);
		$ArticleContentImageData = $this->ArticleContentImage->find('all');
		$this->set('ArticleContentImageData',$ArticleContentImageData);
		$this->set('ArticleContentImageCount',count($ArticleContentImageData));
		
						
	}
	
	public function Show(){
		$this->set('LocationData',$this->Location->findByLocationId(10));
		
		$LocationJSON = $this->Location->find('all');
		$ArticleLocationJSON = $this->ArticleLocation->find('all');
		
		$this-> set(compact('LocationJSON'));
		$this-> set(compact('ArticleLocationJSON'));
		
		$this->set('_serialize',array('LocationJSON','ArticleLocationJSON'));
	}
	
	public function NewArticle(){
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		
		//set Location all data by UserId
		$this->set('LocationData',$this->Location->find('all',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		//set count number of row by UserId
		$this->set('LocationCount', $this->Location->find('count',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		if($this->request->is('post'))
		{

			//------------------- this is for save to Article and Anime Model  -----------------------------------//
			
			//get post data of Article and Anime model
			$ArticleTitle = $_POST['article_title'];
			$Summary = $_POST['summary'];
			
			//insert datata Anime model
			/*
			$this->Anime->create();
			$this->Anime->Save(array(
				'anime_title' => $AnimeTitle
			));
			*/
			
			//get last id of Anime model
			$AnimeId = $this->Anime->getLastInsertId();

			//insert data to Article model
			$this->Article->create();
			$this->Article->save(array(
					'user_id' => $UserId,
					'article_title' => $ArticleTitle,
					'summary' => $Summary,
					'article_date' => date('Y-m-d G:i:s'),
			));
							
			$ArticleId = $this->Article->getLastInsertId();
			
			//validate image
			if($_FILES['ArticleImage']['error'])
			{
				//for not show error 
			}
			else
			{
				//save image for Article
				$ArticleFilename = 'img/'.$ArticleId.'_article.jpg';
				$ImageLink=rename($_FILES['ArticleImage']['tmp_name'],WWW_ROOT.$ArticleFilename);
				
				$this->Article->ArticleId = $ArticleId;
				$this->Article->save(array(
						'article_image_name' => $ArticleId.'_article.jpg',			
				));
			}

			//---------- This is for save to ArticleContent and ArticleContentImage Model----------------------------------//
			
			//get post data of ArticleContent and ArticleContentImage 
			echo $SetFeildCount = $_POST['set_feild_count'];
			
			//Validate image for ArticleContentImage
			$FileArray = $this->request->data['ArticleImage_0'];
			
			//Save text data to ArticleContent

			if($FileArray=="")
			{}
			else{ 
				//Save to ArticleContent
				for($i=0;$i<$SetFeildCount;$i++)
				{
					$LocationName = $_POST['location_name_'.$i];
					$ArticleDetail = $_POST['article_detail_'.$i];
					$this->ArticleContent->create();
					$this->ArticleContent->save(array(
							'article_id' => $ArticleId,
							'article_location_name' => $LocationName,
							'detail' => $ArticleDetail,
							'article_content_date' => date('Y-m-d G:i:s')
					));
					
					$ArticleContentId = $this->ArticleContent->getLastInsertId();
					
					$FileArray = $this->request->data['ArticleImage_'.$i];
					$FileCount=count($FileArray);
					var_dump($FileArray);
					
					
					//Save to ArticleContentImage
					for($l=0;$l<$FileCount;$l++)
					{
						$this->ArticleContentImage->create();
						$ArticleContentFilename = '/img/article_'.$ArticleId."_set".$i."_no".$l.".jpg";
						$ImageLink=rename($FileArray[$l]['tmp_name'],WWW_ROOT.$ArticleContentFilename);
						
						$this->ArticleContentImage->save(array(
							'article_content_id' => $ArticleContentId,
							'article_id' => $ArticleId,	
							'image_name' => $ArticleContentFilename
						));
					}//end for loop FileCount
					
					$this->Session->write('ArticleId',$ArticleId);
					
				}//end　for loop Set
				
			}//end else	
			
			//When Everything are done
			$this->redirect(array(
				'action' => 'SelectLocation'
			));
											
		}//end if post request
		
	}//end function
	
	
	public function SelectLocation(){
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		$ArticleId = $this->Session->read('ArticleId');

		$this->set('ArticleContentData',$this->ArticleContent->find('all',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleContentCount',$this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$ArticleContentCount = $this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$this->set('LocationData',$this->Location->find('all',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		$this->set('LocationCount',$this->Location->find('count',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		
		if($this->request->is('post'))
		{
			for($i=0;$i<$ArticleContentCount;$i++)
			{
				echo "<br/>location id:".$_POST['ArticleLocation_'.$i];
				$LocationId = $_POST['ArticleLocation_'.$i];
				$ArticleLocationName = $_POST['article_location_name_'.$i];
				$LocationData = $this->Location->findByLocationId($LocationId);
				
				$Lat = $LocationData['Location']['latitude'];
				$Long = $LocationData['Location']['longitude'];
				$LocationMemo = $LocationData['Location']['location_memo'];
				
				$this->ArticleLocation->create();
				$this->ArticleLocation->save(array(
					'article_id' => $ArticleId,
					'article_location_name' => $ArticleLocationName,	
					'location_id' => $LocationId,
					'location_memo' => $LocationMemo,	
					'latitude' => $Lat,
					'longitude' => $Long		 	
				));
								
			}
			
			//everything is done
			$this->redirect(array(
				'action' => 'home'
			));
		
		}
		
	}//end SelectLocation function
		
	public function ShowArticle($ArticleId = null)
	{
		$this->set('UserId',$this->Session->read('UserId'));
		$this->set('ArticleId',$ArticleId);
		
		///////////////////////////////////////////////////////////////////////
		
		$ArticleData = $this->Article->findByid($ArticleId);
		
		$this->set('ArticleData',$this->Article->findByid($ArticleId));
				
		$AnimeData = $this->Anime->findByAnimeId($ArticleData['Article']['anime_id']);
		
		$this->set('AnimeData',$AnimeData);
		
		$this->set('ArticleContentData',$this->ArticleContent->find('all',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleContentCount',$this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleLocationCount', $this->ArticleLocation->find('count',array(
			'conditions' => array('ArticleLocation.article_id' => $ArticleId )	
		)));
		
		$ArticleContentImageData = $this->ArticleContentImage->find('all',array(
			'conditions' => array('ArticleContentImage.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentImageData',$ArticleContentImageData);
		$this->set('ArticleContentImageCount',count($ArticleContentImageData));
	}
	
	public function Comment()
	{
		$UserId = $this->Session->read('UserId');
				
		$CommentJSON = $this->Comment->find('all');
		
		$this-> set(compact('CommentJSON'));
		
		$this->set('_serialize',array('CommentJSON'));
		
		if($this->request->is('post'))
		{
			$Comment = $_POST['comment'];
			$ArticleId = $_POST['article_id'];
			$PenName = $this->User->findByUserId($UserId);
			
			if($Comment != "")
			{	
				$this->Comment->create();
				$this->Comment->save(array(
					'article_id' => $ArticleId,
					'user_id' => $UserId,
					'pen_name' => $PenName['User']['pen_name'],	
					'comment' => $Comment,
					'comment_date' => date('Y-m-d G:i:s')	
				));
			}
		}//end request port
		
	}//end Comment function
	
	public function Search()
	{
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		
		if($this->request->is('post'))
		{
			//get search text
			$SearchResult = $this->request->data['Article']['search'];
			
			//set search text
			$this->set('SearchResult',$SearchResult);
			
			//find Anime Keyword that match 
			$AnimeResult = $this->Anime->find('all');
			$AnimeResultCount = count($AnimeResult);
						
			//var_dump($AnimeResult);
			
			//check search result that
			
			//no result 
			if(empty($AnimeResult))
			{
				$this->Session->setFlash("No Search Result");
				$this->set('AnimeCount',0);
			}
			//have result
			else if(!empty($AnimeResult))
			{
				$this->set('ArticleData',$this->Article->find('all'));
				$this->set('ArticleCount',$this->Article->find('count'));
				
				$this->set('AnimeData',$AnimeResult);
				$this->set('AnimeCount',$AnimeResultCount);
				
				$this->set('UserData',$this->User->find('all'));
				$this->set('UserCount',$this->User->find('count'));
				
				//Count comment
				$CommentData = $this->Comment->find('all');
				$this->set('CommentData',$CommentData);
				$this->set('CommentCount',count($CommentData));
				$CommentCount = count($CommentData);
				
			}			
		}//end if request post
		else
		{
			$this->Session->setFlash("<script>alert('Enter keyword first')</script>");
			$this->redirect(array(
				'controller' => 'Article',
				'action' => 'Home'	
			));
		}	
	
	}//end search function 
	
	public function Delete($ArticleId = null){
		
		$UserId = $this->Session->read('UserId');
		
		$ArticleData = $this->Article->findById($ArticleId);
		$ArticleContentData = $this->ArticleContent->findByArticleId($ArticleId);
		$ArticleContentImageData = $this->ArticleContentImage->findByArticleContentId($ArticleContentData['ArticleContent']['id']);
		$ArticleLocationData = $this->ArticleLocation->findByArticleId($ArticleId);
		$CommentData = $this->Comment->findByArticleId($ArticleId);		
		
		//delete image
		unlink($_SERVER['DOCUMENT_ROOT']."/app/webroot/".$ArticleData['Article']['article_image_name']);
		
		$ImageContentName = $this->ArticleContentImage->find('all',array(
								'conditions' => array('ArticleContentImage.article_id' => $ArticleId)			
							));
		$CountImageContentName = count($ImageContentName);
				
		for($i=0;$i<$CountImageContentName;$i++){
			unlink($_SERVER['DOCUMENT_ROOT']."/app/webroot".$ImageContentName[$i]['ArticleContentImage']['image_name']);
		}
		
		
		//delete text data
		$this->Article->delete($ArticleId);
		$this->Anime->delete($ArticleData['Article']['anime_id']);
		$this->ArticleContent->deleteAll(array(
			'ArticleContent.article_id' => $ArticleId
		));
		$this->ArticleContentImage->deleteAll(array(
			'ArticleContentImage.id' => $ArticleContentImageData['ArticleContentImage']['id']
		));
		$this->ArticleLocation->deleteAll(array(
			'ArticleLocation.article_id' => $ArticleId			
		),false);		
		$this->Comment->deleteAll(array(
			'Comment.article_id' => $ArticleId
		));
		
		
		$this->redirect(array(
			'controller' => 'User',	
			'action' => 'UserPage',$UserId
		));
		
				
	}//end delete function
	
	public function EditArticle($ArticleId = null)
	{
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		//set Article Data
		$ArticleData = $this->Article->findByid($ArticleId);
		$this->set('ArticleData',$ArticleData);
		
		//set Anime data
		$AnimeData = $this->Anime->findByAnimeId($ArticleData['Article']['anime_id']);
		$this->set('AnimeData',$AnimeData);
		
		//set ArticleContent Data
		$ArticleContentCount = $this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		$ArticleContentData = $this->ArticleContent->find('all',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentCount',$ArticleContentCount);
		$this->set('ArticleContentData',$ArticleContentData);
		
		//set ArticleContentImage Data
		$ArticleContentImageCount = $this->ArticleContentImage->find('count',array(
			'conditions' => array('ArticleContentImage.article_id' => $ArticleId)
		));
		$ArticleContentImageData = $this->ArticleContentImage->find('all',array(
				'conditions' => array('ArticleContentImage.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentImageCount',$ArticleContentImageCount);
		$this->set('ArticleContentImageData',$ArticleContentImageData);
		
		//debug
		/*
		var_dump($ArticleData);
		var_dump($ArticleContentData);
		var_dump($ArticleContentImageCount);
		*/
		
		if($this->request->is('post'))
		{			
			//get post data of Article and Anime model
			$ArticleTitle = $_POST['article_title'];
			//$AnimeTitle = $_POST['anime_title'];
			$Summary = $_POST['summary'];

			//update Article image
			if($_FILES['ArticleImage']['error'])
			{}
			else
			{
				$ArticleFilename = 'img/'.$ArticleId.'_article.jpg';
				$ImageLink=rename($_FILES['ArticleImage']['tmp_name'],WWW_ROOT.$ArticleFilename);
				
			}
										
			//update Anime data
			/*
			$AnimeDataUpdate = array('anime_id' => $AnimeData['Anime']['anime_id'], 'anime_title' => $AnimeTitle);
			$this->Anime->Save($AnimeDataUpdate);
			*/
			
			//update Article data
			$ArticleDataUpdate = array(
				'id' => $ArticleId,
				'article_title' => $ArticleTitle,
				'summary' => $Summary,
				'article_update_date' => date('Y-m-d G:i:s'),					
			);
			
			$this->Article->save($ArticleDataUpdate);
											
			for($i=0;$i<$ArticleContentCount;$i++)
			{
				$LocationName = $_POST['location_name_'.$i];
				$ArticleDetail = $_POST['article_detail_'.$i];
				
				//update ArticleContent Image
				$FileArray = $this->request->data['ArticleImage_'.$i];
				$FileCount=count($FileArray);
				
				//debug($FileArray);
				//debug($FileCount);
				
				if($FileArray[0]['size'] == 0){
					// do noting
				}
				else{				
					for($l=0;$l<$FileCount;$l++)
					{
						$ArticleContentFilename = 'img/article_'.$ArticleId."_set".$i."_no".$l.".jpg";
						$ImageLink=rename($FileArray[$l]['tmp_name'],WWW_ROOT.$ArticleContentFilename);
					}
				}
				
				//update ArticleContent data
				$ArticleContentDataUpdate = array(
						'id' => $ArticleContentData[$i]['ArticleContent']['id'],
						'article_id' => $ArticleId,
						'article_location_name' => $LocationName,
						'detail' => $ArticleDetail,
				);
				$this->ArticleContent->save($ArticleContentDataUpdate);
				
				//update ArticleLocation data
				$ArticleLocationData = $this->ArticleLocation->find('all',array(
						'conditions' => array('ArticleLocation.article_id' => $ArticleId)
				));
				$ArticleLocationCount = $this->ArticleLocation->find('count',array(
						'conditions' => array('ArticleLocation.article_id' => $ArticleId)
				));
					
			}//end for loop
			
			for($l=0;$l<$ArticleLocationCount;$l++)
			{
			$ArticleLocationUpdate = array(
					'id' => $ArticleLocationData[$l]['ArticleLocation']['id'],
					'article_location_name' => $_POST['location_name_'.$l]
			);
					$this->ArticleLocation->save($ArticleLocationUpdate);
			}
			
									
		}//end if post request
		
	}// end EditArticle function
	
	public function EditLocation($ArticleId = null){
		
		$UserId = $this->Session->read('UserId');
		
		$this->set('ArticleContentData',$this->ArticleContent->find('all',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleContentCount',$this->ArticleContent->find('count',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$ArticleContentCount = $this->ArticleContent->find('count',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$LocationData = $this->Location->find('all',array(
				'conditions' => array('Location.user_id' => $UserId)
		));
		
		$this->set('LocationData',$LocationData);
		
		$this->set('LocationCount',$this->Location->find('count',array(
				'conditions' => array('Location.user_id' => $UserId)
		)));
		
		$ArticleLocationData = $this->ArticleLocation->find('all',array(
				'conditions' => array('ArticleLocation.article_id' => $ArticleId)
		));

		$ArticleLocationCount = $this->ArticleLocation->find('count',array(
				'conditions' => array('ArticleLocation.article_id' => $ArticleId)
		));
		
		$this->set('ArticleLocationData',$ArticleLocationData);
		$this->set('ArticleLocationCount',$ArticleLocationCount);
		
		var_dump($LocationData);
		
	}//end EditLocation function

}//end class


















?>
<style type="text/css" media="all">
img{
max-height:200px;
max-width:200px;
}	
</style>

<?php

/* not login case */

if($UserId=="")
{
echo $this->Html->link('Login Page',array(
	'controller' => 'User',
	'action' => 'Login'
));

echo "<br/>";


echo $this->Html->link('Register',array(
	'controller' => 'User',
	'action' => 'Register'
));

}//end if

/* Logined case */

else{

echo "<br/>";

echo $this->Html->link('New Article',array(
	'action' => 'NewArticle'
));


echo "<br/>";

echo $this->Html->link('Locate Current Location',array(
	'controller' => 'Location',
	'action' => 'CurrentLocation'
));

echo "<br/>";

echo $this->Html->link('Search Location',array(
	'controller' => 'Location',
	'action' => 'SearchLocation'
));

echo "<br/>";

	
echo $this->Html->link('My page マイページ',array(
			'controller' => 'User',
			'action' => 'UserPage',$UserId
			),
			array(
				'id' => 'menu_link'
			)
		);

echo "<br/>";

echo $this->Html->link('Logout',array(
	'controller' => 'User',
	'action' => 'Logout'
));

}//end if
?>


<h2>Search Field</h2>

<?php
echo $this->Form->create('Article',array(
	'type' => 'post',
	'url' => array('controller' => 'Article','action' => 'Search'),
));
?>

  <input class="search_bar" 
	 name="data[Article][search]" 
	 type="search"
	  placeholder="Title Name" 
	>

<?php	
	
echo $this->Form->input('Search',array('type' => 'submit','label' => false,'id' => 'search_button'));
echo $this->Form->end();
?>

<h2>List of Article</h2>

<?php
for($i=$ArticleCount-1;$i>=0;$i--)
{
?>
<div id="article_content">

	<div id="article_content_bg">
		<!-- article image -->
		<div id="article_image_content">	
		<?php
			echo $this->Html->image($ArticleData[$i]['Article']['article_image_name'],array(
				'id' => 'article_image'
			));
		?>
		
		<br/>
		</div>
		<!--end article_image_content -->

	</div>
	<!-- end div article_content_bg  -->
	
	<!-- article topic -->
	<div id="article_topic">

	<?php
		echo $this->Html->link($ArticleData[$i]['Article']['article_title'],array(
			'controller' => 'Article',
			'action' => 'ShowArticle',$ArticleData[$i]['Article']['id']
		));
	?>
	</div>
	
	<!-- Anime Name -->
	<div id="article_anime">
	<?php 	
		for($l=0;$l<$AnimeCount;$l++)
		{	
			if($ArticleData[$i]['Article']['anime_id']==$AnimeData[$l]['Anime']['anime_id'])
			{	
				echo $AnimeData[$l]['Anime']['anime_title'];
			}	
		}
		echo "<br/>";
	?>
	</div>

	<!-- Article Date -->
	<div id="article_date">
		<?php
			echo $ArticleData[$i]['Article']['article_date'];
		?>
	</div>
		
	<!-- Comment Amount -->
	<?php
		$Count=0;
		for($k=0;$k<$CommentCount;$k++)
		{
			if($ArticleData[$i]['Article']['id']==$CommentData[$k]['Comment']['article_id'])
			{
				$Count++;
			}
			
		}//end loop			
	?>		
	<div id="comment_amount_line">
		<div id="comment_amount"><?php echo $Count; ?> Comment</span>
		</div>
	</div>

<div id="article_border"></div>	
	
</div>
<!-- end div article content -->	  
<?php 	
}//end for 
?>


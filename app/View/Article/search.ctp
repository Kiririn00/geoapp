<!-- This is view -->
<?php
echo $this->Html->css('search');
?>
<div id="search_container">
<div id="topic">Search</div>

Search Result is <span id="jp"><?php echo $SearchResult; ?></span>
<br/>
<?php
	echo $this->Session->flash(); 
	if($AnimeCount==0)
	{
		echo $this->Html->link('back to home ホームに戻る',array(
			'controller' => 'Article',
			'action' => 'Home'
		));	
	}
?>

<div id="search_result_container">
<?php
//loop for to find Anime name that match to keyword
for($i=0;$i<$AnimeCount;$i++)
{

	$AnimeKey = mb_substr($AnimeData[$i]['Anime']['anime_title'],0,1,'UTF-8');
	$ResultKey = mb_substr($SearchResult, 0,1,'UTF-8');
	
	if($AnimeKey==$ResultKey)
	{
		
		//loop for to find Article data that match Anime id
		for($l=0;$l<$ArticleCount;$l++)
		{
			if($AnimeData[$i]['Anime']['anime_id']==$ArticleData[$l]['Article']['anime_id'])
			{		
	?>			<div id="search_result_content">
				<div id="search_result_image">	
				<!-- Article Image -->	
				<?php					
					echo $this->Html->image($ArticleData[$l]['Article']['article_image_name'],array(
						'id' => 'article_image'
					));
				?>
				<br/>
				</div>
				
				<!-- Article Topic -->
				<span id="jp">
				<?php
					echo $this->Html->link($ArticleData[$l]['Article']['article_title'],array(
						'controller' => 'Article',
						'action' => 'ShowArticle',$ArticleData[$l]['Article']['id']
					));
				?>
				</span>
				<br/>
						
				<!--anime name  -->			
				<div id="article_anime">
					<spqn id="jp">
					<?php		
						echo $AnimeData[$i]['Anime']['anime_title'];
					?>
					</spqn>	
				</div>

				<!-- Article Date -->
				<div id="article_date">
					<?php
						echo $ArticleData[$l]['Article']['article_date'];
					?>
				</div>

				<!-- Comment Amount -->
				<?php
					$Count=0;
					for($k=0;$k<$CommentCount;$k++)
					{
						if($ArticleData[$l]['Article']['id']==$CommentData[$k]['Comment']['article_id'])
						{
							$Count++;
						}
						
					}//end loop			
				?>
				<div id="comment_amount_line">
					<div id="comment_amount"><?php echo $Count; ?> Comment</span>
					</div>
				</div>


			<?php	
				echo "<br/><br/></div>";
			}//end if	
			?>
<?php 
		}//end if
		
	}//end loop for by ArticleCount
	
}//end loop for by AnimeCount

?>
</div>
<!-- end div for ssearch_result_container -->
</div>
<!--end div search container -->
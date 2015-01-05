<!-- This is View -->
<?php
echo $this->Html->css('select_location');
echo $this->Html->css('select_drop_down');
echo $this->Html->script('select_drop_down');
 ?>

<div id="select_location_containter">

<div id="topic">場所名前とメモをマッピングしてくださいね</div>
<div id="line"></div>
<div id="topic">Location Name</div>

<form method="post">
<?php
for($i=0;$i<$ArticleContentCount;$i++)
{
	echo $ArticleContentData[$i]['ArticleContent']['article_location_name'];	
?>	
	<input type="hidden" name="article_location_name_<?php echo $i; ?>" value="<?php echo $ArticleContentData[$i]['ArticleContent']['article_location_name']; ?>">
	
	<span class="custom-dropdown small">
	<select name="ArticleLocation_<?php echo $i ?>">
<?php 
	for($l=0;$l<$LocationCount;$l++)
	{
?>

<option name="test" value="<?php echo $LocationData[$l]['Location']['location_id'] ?>"><?php echo $LocationData[$l]['Location']['location_memo'] ?></option><br/>
<?php 
	}//end loop
?>		
	</select><br/></span>
<?php	
}//end loop for	
?>	

<br/>
<input type="submit">
</form>

</div>




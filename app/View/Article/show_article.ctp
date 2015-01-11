<!-- this is view -->
    <style>
     #map-canvas {
        height: 500px;
        margin: 0px;
        padding: 0px
      }
	#summary_image{
	 max-height:500px;
	 max-width:500px;
	}
    </style>
<!-- import Geolocation V3 -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>


<?php

//echo $this->Html->css('show_article');
//echo $this->Html->css('location_image');
echo $this->Html->css('jquery.excoloSlider');
echo $this->Html->script('location_image');
echo $this->Html->script('jquery.excoloSlider.min');
?>
<?php 
echo $this->Html->script('Comment');
 ?>
 <!-- Geolocation set current location script -->
<?php 
echo $this->Html->script('ResultLocation');
 ?>

<script>
$(function () {
    $("#slider").excoloSlider();
});
</script>
<div id="show_article_ccontainer">

<!-- Show data from Article model -->
<div id="description">
	
	<span id="description_topic">Article Title</span>
	<br/>
	<span id="description_detail"> 
	<?php echo $ArticleData['Article']['article_title']; ?>
	</span>
	<br/>

	<span id="description_topic">Summary</span>
	<br/>
	<span id="description_detail"> 
	<?php echo $ArticleData['Article']['summary']; ?>
	</span>	
	<br/>
	
	<?php
		echo $this->Html->image($ArticleData['Article']['article_image_name'],array(
			'id' => 'summary_image'
		));
	?>

</div>
<!-- end div description -->

<!-- Show set data from ArticleContent model  -->
<!-- show map -->
<div id="map-canvas"></div>

<script type="text/javascript">
	init(<?php echo $ArticleId ?>,<?php echo $ArticleLocationCount ?>);
</script>
<script type="text/javascript">
	CallComment(<?php echo $ArticleId; ?>);
</script>

<!--show location information -->
<div id="location"> 
	<br/>
	<?php
	for($i=0;$i<$ArticleContentCount;$i++)
	{
	?>
		<span id="location_name">
		<?php 
			echo $ArticleContentData[$i]['ArticleContent']['article_location_name']."<br/>";
		?>
		</span>

		<span id="location_detail">
		<?php
			echo $ArticleContentData[$i]['ArticleContent']['detail']."<br/>";
		?>
		</span>

	<?php }//end loop ?>

	<div id="slider">
		<?php for($l=0;$l<$ArticleContentImageCount;$l++){ ?>
		
		    <?php
				echo $this->Html->image($ArticleContentImageData[$l]['ArticleContentImage']['image_name']);
		    
		    ?>
		    	    
		<?php } //end for loop by ArticleContentCount ?>
	</div>
	

</div>

<!-- end div location -->

<!-- Comment zone  -->
<div id="comment_topic">Comment</div>
<div id="comment_container">
	<?php
	if($UserId!="")
	{	 
	?>	 
	<div id="get_comment"></div>

	<div id="comment_form">
		<form id="data" method="post" >
			<textarea id='textarea'  name="comment"></textarea>
			<input type="hidden" name="article_id" value="<?php echo $ArticleId; ?>">    
		    <button onclick="setTimeout('CallComment(<?php echo $ArticleId; ?>),1000');">
		    Submit
		    </button>
		</form>
	</div>

	<?php
	}//end if 
	?>

</div>
<!--end div comment -->

<script>	
 $("form#data").submit(function(){
 		var formData = new FormData ($(this)[0]);

 		$.ajax({
 			url: "/Article/Comment",
 			type: "POST",
 			data: formData,
 			async: false,
 			success: function(data){
 	            if($('#textarea').val()=="" )
 	            {
 	              alert('Please input text or image');
 	              return;
 	            }
 	           $('form#data').each(function(){
                   this.reset();
               });
 			},
 			cache: false,
 			contentType: false,
 			processData: false
 		});
       
 		return false;

 	}); 
</script>
 
 
</div> <!--end div show_article_container -->
 


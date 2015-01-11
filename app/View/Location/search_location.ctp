<!DOCTYPE html>
<style>
      html, body, #map-canvas {
        height: 500px;
        margin: 0px;
        padding: 0px
      }
</style>


<title>Search Location</title>

<div id="search_location_container">

<!-- show map and search box -->
<input id="pac-input" class="controls" type="text" placeholder="Search Box">

<div id="map-canvas"></div>

Search Map position <div id="jp">マップから場所を探す</div><br/>

<form method="post" >
     
	<input type="hidden" name="latitude" value="0" />
	<input type="hidden" name="longitude" value="0" />
	
	Location Name <span id="jp">場所名前</span>
	<br/>
	<input type="text" name="location_name" />
	<br/>
		
	Memo　<span id="jp">メモ</span>
	<br/>
	<input type="text" name="memo" />
	
	<br/>	
	<input type="submit" value="Save" />

</form>
   	
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<?php echo $this->Html->script('SearchLocation'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>




































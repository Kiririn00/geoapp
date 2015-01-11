<!--this is view-->

    <style>
      html, body, #map-canvas {
        height: 500px;
        margin: 0px;
        padding: 0px
      }
    </style>
<div id="map-canvas"></div>

<div id="current_location_container">
<div id="topic">Save Current location<div id="jp">　現在場</div></div>
    <form method="post" >
     
    <input type="hidden" name="latitude" value="0" />
    <input type="hidden" name="longitude" value="0" />
  	<div>Location Name　<span id="jp">場所名前</span></div>
  	<input type="text" name="location_name" />
  	<div>Memo　<span id="jp">メモ</span></div>
  	<input type="text" name="memo" />
    <br/>	
    <input type="submit" value="Save" />

    </form>

</div>

<!-- Geolocation set current location script -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<?php echo $this->Html->script('CurrentLocation'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>






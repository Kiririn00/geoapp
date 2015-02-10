
//getJSON
var Latitude;
var Longitude;
var LocationId;
var ArticleId;//this is article_id in table articles
var ArticleDetail;
var UseArticleDetail = [];
var LocationName;
var Lat;
var Long;
var UseLat = [];
var UseLong = [];
var LocationMemo;
var UseLocationMemo = [];
var i=0;
var UseCount;
var test = [];

//set geolocation map
var map;
var latitude;
var longitude;
var latlng = [];

function init(UseArticleId,count){
console.log('ArticleId: '+UseArticleId);
console.log('Number of Location: '+count);
	
	$.getJSON("/geoapp/Article/Show.json", function(data){
		
		$.each(data.LocationJSON, function(key,value) {
			LocationId = value.Location.location_id;  
			Latitude = value.Location.latitude;
			Longitude = value.Location.longitude;
					
		});//end each function
				
		$.each(data.ArticleLocationJSON, function(key,value) {
		
			ArticleId = value.ArticleLocation.article_id;
			ArticleDetail = value.ArticleLocation.detail;
			Lat = value.ArticleLocation.latitude;
			Long = value.ArticleLocation.longitude;
			LocationMemo = value.ArticleLocation.article_location_name;
			
			if(ArticleId == UseArticleId)
			{
				UseLat[i] = Lat;
				UseLong[i] = Long;
				UseLocationMemo[i] = LocationMemo;
				UseArticleDetail[i] = ArticleDetail;
				i++;
			}
					
		});//end each function
				
		//console.dir(UseLat);
		UseCount = count;
		initialize(UseLat,UseLong,UseCount,UseLocationMemo,UseArticleDetail);
			
	});//end getJSON function
		
}//end function


function initialize(UseLat,UseLong,UseCount,UseLocationMemo,UseArticleDetail) {
var test = [];
var info_content = [];
//var marker = [];
//var infowindow = [];
		  
  	var mapOptions = {
	    zoom: 14
	  };
  	
  	  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
  	
  	for(i=0;i<UseCount;i++)
	{	
		test[i] = new google.maps.LatLng(UseLat[i],UseLong[i]);
		info_content[i] = "<div>"+UseLocationMemo[i]+"</div><br/>"+"<div>"+UseArticleDetail[i]+"</div>";
		
		infowindow = new google.maps.InfoWindow({
			content: info_content[i],
			width:320
		});
		
		marker = new google.maps.Marker({
			  map: map,
		      position:  test[i],
		});
		
	  	google.maps.event.addListener(marker, 'click', function() {
	  	    infowindow.open(map,marker);
	  	  });
		
		/*
		  var infowindow = new google.maps.InfoWindow({
		      map: map,
		      position:  test[i],
		      content: UseLocationMemo[i],
		      width: 320
		    });
		  
		 
		   var marker = new google.maps.Marker({
			      position: myLatlng,
			      map: map,
			      title: 'Uluru (Ayers Rock)'
			  });
		   
		   */ 
	}//end loop

  	    
 // Try HTML5 geolocation
    if(navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = new google.maps.LatLng( UseLat[0],UseLong[0]);

        map.setCenter(pos);
        latitude = UseLat[0];
        longitude = UseLong[0];

      }, function() {
        handleNoGeolocation(true);
      });
         
    } else {
      // Browser doesn't support Geolocation
      handleNoGeolocation(false);
    }
  }//end get current position
 

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}
	
google.maps.event.addDomListener(window, 'load', initialize);


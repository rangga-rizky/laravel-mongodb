<!DOCTYPE html>
<html>	
<head>
	<title>Foot-print</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="{{url('css/style.css')}}">
	<link rel="stylesheet" href="{{url('css/star-rating.min.css')}}">



</head>
<body>
	<header>
      
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <strong>Foot-print</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          </button>
        </div>
      </div>
    </header>

    <main>
    	<section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Foot-print</h1>
          <p class="lead text-muted"><strong>Tinggalkan Jejak kakimu disini.</strong></p>
          <p>Klik Pada peta untuk meninggalkan jejak!</p>
        
        </div>
      </section>
      <div class="py-5 bg-light">
      	<div class="container">
      			@if(session('success'))
			  	<div class="alert alert-success" role="alert">
				  {{session('success')}}
				</div>
  				@endif

				@if ($errors->any())
				<div class="alert alert-danger">
					
					@foreach ($errors->all() as $error)				
					<div class="ui error message">
						<div class="header">Terjadi Kesalahan</div>
						<p>{{ $error }}</p>
					</div>
					@endforeach
				</div>
				<br>
				@endif

      		<div class="row">
      			<div class="col col-lg-8">
			       <div id="map" style="height: 500px"></div>
			    </div>
			    <div class="col col-lg-4">
			    	@foreach($places as $place)
			    	 <div  class="list-group-item list-group-item-action flex-column align-items-start">
					    <div class="d-flex w-100 justify-content-between">
					      <h5 class="mb-1">{{$place->name}}</h5>
					      <small class="text-muted">{{$place->getCreatedDateTimeLocalized()}}</small>
					    </div>
					    <div class="d-flex w-100 ">
					    <div class="rating medium star-icon value-{{$place->review['avg_stars']}} color-ok">
					    <div class="star-container">
					        <div class="star">
					            <i class="star-empty"></i>
					            <i class="star-half"></i>
					            <i class="star-filled"></i>
					        </div>
					        <div class="star">
					            <i class="star-empty"></i>
					            <i class="star-half"></i>
					            <i class="star-filled"></i>
					        </div>
					        <div class="star">
					            <i class="star-empty"></i>
					            <i class="star-half"></i>
					            <i class="star-filled"></i>
					        </div>
					        <div class="star">
					            <i class="star-empty"></i>
					            <i class="star-half"></i>
					            <i class="star-filled"></i>
					        </div>
					        <div class="star">
					            <i class="star-empty"></i>
					            <i class="star-half"></i>
					            <i class="star-filled"></i>
					        </div>
					    </div>
						</div>
						</div>
					    <p class="mb-1">Created by : {{$place->user["user_name"]}}</p>	
					    @foreach($place->tags as $tag)
					    	<span class="badge badge-secondary">{{$tag}}</span>
					    @endforeach			
					    <br>	    
					    <div class="d-flex w-100 justify-content-between">
					    <a role="button" href="" data-toggle="modal" data-target="#reviewModal" data-id="{{$place->_id}}" data-name="{{$place->name}}"><small class="text-muted">{{$place->review["count"]}} reviews</small></a>
					    <form method="POST" action="{{url('places/remove')}}">
					    	{{ csrf_field() }}
					    	<button class="btn btn-outline-danger">Hapus</button>
					    	<input type="hidden" name="id" value="{{$place->_id}}">
					    </form>
						</div>
					  </div>
			    	@endforeach
			    </div>    			
      		</div>
      	</div>  	

      </div>
    </main>
    @include("modal")

</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 <script>
      function initMap() {
        // Create a map object and specify the DOM element for display.
	        var map = new google.maps.Map(document.getElementById('map'), {
	          center: {lat: -34.397, lng: 150.644},
	          zoom: 15
	        });

	        var infoWindow = new google.maps.InfoWindow({map: map});
	        var marker = new Array();
 			var infowindow = new Array();
	        @for($i = 0 ;$i< sizeof($places);$i++)
		        marker[{{$i}}] = new google.maps.Marker({map: map, position: {lat: {{$places[$i]->latitude}}, lng: {{$places[$i]->longitude}}}, clickable: true});

		       infowindow[{{$i}}] = new google.maps.InfoWindow({
             		content:"{{$places[$i]->name}}"
               });

				

				google.maps.event.addListener(marker[{{$i}}], 'click', function() {
				  
				  infowindow[{{$i}}].open(map,this);
				});
	        @endfor

	        if (navigator.geolocation) {
	          navigator.geolocation.getCurrentPosition(function(position) {
	            var pos = {
	              lat: position.coords.latitude,
	              lng: position.coords.longitude
	            };

	            infoWindow.setPosition(pos);
	            infoWindow.setContent('Your location.');
	            map.setCenter(pos);
	          }, function() {
	            handleLocationError(true, infoWindow, map.getCenter());
	          });
	        } else {
	          handleLocationError(false, infoWindow, map.getCenter());
	        }
	           
      }

       function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	        infoWindow.setPosition(pos);
	        infoWindow.setContent(browserHasGeolocation ?
	                              'Error: The Geolocation service failed.' :
	                              'Error: Your browser doesn\'t support geolocation.');
	      }

		$('#reviewModal').on('show.bs.modal', function(e) {
		    var name = $(e.relatedTarget).data('name');
		    var id = $(e.relatedTarget).data('id');
		    $("#review-modal-name").html(name);
		    $("#review-modal-placeid").val(id);
			$.get("{{url('api/reviews/place')}}/"+id,
			    {
			      
			    },
			    function(data, status){
			    	var list = "";
			    	for (var i =  0; i < data.length; i++) {
			    		list = list+"<a href='#'' class='list-group-item list-group-item-action flex-column align-items-start'> \
					    <div class='d-flex w-100 justify-content-between'> \
					      <h5 class='mb-1'>"+data[i]["user"]["user_name"]+"</h5> \
					       <div class='rating medium star-icon value-"+data[i]["rating"]+" color-ok'>\
						    <div class='star-container'>\
						        <div class='star'>\
						            <i class='star-empty'></i>\
						            <i class='star-half'></i>\
						            <i class='star-filled'></i>\
						        </div>\
						        <div class='star'>\
						            <i class='star-empty'></i>\
						            <i class='star-half'></i>\
						            <i class='star-filled'></i>\
						        </div>\
						        <div class='star'>\
						            <i class='star-empty'></i>\
						            <i class='star-half'></i>\
						            <i class='star-filled'></i>\
						        </div>\
						        <div class='star'>\
						            <i class='star-empty'></i>\
						            <i class='star-half'></i>\
						            <i class='star-filled'></i>\
						        </div>\
						        <div class='star'>\
						            <i class='star-empty'></i>\
						            <i class='star-half'></i>\
						            <i class='star-filled'></i>\
						        </div>\
						    </div>\
							</div>\
						</div> \
					    </div> \
					    <p class='mb-1'>"+data[i]['review']+"</p> \
					  </a>";
					}
					$("#reviews").html(list);
			 });

		});



    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxLjUdODzRTrcIfsHusrM4YvzRzyu7-I&callback=initMap"
    async defer></script>
</html>
<html>
    <head>
<title>Map</title>
    </head>
    <body>
        <!-- BEGIN: Content--> 
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?=$title?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>properties">Property List</a>
                            </li>
                            <li class="breadcrumb-item active">
                                New Property
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <!-- <h4 class="card-title"><a href="<?=base_url()?>properties" class="btn btn-primary btn-sm"><i class="ft-list"></i>  Properties</a></h4> -->
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
                                <!-- <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse">
                                                <i class="ft-minus"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-action="reload">
                                                <i class="ft-rotate-cw"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-action="expand">
                                                <i class="ft-maximize"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-action="close">
                                                <i class="ft-x"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
<style type="text/css">
    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: -170px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        height: 30px;
            z-index: 1!important;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
</style>
    <!-- form -->
    <form class="form " action="" method="POST" enctype="multipart/form-data">
        <div class="form-body">




            <div class="form-group">
                
                <label for="">Select Location</label>
                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                <div id="map" style="width: auto; height: 400px;"></div>  
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" id="longitude" class="form-control" placeholder="longitude" name="longitude">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" id="latitude" class="form-control" placeholder="latitude" name="latitude">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- End: form -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            

            <!-- // Basic form layout section end -->
        </div>

    </div>
</div>
<!-- END: Content -->




<script type="text/javascript">
    $('#address').keyup(function(){
        var search = $(this).val();
        $('#pac-input').val(search);
    })

    // function load_location(){
    //     $('#location_id').html('<option value="" >-- Select --</option>');
    //     var state =  $('#state').val();
    //     var city  =  $('#city').val();
    //     $.post('<?=base_url()?>load_locations',{state:state,city:city})
    //     .done(function(data){
            
    //         data = JSON.parse(data);
    //         console.log(data);
    //         $('#location_id').html(data.content);
    //     })
    //     .fail(function() {
    //         alert( "error" );
    //       })

    // }
</script>
<script type="text/javascript">
 var markers = [];

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13,
      mapTypeId: 'roadmap'
    });

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(171, 171),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            var  markers = new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location,
              draggable:true,
             title:"Drag me!"
            });

            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);

            google.maps.event.addListener(markers, 'dragend', function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                $('#latitude').val(lat);
                $('#longitude').val(lng);
            });

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
      map.fitBounds(bounds);
    });
}

$(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
    if(event.keyCode == 13) {
      event.preventDefault();
      // alert();
      return false;
    }
});


    $('#propname').keyup(function(){
        var title = $(this).val();
        // $.ajax({
        //     url: '<?=base_url()?>propcode',
        //     data:{title:title},
        //     type:'POST',
        //     success:function(data){
        //         console.log(data);
        //     }
        // })
        $.post('<?=base_url()?>propcode',{title:title})
        .done(function(data){
            $('#propcode').val(data);
        })
    })


</script>       
<script src="http://maps.google.com/maps/api/js?key=AIzaSyCpnibB5v9t1-bGn0ub8_a-c50BwKrCwR4&libraries=places&callback=initAutocomplete"
async defer
></script>
    </body>
</html>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="page-wrapper">
<div class="container-fluid" style="max-width: 100% !important;">
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Business & store</a></li>
            <!-- <li class="breadcrumb-item"><a href="<?php echo base_url('business-store'); ?>">Business</a></li> -->
            <li class="breadcrumb-item active">Shops</li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap">
                            <div class="float-left col-md-6 col-lg-6 col-sm-6">
                                <h3 class="card-title" id="test">Shop Data</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>

                            <!-- <div class="float-left col-md-6 col-lg-6 col-sm-6">
                                <button class="float-right btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Add Shop" data-url="<?=$new_url?>" >Add Shop</button>
                            </div> -->

                            
                        </div>
                    </div>

                    <div class="col-12" id="tb">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->

<!-- //###### ANKIT MAIN CONTENT  ######// -->
<input type="hidden" name="tb" value="<?=$tb_url?>">
<div class="modal fade text-left" id="showModal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel21">......</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              
          </div>
          <!-- <div class="modal-footer">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
          </div> -->
      </div>
  </div>
</div>


<div class="modal fade text-left" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel21">......</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">
// $('#showModal-xl').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget) 
//     var recipient = button.data('whatever') 
//     var data_url  = button.data('url') 
//     var modal = $(this)
//     $('#showModal-xl .modal-title').text(recipient)
//     $('#showModal-xl .modal-body').load(data_url);
// })

$('#showModal').on('show.bs.modal', function (event) {
    $('.shop_cat').selectpicker();
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var data_url  = button.data('url') 
    var modal = $(this)
    $('#showModal .modal-title').text(recipient)
    $('#showModal .modal-body').load(data_url);
})

$(document).on('click','[data-dismiss="modal"]', function(event) {
    $('#showModal .modal-body').html('');
    $('#showModal .modal-body').text('');
})

function loadtb(url=null){
    if (url!=null) {
        var tbUrl = url;
    }
    else{
        var tbUrl = $('[name="tb"]').val();
    }

    if (tbUrl!='') {
        $('#tb').load(tbUrl);
    }
}

loadtb();

$(document).on('click', '.pag-link', function(event){
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0;
    var search = $('#tb-search').val();
    $.post($(this).attr('href'),{search:search})
    .done(function(data){
        $('#tb').html(data);
    })
    return false;
})

$(document).on("submit", '.ajaxsubmit', function(event) {

        event.preventDefault(); 
        $this = $(this);

        if ($this.hasClass("needs-validation")) {
            if (!$this.valid()) {
                return false;
            }
        }
        
    if(confirm('Are You Sure') == true)
    { 
        var element = document.getElementById("loader");
        element.className = 'fa fa-spinner fa-spin';
        $("#btnsubmit").prop('disabled', true);
        $.ajax({
        url: $this.attr("action"),
        type: $this.attr("method"),
        data:  new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            // return false;

            data = JSON.parse(data);
            if (data.res=='success') {
                if(!$this.hasClass("update-form")) {
                    $('[type="reset"]').click();
                }
                
                if ($this.hasClass("reload-tb")) {
                    loadtb();
                }

                if ($this.hasClass("reload-page")) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000); 
                }

                if ($this.hasClass("btn-click")) {
                    setTimeout(function() {
                        var btn_target = $this.attr("btn-target");
                        $(btn_target).click();
                    }, 1000); 
                }
            }
            alert(data.msg);
            // alert_toastr(data.res,data.msg);
        }
        })
    } //end of if confirm
        return false;
})
</script>
<!-- //###### ANKIT MAIN CONTENT  ######// -->

<script type="text/javascript">
function getid(proid) {
    $("#pro_content"+proid).load("<?php echo base_url('master-data/view_product_images/') ?>"+proid)
}

var timer;
        var timeout = 500;
        $(document).on('keyup', '#tb-search', function(event){
            if(event.keyCode == 13)
            {
                $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
            clearTimeout(timer);
            timer = setTimeout(function(){
                var search  = $('#tb-search').val();
                var state_id  = $('#state').val();
                var city_id  = $('#city').val();
                var business_id  = $('#business_id').val();
                // console.log(search);
                var tbUrl = $('[name="tb"]').val();
                $.post(tbUrl,{business_id:business_id,state_id:state_id,city_id:city_id,search:search})
                .done(function(data){
                    $('#tb').html(data);
                    if($('#tb-search').val()!== '')
                    {
                        document.getElementById("tb-search").focus();
                        var search  = $('#tb-search').val();
                        $('#tb-search').val('');
                        $('#tb-search').val(search);
                    }  
                })
            }, timeout);

            return false;
        }
        })
</script>
<script type="text/javascript">
   function fetch_city(state)
   {
    $.ajax({
        url: "<?php echo base_url('business-store/fetch_city'); ?>",
        method: "POST",
        data: {
            state:state
        },
        success: function(data){
            $(".city").html(data);
        },
    });
   }
</script>
<!-- google map -->
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


</script>  


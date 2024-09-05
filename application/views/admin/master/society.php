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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data/'.$menu_id); ?>">Master Data</a></li>
                            <li class="breadcrumb-item active">Pincodes Criteria</li>
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
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h3 class="card-title" id="test">Society</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-society" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Society</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('master-data/add_society/'); ?>" method="post" enctype= multipart/form-data>
                                                                <div class="form-group">
                
                <label for="">Select Location</label>
                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                <div id="map" style="width: auto; height: 400px;"></div>  
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" id="longitude" class="form-control" name="longitude" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" id="latitude" class="form-control" name="latitude" readonly>
                    </div>
                </div>
            </div>
                                                                    <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">State:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="state" id="state" onchange="fetch_city(this.value)">
                                                                            <option value="">Select State</option>
                                                                            <?php foreach ($states as $state) { ?>
                                                                            <option value="<?php echo $state->id; ?>">
                                                                                <?php echo $state->name; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">City:</label>
                                                                        <select class="form-control select2 city" style="width:100%;" name="city" id="city">
                                                                        
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Society Name:</label>
                                                                            <input type="text" class="form-control" name="name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Society Range:</label>
                                                                            <input type="text" class="form-control" name="society_range">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Photo:</label>
                                                                            <input type="file" name="img" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Address:</label>
                                                                            <textarea cols="92" rows="5" class="form-control" name="address"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                    
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD">
                                                            </div>
                                                            
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-society" >Add Society</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Society Name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Longitude</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Latitude</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Range</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Address</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; $n=0; foreach($society as $value){
                                                    $ids[] = uniqid();
                                                    
                                                 ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->socity_id; ?>" id="multiple_delete<?= $value->socity_id; ?>" />
                                                        <label for="multiple_delete<?= $value->socity_id; ?>"></label>
                                                    </td>
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <?php if(!empty($value->img)) { ?>
                                                        <img src="<?php echo IMGS_URL.$value->img;?>" alt="image" height="50" width="50">
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->longitude;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->latitude;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->society_range;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-left">
                                                        <?php $addr = strip_tags( $value->address);
                                                            $addr = substr($addr,0,15);
                                                            echo $addr; ?>
                                                            <?php if(strlen($value->address) > 15){ ?> 
                                                            .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-address<?php echo $value->socity_id; ?>">Read More</button>
                                                            <?php } ?>
                                                        </td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->socity_id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->socity_id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->socity_id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-society<?php echo $value->socity_id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a class="text-danger" href="<?php echo base_url('master-data/delete_society/'.$value->socity_id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Link Shops" data-url="<?=$link_shop_url?><?=$value->socity_id?>" >
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    </td>
                                                </tr> 
                                                <!--Link Shop modal-->
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
                                                <!--/Link Shop modal-->
                                                <!--Read Address modal-->
                                                    <div id="read-address<?php echo $value->socity_id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b>Address</b>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $value->address; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--/Read Address modal-->
                                                <div id="edit-society<?php echo $value->socity_id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Society</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('master-data/edit_society/'.$value->socity_id); ?>" method="post" enctype= multipart/form-data>
                                                                <div class="form-group">
                
                <label for="">Select Location</label>
                <input id="pac-input1" class="controls" type="text" placeholder="Search Box">
                <div id="map1" style="width: auto; height: 400px;"></div>  
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" id="longitude" class="form-control" placeholder="longitude" name="longitude" value="<?php echo $value->longitude; ?>" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" id="latitude" class="form-control" placeholder="latitude" name="latitude" value="<?php echo $value->longitude; ?>" readonly>
                    </div>
                </div>
            </div>
                                                                    <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">State:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="state" id="state" onchange="fetch_city(this.value)">
                                                                            <option value="">Select State</option>
                                                                            <?php foreach ($states as $state) { ?>
                                                                            <option value="<?php echo $state->id; ?>" <?php if($state->id == $value->state){echo "selected";} ?>>
                                                                                <?php echo $state->name; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">City:</label>
                                                                        <select class="form-control select2 city" style="width:100%;" name="city" id="city">
                                                                        <option value="<?php echo $value->city; ?>">
                                                                    <?php echo $value->city; ?>
                                                                    </option>
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Society Name:</label>
                                                                            <input type="text" class="form-control" name="name" value="<?php echo $value->name;?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Society Range:</label>
                                                                            <input type="text" class="form-control" name="society_range" value="<?php echo $value->society_range;?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Photo:</label>
                                                                            <input type="file" class="form-control" name="img">
                                                                        </div>
                                                                        <?php if(!empty($value->img)) { ?>
                                                                        <img src="<?php echo IMGS_URL.$value->img;?>" alt="<?php echo $value->name; ?>" height="50">
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Address:</label>
                                                                            <textarea cols="92" rows="5" class="form-control" name="address"><?= $value->address; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                   
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div> 
                            
                                                <?php  $n++; } ?>    
                                                </table>
                                        </div>
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

<script type="text/javascript">
   function fetch_city(state)
   {
    //    alert(business_id);
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_city'); ?>",
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
<script type="text/javascript">
    $(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            state:"required",
            city:"required",
            society_range:"required",
            // longitude:"required",
            // latitude:"required",
            name:{
                required:true,
                remote:"<?=$societyr?>null"
            }
        },
        messages: {
            state:"Please Select State!",
            city:"Please Select City!",
            society_range:"Please Enter Society Range!",
            name: {
                required : "Please enter society name.",
                remote : "Society already exists!"
            }
        }
    }); 
});
</script> 
  
<script type="text/javascript">
    $('#address').keyup(function(){
        var search = $(this).val();
        $('#pac-input').val(search);
    })

    
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


</script>    
<script src="http://maps.google.com/maps/api/js?key=AIzaSyCpnibB5v9t1-bGn0ub8_a-c50BwKrCwR4&libraries=places&callback=initAutocomplete"
async defer
></script>
<script>
    function change_status(socity_id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_society_status'); ?>",
        method: "POST",
        data: {
            socity_id:socity_id
        },
        success:function(data){
            $("#status"+socity_id).html(data);
        }
    });
    }
</script>
<script>
  $('#showModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var data_url  = button.data('url') 
    var modal = $(this)
    $('#showModal .modal-title').text(recipient)
    $('#showModal .modal-body').load(data_url);
})
        //multiple delete
        $('.delete_checkbox').click(function(){
        if($(this).is(':checked'))
        {
        $(this).closest('tr').addClass('removeRow');
        }
        else
        {
        $(this).closest('tr').removeClass('removeRow');
        }
    });
   $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        var table = 'society_master';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>master-data/multiple_delete/",
                method:"POST",
                data:{checkbox_value:checkbox_value,table:table},
                success:function(data)
                {
                    $('.removeRow').fadeOut(1500);
                }
            })
            }
            else
            {
            alert('Select atleast one record');
            }
   })
</script>
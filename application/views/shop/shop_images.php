<form enctype="multipart/form-data" method="post">
<div class="row">
            <div class="col-8 mb-3">
<input type="file" id="files" name="img[]" class="form-control"
size="55550" accept=".png, .jpg, .jpeg, .gif" multiple="" required>
</div>
<div class="col-4">
<button id="imgsubmit" type="button" class="btn btn-primary" onclick="add_shop_img(<?php echo $sid;?>)"><i id="loader" class=""></i>Add Image</button>
</div>
</form>
<table class="jsgrid-table">
<tr class="jsgrid-header-row">
<th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
<th class="jsgrid-header-cell jsgrid-align-center">Images</th>
<th class="jsgrid-header-cell jsgrid-align-center">Sequence</th>
<th class="jsgrid-header-cell jsgrid-align-center">Actions</th>


</tr>

<?php $i=1;foreach($images as $shop){ ?>
<tr class="jsgrid-filter-row">
    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++ ?></td>
    <td class="jsgrid-cell jsgrid-align-center"> 
        <?php if(!empty($shop->image)) { ?>
            <img src="<?php echo IMGS_URL.$shop->image; ?>" alt="" height="100" width="100">
        <?php } ?> 
    </td>
    <td class="jsgrid-cell jsgrid-align-center"><input type="number" name="seq" id="seq<?php echo $shop->id; ?>" value="<?= $shop->seq;?>" onchange="update_shop_seq(<?php echo $shop->id; ?>)"></td>
    <td class="jsgrid-cell jsgrid-align-center">
    <?php if($shop->is_cover != 1) {?>
    <a href="javascript:void(0)" onclick="deleteimage(<?php echo $shop->id; ?>)"><i class="fa fa-trash"></i></a>
    <?php } ?>
    <?php if($shop->is_cover == 1) {?>
    <a href="javascript:void(0)" class="btn btn-primary btn-sm">Cover</a>
    <?php } else{ ?>
        <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="makecover(<?php echo $shop->id; ?>)">Make Cover</a>
    <?php } ?>
    </td>
</tr>
<?php } ?>
</table>


<script>
    function add_shop_img(sid){
        var element = document.getElementById("loader");
        element.className = 'fa fa-spinner fa-spin';
        $("#imgsubmit").prop('disabled', true);
        var form_data = new FormData();

        // Read selected files
        var totalfiles = $('#files')[0].files;
        for (var i = 0; i < totalfiles.length; i++) {
        form_data.append("file[]", document.getElementById('files').files[i]);
        form_data.append("sid", sid);
        // console.log(form_data);
        }
        $.ajax({
            url: '<?php echo base_url('welcome/add_image'); ?>', 
            type: 'post',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (response) {
                var element = document.getElementById("loader");
                        element.classList.remove("fa-spinner");
                        $("#imgsubmit").prop('disabled', false);
        // console.log(response);
        $('#showModal .modal-body').load("<?php echo base_url('welcome/shop_images/')?>"+<?=$sid ?>);

        toastr.success('Image Added Successfully..');
            },
            error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                }       
        });
    }
</script>
<script>
    function deleteimage(imageid){
       
        if(confirm('Do you want to delete?') == true)
        {
            $('#showModal .modal-body').load("<?php echo base_url('welcome/delete_shop_image/')?>"+<?=$sid ?>+"/"+imageid );
            toastr.success('Image Deleted Successfully..');
        }
    }
</script>
<script>
    function makecover(imageid){
       
        if(confirm('Are You Sure?') == true)
        {
            $('#showModal .modal-body').load("<?php echo base_url('welcome/make_shop_cover/')?>"+<?=$sid ?>+"/"+imageid );
            toastr.success('Cover Updated Successfully..');
        }
    }
</script>
<script>
    function update_shop_seq(imageid){
       
        var seq = $('#seq'+imageid).val();
            $('#showModal .modal-body').load("<?php echo base_url('business/shops/update_shop_seq/')?>"+<?=$sid ?>+"/"+imageid+"/"+seq );
            toastr.success('Sequence Updated Successfully..');

    }
</script>
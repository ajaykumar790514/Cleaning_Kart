<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($enquiry_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <?=$links?>
        </div>
    </div>
</div>
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Email</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Mobile</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Message</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            
            <?php $i=$page; foreach($enquiry_data as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->name;?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->email;?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->phone;?></th>
                <td class="jsgrid-cell jsgrid-align-left">
                    <?php $message = strip_tags( $value->message);
                    $message = substr($message,0,15);
                    echo $message; ?>
                    <?php if(strlen($value->message) > 15){ ?> 
                    .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-message<?php echo $value->id; ?>">Read More</button>
                    <?php } ?>
        
                </td>
                <th class="jsgrid-cell jsgrid-align-center">
                    <a href="javscript:void(0)" onclick="delete_enquiry(<?php echo $value->id;?>)"><i class="fa fa-trash"></i>
                    </a>
                </th>
               
            </tr> 
            <!--Read Message modal-->
            <div id="read-message<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <b>Message</b>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <?php echo $value->message; ?>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
        <!--/Read Description modal-->
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($enquiry_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>


<script>
    function delete_enquiry(enquiry_id)
    {
        if(confirm('Do you want to delete?') == true)
        {
            $.ajax({
                url: '<?= base_url() ?>welcome/shop_enquiry/delete_enquiry/',
                method: 'POST',
                data: {enquiry_id:enquiry_id},
                success: function (data) {
                    if(data == 'success')
                    {
                        toastr.success('Enquiry Deleted Successfully..');
                        location.reload();
                    }
                    else
                    {
                        toastr.error('Enquiry Not Deleted!!');
                    }
                }
                });
        }
    };

</script>
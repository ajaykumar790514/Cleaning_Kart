<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($news_data)?> of <?=$total_rows?> entries</span>
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
                <th class="jsgrid-header-cell jsgrid-align-center">Title</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Description</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Datetime</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Meta keyword</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Meta description</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
            
            <?php $i=$page; foreach($news_data as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->title;?></th>
                <td class="jsgrid-cell jsgrid-align-center">
                        <img src="<?php echo IMGS_URL.$value->photo; ?>" alt="cover" height="50">
                </td>
                <td class="jsgrid-cell jsgrid-align-left">
                    <?php $desc = strip_tags( $value->description);
                    $desc = substr($desc,0,15);
                    echo $desc; ?>
                    <?php if(strlen($value->description) > 15){ ?> 
                    .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
                    <?php } ?>
        
                </td>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->added;?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->meta_keyword;?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$value->meta_description;?></th>
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->status==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Product ( <?=$value->title?> )" data-url="<?=$update_url?><?=$value->id?>" >
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="javscript:void(0)" onclick="delete_news(<?php echo $value->id;?>)"><i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr> 
            <!--Read Description modal-->
            <div id="read-desc<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <b>Description</b>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <?php echo $value->description; ?>
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
        <span>Showing <?=$page+1?> to <?=$page+count($news_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('shopzone-portal/change_news_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }

</script>
<script>
    function delete_news(news_id){
        if(confirm('Do you want to delete?') == true)
        {
            $.ajax({
                url: "<?php echo base_url('portal-news/delete_news/'); ?>",
                method: "POST",
                data: {
                    news_id:news_id
                },
                success:function(data){
                    $("#tb").html(data);
                    toastr.success('News Deleted Successfully..')
                }
            });
        }
    };

</script>


</script>
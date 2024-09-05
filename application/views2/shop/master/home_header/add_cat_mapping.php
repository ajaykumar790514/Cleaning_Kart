
<div class="modal-header">
    <b>Add Header Items</b>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <input type="hidden" value="<?php echo $headerid; ?>" id="headerid">
                                                                
    <table class="table" style="border:1px solid black">
        <thead class="thead-light">
        <tr style="border:1px solid black">
            <th class="text-center">Image</th>
            <th class="text-center">Category Name</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $flg=0;
            foreach($parent_cat as $parent) {?>
        <tr>
            <td class="text-center"><img src="<?php echo IMGS_URL.$parent->icon; ?>" alt="image" height="100"></td>
            <td class="text-center"><?php echo $parent->name; ?></td>
            <?php foreach($headers_mapping as $mapping) 
            {
                if($mapping->value == $parent->id)
                {
                        $flg=1;   
                }
            }
            ?>
            <td class="btn btn-primary btn-sm" id="changeaction2<?= $parent->id ?>">
            <?php if($flg==1)
                {?> 
                <a href="javascript:void(0)" onclick="remove_map_category(<?= $parent->id ?>);" style="color:white;"> Remove </a>
            <?php } 
                else { ?>
                <a href="javascript:void(0)" onclick="map_category(<?= $parent->id ?>);" style="color:white;">Map</a>
                <?php } ?>
            </td>
        
        </tr>
        <?php $flg=0; }?>
        </tbody>
    </table>
                                                               
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
</div>
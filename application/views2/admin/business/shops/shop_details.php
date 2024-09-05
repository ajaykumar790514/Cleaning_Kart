<style>
    .modal-dialog
    {
        max-width: 80%;
    margin-left: 10%;
    margin-right: 10%;
    }
</style>
<table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Alternative contact</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Open Time</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Close Time</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Delivery</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">COD</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Security</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">COD Limit</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">GST in</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Image</th>
                                                </tr>
                                                <?php $i=1; foreach($shops as $value) {?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->alternate_contact;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->open_time;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->close_time;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php if($value->isDelivery == '1') {
                                                            echo "Yes"; } else {
                                                                echo "No";
                                                            } ;?>

                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php if($value->is_cod == '1') {
                                                            echo "Yes"; } else {
                                                                echo "No";
                                                            } ;?>

                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php if($value->is_security == '1') {
                                                            echo "Yes"; } else {
                                                                echo "No";
                                                            } ;?>

                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->cod_limit;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->gstin;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php if(!empty($value->logo)) { ?>
                <img src="<?php echo IMGS_URL.$value->logo;?>" alt="<?php echo $value->shop_name; ?>" height="50">
                <?php } ?>
                                                    </td>
                                                    
                                                </tr>
                                                <?php }?>
                                                </table>



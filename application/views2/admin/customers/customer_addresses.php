<style>
    .modal-dialog
    {
        max-width: 80%;
    margin-left: 10%;
    margin-right: 10%;
    }
</style>
<?php if(!empty($address)) { ?>
<table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Address</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">House No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Appartment</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Landmark</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">State</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">City</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Pincode</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Nickname</th>
                                                </tr>
                                                <?php $i=1; foreach($address as $addr) {?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->address;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->house_no;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->apartment_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->landmark;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->state_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->city_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->pincode;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?= $addr->nickname;?></td>
                                                    
                                                </tr>
                                                <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>  
                                                </table>
                                                <?php } else{ ?>
                                                    <h4 class="text-center">No Record Found</h4>
                                                    <?php } ?>



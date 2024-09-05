<!-- <div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?= $page + 1 ?> to <?= $page + count($cashvendor) ?> of <?= $total_rows ?> entries</span>
    </div>
    <div class="col-md-6 text-right">
    <?= $links ?>
    </div>
</div> -->


<div class="col-12">
    <div id="grid_table">
        <table class="jsgrid-table" id="Bankable">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete
                        Selected</button></th>
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Payment Date </th>
                <th class="jsgrid-header-cell jsgrid-align-center">Customer Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Reference No</th>
                <th class="jsgrid-header-cell jsgrid-align-center" int>Credit (₹)</th>
                <th class="jsgrid-header-cell jsgrid-align-center" int>Debit (₹)</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            <?php $i = $page+1;
            foreach ($cashvendor as $value) {
                // print_r($value);
                
            ?>
                <tr class="jsgrid-filter-row">
                    <td class="jsgrid-cell jsgrid-align-center">
                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                        <label for="multiple_delete<?= $value->id; ?>"></label>
                    </td>
                    <td class="jsgrid-cell jsgrid-align-center">
                        <?php echo $i++; ?></td>
                    <td class="jsgrid-cell jsgrid-align-center">
                        <?php echo $value->PaymentDate; ?></td>
                    <td class="jsgrid-cell jsgrid-align-center">
                        <?php echo $value->name; ?></td>
                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->reference_no; ?>">
                        <?php echo $value->reference_no; ?></td>    
                    
                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->cr; ?>" int>
                        <?php echo $value->cr; ?>
                    </td>
                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->dr; ?>" int>
                        <?php echo $value->dr; ?> 
                    </td>
                   
                    <td class="jsgrid-cell jsgrid-align-center">
                        <a data-toggle="modal" href="#" onclick="showmodel(<?php echo  $value->id ?>)" data-target="#showModal"><i class="fa fa-edit"></i></a>
                        <a href="<?php echo base_url('cash_register/cash/delete/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash" style="color:red"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?= $page + 1 ?> to <?= $page + count($cashvendor) ?> of <?= $total_rows ?> entries</span>
    </div>
    <div class="col-md-6 text-right">
    <?= $links ?>
    </div>
</div>
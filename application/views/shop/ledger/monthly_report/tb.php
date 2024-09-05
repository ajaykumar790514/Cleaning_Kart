<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
.jsgrid-table
{
    width:202%;
}
h4
{
    color:blue;
}
#reset-data
{
    background-color:red;
}
 [percentage]:after{
              content: '%';
            }
[fixed]:before{
  content: '\20B9'; 
  margin-right: 2px;
}   
.table-sm th{
    border-bottom: 2px solid #dee2e6;
}
.table-sm td{
    border-top: 0px solid #dee2e6;
}
</style>
<?php 

 // echo _prx($sales_report);
 //                    die(); 
                    ?>


<div id="datatable">
    <?php if (@$rows) { ?>
    <div class="row">
        <div class="col-12 text-center">
            <h1><?=$shop->shop_name?></h1>
            <h5><?=$shop->address.', '.$shop->city_name.', '.$shop->state_name?></h5>
            <h5>GSTIN : <?=$shop->gstin?></h5>
            <h5>Monthly Ledger Report</h5>
            <h5>( <?= date('M-Y',strtotime($_POST['month'])) ?> )</h5>
        </div>
    </div>
    <div id="grid_table" class="table-responsive">
        <table class="table table-sm">
            <tr class="">
                <th class="">Sr.no.</th>
                <th class="">Name</th>
                <th class="">Code</th>
                <th class="" int>Debit</th>
                <th class="" int>Credit</th>
                <th class="" int>Balance</th>
            </tr>

            <?php $i = 0;
                foreach($rows as $key => $value) { ?>
                    <tr class="">
                        
                        <td class=""><?= ++$i?> </td>
                        <td class=""><?=$value->name?></td>
                        <td class=""><?=$value->vendor_code?></td>
                        <td class="" int><?=$value->total_dr?></td>
                        <td class="" int><?=$value->total_cr?></td>
                        <td class="" int><?=abs($value->total_balance)?> <?=$value->dr_cr?></td>
                        
                       
                    </tr>     
            <?php } ?>
        </table>

    </div>
    <?php } else{ ?>
    <div class="row">
        <div class="col-12 text-center">
            <h2 class="text-danger">Data not available!</h2>
        </div>
    </div>
    <?php } ?>
</div>
<div class="row">
   
</div>



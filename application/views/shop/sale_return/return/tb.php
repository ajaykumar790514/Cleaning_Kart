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
            <h5>LEDGER</h5>
            <h5>( FROM  <?= date_format_func($_POST['from_date']).' to '.date_format_func($_POST['to_date']);?> )</h5>
            <h5>Account : <?=@$rows[0]->v_name?></h5>
        </div>
    </div>
    <div id="grid_table" class="table-responsive">
        <table class="table table-sm">
            <tr class="">
                <th class="">Date</th>
                <th class="">Type</th>
                <th class="">Invoice No.</th>
                <th class="">Particulars</th>
                <th class="" int>Debit</th>
                <th class="" int>Credit</th>
                <th class="" int>Balance</th>
                <th class="">Narration</th>
            </tr>

            <?php $i = $total_dr = $total_cr = 0; if (@$rows) { ?>
            <tr class="">
                
                <td class=""><?= date_format_func($_POST['from_date']);?> </td>
                <td class=""></td>
                <td class=""></td>
                <td class="">Opening Balance</td>
                
                <td class="" int>
                    <?php 
                    if ($opening['total_balance'] > 0) {
                        $total_dr += $opening['total_balance']; 
                        echo _nf(abs($opening['total_balance']));
                    }
                     ?>
                </td>
                <td class="" int>
                    <?php 
                    if ($opening['total_balance'] < 0) {
                        $total_cr += abs($opening['total_balance']);
                        echo _nf(abs($opening['total_balance']));
                    }
                     ?>
                 </td>
                <td class="" int>
                <?php 
                    if (@$opening['total_balance']) {
                        echo _nf(abs($opening['total_balance']));
                        if($opening['total_balance'] > 0){
                            echo ' Dr';
                        }
                        else{
                            echo ' Cr'; 
                        }
                    }
                    $newbalance = $opening['total_balance'];
                    ?> 
                </td>
                <td class=""></td>

               
            </tr>     
            <?php } ?>
            
            <?php foreach($rows as $key => $value) {
                $dr = $value->dr;
                $cr = $value->cr;

                if ($value->txn_type!=3) {
                    $dr = $value->cr;
                    $cr = $value->dr;
                }

                $balance = $dr - $cr;

                $total_dr += $dr; 
                $total_cr += $cr;

             ?>
            <tr class="">
                <td class=""><?= date_format_func($value->PaymentDate)?> </td>
                <td class=""><?= $value->type ?> </td>
                <td class=""><?= $value->orderid ?> </td>
                <td class=""><?=($value->type =='Pymt' or $value->type =='Sale' or $value->type=='Purchase Return' ) ? 'Cr' : 'Dr' ?> <?= $value->name ?></td>
                
                <td class="" int><?=($dr > 0) ? $dr : '' ?> </td>
                <td class="" int><?=($cr > 0) ? $cr : '' ?></td>
                <td class="" int>

                    <?php 
                     $newbalance = $newbalance + $balance;
                     ?>
                    <?= abs($newbalance) ?> <?=($newbalance > 0) ? 'Dr' : 'Cr' ?>
                        

                    </td>
                <td class=""><?= $value->narration?> </td>
            </tr>  
                <?php  if ($value->type=='Sale' && @$value->orderid ) { 
                   
                    $orders = $this->ladger_m->get_order_details($value->order_id);

                    // echo _prx($orders);
                ?>
                <tr class="">
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class="">
                        <table>
                            <tbody>
                            <?php foreach ($orders as $key1 => $value1) {

                                // echo _prx($value1);
                                $dt1 = (@$value1->offer_applied) ? ($value1->discount_type==0) ? 'percentage' : 'fixed' : '';
                                $dt2 = (@$value1->offer_applied2) ? ($value1->discount_type2==0) ? 'percentage' : 'fixed' : '';
                             ?>
                                <tr>
                                    <td><?=$value1->name?></td>
                                    <td>
                                        <?=$value1->qty?> Pcs.
                                    </td>
                                    <td> @ </td>
                                    <td>
                                        <?=$value1->price_per_unit?>
                                    </td>
                                    <td> = </td>
                                    <td><?=$value1->total_price?></td>
                                    <?php if(@$dt1){ ?>
                                    <td>
                                        (Disc1 -  
                                        <?=($dt1=='fixed') ? '₹ ' : ''?> 
                                        <?=$value1->offer_applied?>
                                        <?=($dt1=='percentage') ? ' %' : ''?>)
                                    </td>
                                    <?php } ?>

                                    <?php if(@$dt2){ ?>
                                    <td>
                                        (Disc2 -  
                                        <?=($dt2=='fixed') ? '₹ ' : ''?> 
                                        <?=$value1->offer_applied2?>
                                        <?=($dt2=='percentage') ? ' %' : ''?>)
                                    </td>
                                    <?php } ?>
                                   
                                    
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </td>
                    
                    <td class="" int></td>
                    <td class="" int></td>
                    <td class="" int></td>
                    <td class=""></td>
                </tr> 
                <?php reset($orders); } ?>
            <?php } ?>  
            <tr class="">
                
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class="" int>Total</td>
                
                <th class="" int>
                    <?php
                      echo _nf($total_dr); 
                    ?>
                </th>
                <th class="" int>
                    <?php
                      echo _nf($total_cr); 
                    ?>   
                </th>
                <td class="" int>
                </td>
                <td class=""></td>

               
            </tr> 
            <tr class="">
                
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class="" int>
                    <?php 
                        // $dr_balance =  _nf($total_dr - $total_cr); 
                        if($newbalance > 0){
                            echo 'Debit Balance ';
                        }
                        else{
                            echo 'Credit Balance '; 
                        }
                    ?>
                </td>
                
                <th class="" int>
                   
                </th>
                <th class="" int>
                    <?php
                      echo _nf(abs($newbalance)); 
                    ?>   
                </th>
                <td class="" int>
                </td>
                <td class=""></td>

               
            </tr> 

            <tr class="">
                
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class="" int>Grand Total</td>
                
                <th class="" int>
                   <?= _nf($total_dr)?>
                </th>
                <th class="" int>
                    <?= _nf($total_cr + $newbalance)?>   
                </th>
                <td class="" int>
                </td>
                <td class=""></td>

               
            </tr>   

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



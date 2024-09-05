<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Proforma Invoice</title>
  </head>
  <body>
    <style type="text/css">
body {
  width: 230mm;
  height: 100%;
  margin: 0 auto;
  padding: 0;
  font-size: 10pt;
  line-height: 16px;
  background: rgb(204,204,204); 
}
* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}
.main-page {
  width: 210mm;
  min-height: 297mm;
  margin: 10mm auto;
  padding: 30px 30px;
  background: white;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
.sub-page {
  padding: 1cm;
  height: 297mm;
}
@page {
  size: A4;
  margin: 0mm;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;    
  }
  .main-page {
    margin: 0mm;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;

  }
}
[int]{
  text-align: right!important;
}
[center]{
  text-align: center;
}
[right]{
  text-align: right;
}
[total_amount_words]{
  text-transform: capitalize;
}
.w-10{ width: 10%; }
.w-20{ width: 20%; }
.w-30{ width: 30%; }
.w-40{ width: 40%; }
.w-50{ width: 50%; }
.w-60{ width: 60%; }
.w-70{ width: 70%; }
.w-80{ width: 80%; }
.w-90{ width: 90%; }
.w-100{ width: 100%; }
 [class*=w-]{ float: left;position: relative; }

      [class*=col-]{
        float: left;
        
      }
     
      .table{
        border-color: black;
        margin-bottom: 0;
        font-size: 12px;
      }
      .table>:not(caption)>*>* {
        padding: 0.2rem 0.2rem;
      }

      .header>td>div:first-child{
        font-size: 12px;
      }
      .header>td>div:first-child.w-100>div:last-child{
        text-align: right;
      }
      .header .title{
        text-align: center;
        text-decoration: underline;
      }
      .header .title-2{
        text-align: center;
        font-size: 18px;
        font-weight: 500;
      }
      .header .title-3{
        text-align: center;
        font-size: 12px;
      }

      .address-invoice{
        border-bottom: 0px;
      }
      .address{
        width: 50%;
      }
      .invoice{
        width: 50%;
        position: relative;
      }
      

      .colon:after{
        content: ' : ';
        padding-left: 10px;
        padding-right: 10px;
        margin: auto;
        right: 0;
        position: absolute;
      }



      /*tr.items{
        width: 8.33%;
        float: left;
      }*/

    </style>
    <style type="text/css">
            .items{
              font-size: 11px;
             
            }
            
            .items>tbody>tr:first-child{
              vertical-align: middle;
            }
            .items>tbody>tr:not(:first-child){ border-top:0px ; border-bottom: 0px; }
            .items>tbody>tr:first-child{
              border-top: 1px solid;
              font-size: 9px;
              white-space: nowrap;
             }
            .items>tbody>tr:last-child{border-bottom:1px solid; }
            .items>tbody>tr>td:nth-child(1){ width: 18px; }
            .items>tbody>tr>td:nth-child(2){ width: 240px; }
            .items>tbody>tr>td:nth-child(6){ width: 60px; text-align: right; }
            .items>tbody>tr>td:nth-child(7),
            .items>tbody>tr>td:nth-child(8){ width: 50px; text-align: center; }

            
            .items>tbody>tr.fill-row{ border-top: 0px; border-bottom: 1px solid }

            [percentage]:after{
              content: '%';
            }
            [fixed]:before{
              content: '\20B9'; 
              margin-right: 2px;
            }
          </style>

      <style type="text/css">
              .space>tbody>tr>td{
                height: 20px;
              } 
              .space>tbody>tr{
                border-top: 0px;
                border-bottom: 0px;
              } 
            </style>

    <style type="text/css">
                    .total_amount_words>tbody>tr{
                      border-top: 0px;
                      border-bottom: 0px;
                      font-weight: 500;
                    }
                    </style>
                   <style type="text/css">
                      .amounts{
                        border-right: 0px;
                        height: 77px;
                      }
                      .amounts table{
                        border: 1px solid;
                        border-bottom: 0px;
                      }
                      .amounts table>tbody>tr{
                        border: 0px;
                        border-bottom: 0px;
                      }
                    </style>
                  <style type="text/css">
                      .narration-td{
                        border: 0px;
                        border-right: 1px solid;
                        position: relative;
                        height: 77px;
                      }
                      .narration-td .narration{
                        position: absolute;
                        margin: auto;
                        bottom: 5px;
                        font-size: 15px;
                        font-weight: 500;
                        text-decoration: underline;
                      }
                     
                    </style>
            <style type="text/css">
              .terms-signature{

              }
              .terms-signature .terms{
                width: 60%;
              }
              .terms-signature .signature{
                width: 40%;
              }
              .terms-signature .terms ol{
                    padding-left: 13px;
              }
              .terms-signature .signature .w-100:not(:last-child){
                height: 50px;
              }
              
              
            </style>  
    <section class="main-page">
          <!-- header -->
          <!-- <div class="container-fluid"> -->
            <table class="table table-bordered">
              <tbody>
                <tr class="header">
                  <td class="" colspan="2" style="position: relative;">
                    <div class="w-100">
                      <div class="w-50">
                        GSTIN : <?=$shop->gstin?>
                      </div>
                      <div class="w-50">
                       
                      </div>
                    </div>

                    <div class="w-30" style="position:absolute; margin: auto; text-align: center; bottom: 5px;">
                      <img style="width:140px" src="<?=IMGS_URL.$shop->logo?>">
                    </div>

                    <div class="w-100 title">
                      PROFORMA INVOICE
                    </div>

                    <div class="w-100 title-2">
                      <?=$shop->shop_name?>
                    </div>

                    <div class="w-100 title-3">
                      <?=$shop->address?> 
                    </div>


                    <div class="w-100 title-3">
                      <?=$shop->email?> | <?=$shop->contact?>
                    </div>
                    
                  </td>
                </tr>

                <tr class="address-invoice">
                  <td class="address" >
                    <div class="w-100"> Party Details : </div>
                    <div class="w-100"> <?=$vendor->name?> </div>
                    <div class="w-100"> <?=$vendor->address?> </div>
                    <div class="w-100"> <?=$vendor->pincode?> </div>
                    <div class="w-100" style="height:50px"></div>
                    <div class="w-100">
                      <div class="w-40 colon">Party PAN</div>
                      <div class="w-60"></div>
                    </div>
                    <div class="w-100">
                      <div class="w-40 colon">Party Mobile No.</div>
                      <div class="w-60"><?=$vendor->mobile?></div>
                    </div>
                    <div class="w-100">
                      <div class="w-40 colon">Party Aadhaar No.</div>
                      <div class="w-60"><?=$vendor->aadhar_no?></div>
                    </div>
                    <div class="w-100">
                      <div class="w-40 colon">GSTIN / UIN </div>
                      <div class="w-60"><?=$vendor->gstin?></div>
                    </div>
                  </td>
                  <td class="invoice" >
                    <div class="w-100">
                      <div class="w-30 colon"> Invoice No. </div>
                      <div class="w-70"> #<?=$order['orderid']?> </div>
                    </div>

                    <div class="w-100">
                      <div class="w-30 colon"> Date </div>
                      <div class="w-70"> <?=date('d/M/Y',strtotime($order['datetime']))?> </div>
                    </div>

                    <?php if($order['is_pay_later']==1): ?>
                    <div class="w-100">
                      <div class="w-30 colon"> Due Date </div>
                      <div class="w-70" style="font-size: 14px;font-weight: 700;"> <?=date('d/M/Y',strtotime($order['due_date']))?> </div>
                    </div>
                    <?php endif; ?>


                    <div class="w-100">
                      <div class="w-30 colon"> Place Of Supply </div>
                      <div class="w-70"> 
                      <?=($order['same_as_billing']==1) ? $order['random_address']  : $order['shipping_address'] ?>
                      </div>
                    </div>

                    <div class="w-100">
                      <div class="w-30 colon"> Reverse Charge </div>
                      <div class="w-70"> N </div>
                    </div>

                    
                  </td>

                </tr>
              </tbody>
            </table>
          <!-- </div> -->
          <!-- header -->

          
          <?php $is_igst = $order['is_igst']; ?>
          <table class="table table-bordered items" >
              <tbody>
                <tr>
                  <td>S. N.</td>
                  <td>Description Of Goods</td>
                  <td>HSN/SAC</td>
                  <td>Qty.</td>
                  <td>Unit</td>
                  <td>Free</td>
                  <td >M.R.P. (&#8377;)</td>
                  <!-- <td >List Price (₹)</td> -->
                  <td class="dis">Sche</td>
                  <td class="dis">Ad Sche</td>
                  <?php if(@$is_igst==0): ?>
                  <td>CGST Rate</td>
                  <td>CGST Amount (&#8377;)</td>
                  <td>SGST Rate</td>
                  <td>SGST Amount (&#8377;)</td>
                  <?php else: ?>
                  <td>IGST Rate</td>
                  <td>IGST Amount (&#8377;)</td>
                  <?php endif; ?>
                  <td>Amount (&#8377;)</td>
                </tr>
                <?php
                $sr_n = 0;
                 foreach ($items as $key => $irow) : ?>
                <tr class="item-row item-row1">
                  <td><?=++$sr_n?></td>
                  <td><?=$irow['name']?></td>
                  <td><?=$irow['sku']?></td>
                  <td int nf qty1><?=$irow['qty']?></td>
                  <td><?=$irow['unit_type']?></td>
                  <td int nf free1><?=$irow['free']?></td>
                  <td int nf list_price1><?=$irow['price_per_unit']?></td>
                  
                  <td class="dis" 
                  <?=(@$irow['offer_applied']) ? ($irow['discount_type']==0) ? 'percentage' : 'fixed'
                  : ''?>
                   >
                    <?=$irow['offer_applied']?>
                  </td>
                  <td class="dis" 
                  <?=(@$irow['offer_applied2']) ? ($irow['discount_type2']==0) ? 'percentage' : 'fixed'
                  : ''?>
                  >
                    <?=$irow['offer_applied2']?>
                  </td>
                  <?php if(@$is_igst==0): ?>
                  <td center><?=$irow['tax_value']/2?> %</td>
                  <td int nf cgst1><?=$irow['tax']/2?></td>
                  <td center><?=$irow['tax_value']/2?> %</td>
                  <td int nf sgst1><?=$irow['tax']/2?></td>
                  <?php else: ?>
                  <td center><?=$irow['tax_value']?> %</td>
                  <td int nf igst1><?=$irow['tax']?></td>
                  <?php endif; ?>
                  <td int nf amount1><?=$irow['total_price']?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="fill-row fill-row1">
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <?php if(@$row['is_igst']==0): ?>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <?php else: ?>
                  <td></td>
                  <td></td>
                  <?php endif; ?>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3"><strong>Total : </strong> <span items_total><?=count($items)?></span> </td>
                  <td int nf total_qty1 style="width: auto;" >0</td>
                  <td colspan=""></td>
                  <td int nf total_free1>0</td>
                  <td int total_list_price1>0</td>
                  <td colspan="2"></td>
                  
                 <!--  <td int>1000</td>
                  <td int>500</td> -->
                  <?php if(@$row['is_igst']==0): ?>
                  <td int nf total_cgst1 colspan="2">0</td>
                  <td int nf total_sgst1 colspan="2">0</td>
                  <?php else: ?>
                  <td int total_igst1 colspan="2">0</td>
                  <?php endif; ?>
                  <td int nf total_amount1>0</td>
                </tr>

              </tbody>
            </table>

            
            <table class="table table-bordered space">
              <tbody>
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </table>

            

            
            <table class="table table-bordered total_amount_words">
              <tbody>
                <tr>
                  <td colspan="2" >
                    <div total_amount_words1></div>
                  </td>
                </tr>
                <tr>
                    
                  <td class="w-40 amounts">
                     

                    <table class="table ">
                      <tbody>
                        <tr>
                          <td>Taxable Amount</td> 
                          <td> : </td>
                          <td int nf fixed f_taxable_amount1> 0  </td>
                        </tr>
                        <tr>
                          <td>Total Tax</td> 
                          <td> : </td>
                          <td int nf fixed f_total_tax1> 0  </td>
                        </tr>
                        <tr>
                          <td>Total Amount</td> 
                          <td> : </td>
                          <td int nf fixed f_total_amount1> 0  </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>

                  <td class="w-60 narration-td">
                    <div class="narration">
                      <?=$order['narration']?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            


            <!-- footer -->
           
            
            <table class="table table-bordered footer">
              <tbody>
                

                <tr class="terms-signature">
                  <td class="terms" rowspan="2" >
                    <div class="w-100"><u> Terms & Conditions : </u> </div>
                    <div class="w-100"> E.& O.E. </div>
                    <div class="w-100">
                      <ol>
                        <li>Goods once sold will not be taken back.</li>
                        
                        <li>If payment is not made on due date, Product rate will be charged on M.R.P.</li>
                        <li>Any dispute is subjected to the Kanpur jurisdiction only.</li>
                      </ol>
                    </div>
                    <div class="w-100"><u> Bank Details : </u> </div>
                    <div class="w-100">
                      Bank Name : <?=$shop->bank_name?>
                    </div>
                    <div class="w-100">
                      A/c No : <?=$shop->account_number?>
                      &nbsp;&nbsp;&nbsp;
                      IFSC : <?=$shop->ifsc?>
                      &nbsp;&nbsp;&nbsp;
                      Branch : <?=$shop->branch?>
                    </td>
                  <td class="signature" >
                    <div class="w-100">
                      <p>Receiver's Signature :</p>
                    </div>
                  </td>

                </tr>

                <tr class="terms-signature">
                  
                  <td class="signature" >
                    

                    <div class="w-100" right>
                      for <?=$shop->shop_name?>
                    </div>

                    <div class="w-100" right>
                      <img style="height: 50px;" src="<?=IMGS_URL.$shop->signature?>">
                      
                    </div>

                    <div class="w-100" right>
                      
                      Authorised Signatory
                    </div>

                    
                  </td>

                </tr>
              </tbody>
            </table>
            <!-- footer -->
            
        
    </section>

   

    
  </body>

  <script type="text/javascript">
    jQuery.fn.exists = function(){return this.length>0;}
    function numberToWords(number) {  
        var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];  
        var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];  
        var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];  
        var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];  
  
        number = number.toString(); number = number.replace(/[\, ]/g, ''); if (number != parseFloat(number)) return 'not a number'; var x = number.indexOf('.'); if (x == -1) x = number.length; if (x > 15) return 'too big'; var n = number.split(''); var str = ''; var sk = 0; for (var i = 0; i < x; i++) { if ((x - i) % 3 == 2) { if (n[i] == '1') { str += elevenSeries[Number(n[i + 1])] + ' '; i++; sk = 1; } else if (n[i] != 0) { str += countingByTens[n[i] - 2] + ' '; sk = 1; } } else if (n[i] != 0) { str += digit[n[i]] + ' '; if ((x - i) % 3 == 0) str += 'hundred '; sk = 1; } if ((x - i) % 3 == 1) { if (sk) str += shortScale[(x - i - 1) / 3] + ' '; sk = 0; } } if (x != number.length) { var y = number.length; str += 'point '; for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' '; } str = str.replace(/\number+/g, ' '); return str.trim() + " Only";  
  
    } 




    

    $(document).ready(function(){
      $('[nf]').each(function(){
        // $(this).text(number_format($(this).text(),2));
        $(this).text(parseFloat($(this).text()).toFixed(2));
      })
      
      
      // for (var i = 1; i <= 1; i++) {

        var i = 1;
        $(`tr.item-row${i}`).last().css('border-bottom','0px');
          var items_tb_height = 380;
          var tb_height = 0;
          $(`.item-row${i}`).each(function(){
            tb_height += Number($(this).height());
            $(`tr.fill-row${i}`).css('height',items_tb_height - tb_height);
          })


        var qty       = $(`[qty${i}]`);
        var total_qty = $(`[total_qty${i}]`);
        if (qty.exists()) {
          qty.each(function(){
            total_qty.text( parseFloat(Number($(this).text()) + Number(total_qty.text())).toFixed(2));
          })
        }



        var free        = $(`[free${i}]`);
        var total_free  = $(`[total_free${i}]`);
        if (free.exists()) {
          free.each(function(){
            total_free.text( parseFloat(Number($(this).text()) + Number(total_free.text())).toFixed(2));

          })
        }



        var list_price        = $(`[list_price${i}]`);
        var total_list_price  = $(`[total_list_price${i}]`);
        if (list_price.exists()) {
          list_price.each(function(){
            total_list_price.text( parseFloat(Number($(this).text()) + Number(total_list_price.text())).toFixed(2));
          })
        }



        var cgst        = $(`[cgst${i}]`);
        var total_cgst  = $(`[total_cgst${i}]`);
        if (cgst.exists()) {
          cgst.each(function(){
            total_cgst.text( parseFloat(Number($(this).text()) + Number(total_cgst.text())).toFixed(2));
          })
        }


        var sgst        = $(`[sgst${i}]`);
        var total_sgst  = $(`[total_sgst${i}]`);
        if (sgst.exists()) {
          sgst.each(function(){
            total_sgst.text( parseFloat(Number($(this).text()) + Number(total_sgst.text())).toFixed(2));
          })
        }


        var igst        = $(`[igst${i}]`);
        var total_igst  = $(`[total_igst${i}]`);
        if (igst.exists()) {
          igst.each(function(){
            total_igst.text( parseFloat(Number($(this).text()) + Number(total_igst.text())).toFixed(2));
          })
        }


        var amount        = $(`[amount${i}]`);
        var total_amount  = $(`[total_amount${i}]`);
        if (amount.exists()) {
          amount.each(function(){
            total_amount.text( parseFloat(Number($(this).text()) + Number(total_amount.text())).toFixed(2));
            $(`[total_amount_words${i}]`).text(numberToWords( Number(total_amount.text())));
          })
        }


      // }

      


      

      

      

      

      


      

      function get_amount(j){
        var total_amount = parseFloat($(`[total_amount${j}]`).text());

        console.log(total_amount);
        var f_taxable_amount = ((total_amount * 100)/(Number('<?=$items[0]['tax_value']?>')+100)).toFixed(2);

        $(`[f_taxable_amount${j}]`).text(f_taxable_amount);
        $(`[f_total_tax${j}]`).text((total_amount - f_taxable_amount).toFixed(2));
        $(`[f_total_amount${j}]`).text((total_amount).toFixed(2));
      }

      setTimeout(function() {
        get_amount(1);
        // get_amount(2);
        // get_amount(3);

        window.print();
      }, 50);

      // window.print();      
    })

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>



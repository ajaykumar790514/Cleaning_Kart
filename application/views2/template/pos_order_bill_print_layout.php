<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Bill Invoice</title>
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
  text-align: right;
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
    <section class="main-page">
          <!-- header -->
          <!-- <div class="container-fluid"> -->
            <table class="table table-bordered">
              <tbody>
                <tr class="header">
                  <td class="" colspan="2">
                    <div class="w-100">
                      <div class="w-50">
                        GSTIN : <?=$shop->gstin?>
                      </div>
                      <div class="w-50">
                        Original Copy
                      </div>
                    </div>

                    <div class="w-100 title">
                      TAX INVOICE
                    </div>

                    <div class="w-100 title-2">
                      <?=$shop->shop_name?>
                    </div>

                    <div class="w-100 title-3">
                      <?=$shop->address?>
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
                      <div class="w-70"> #IN1245785 </div>
                    </div>

                    <div class="w-100">
                      <div class="w-30 colon"> Date </div>
                      <div class="w-70"> <?=date('d/M/Y',strtotime($order->datetime))?> </div>
                    </div>

                    <?php if($order->is_pay_later==1): ?>
                    <div class="w-100">
                      <div class="w-30 colon"> Due Date </div>
                      <div class="w-70"> <?=date('d/M/Y',strtotime($order->due_date))?></div>
                    </div>
                    <?php endif; ?>


                    <div class="w-100">
                      <div class="w-30 colon"> Place Of Supply </div>
                      <div class="w-70"> 
                      <?=($order->same_as_billing==1) ? $order->random_address  : $order->shipping_address ?>
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
              content: '₹';
            }
          </style>
          <?php $is_igst = $order->is_igst; ?>
          <table class="table table-bordered items" >
              <tbody>
                <tr>
                  <td>S. N.</td>
                  <td>Description Of Goods</td>
                  <td>HSN/SAC Code</td>
                  <td>Qty.</td>
                  <td>Unit</td>
                  <td >List Price (₹)</td>
                  <td class="dis">Dis.</td>
                  <td class="dis">Dis. 2</td>
                  <?php if(@$is_igst==0): ?>
                  <td>CGST Rate</td>
                  <td>CGST Amount (₹)</td>
                  <td>SGST Rate</td>
                  <td>SGST Amount (₹)</td>
                  <?php else: ?>
                  <td>IGST Rate</td>
                  <td>IGST Amount (₹)</td>
                  <?php endif; ?>
                  <td>Amount (₹)</td>
                </tr>
                <?php
                  // $items = [0,1,2,3,4,5,6];
                  // $items = [0,1,2,3,4,5,6,0,1,2,3,4,5,6,0,1,2,3,4,5,6];
                  // $itemNames = [
                  //       'Dell Inspiron 15 Laptop 11th Gen Intel® Core™ i5-11320H',
                  //       'Dell Inspiron 14 Laptop i5 11th Gen Intel® Core™',
                  //       'ALIENWARE M15 RYZEN EDITION R5 GAMING LAPTOP',
                  //       'Inspiron 14 2-in-1 Laptop AMD Ryzen™ 5',
                  //       'Inspiron 15 3000 laptop 11th Gen Intel® Core™ i3-1115G4',
                  //       'Dell Inspiron 14 11th Gen Intel® Core™ i5-11320H',
                  //       'Dell Inspiron 15 10th Gen Intel® Core™ i3-1125G4',
                  //       ];
                  // shuffle($itemNames);
                $sr_n = 0;
                 foreach ($items as $key => $irow) : ?>
                <tr class="item-row">
                  <td><?=++$sr_n?></td>
                  <td><?=$irow->name?></td>
                  <td><?=$irow->sku?></td>
                  <td int qty><?=$irow->qty?></td>
                  <td>Unit</td>
                  <td int nf list_price><?=$irow->price_per_unit?></td>
                  
                  <td class="dis" 
                  <?=(@$irow->offer_applied) ? ($irow->discount_type==0) ? 'percentage' : 'fixed'
                  : ''?>
                   >
                    <?=$irow->offer_applied?>
                  </td>
                  <td class="dis" 
                  <?=(@$irow->offer_applied2) ? ($irow->discount_type2==0) ? 'percentage' : 'fixed'
                  : ''?>
                  >
                    <?=$irow->offer_applied2?>
                  </td>
                  <?php if(@$is_igst==0): ?>
                  <td center><?=$irow->tax_value/2?> %</td>
                  <td int nf cgst><?=$irow->tax/2?></td>
                  <td center><?=$irow->tax_value/2?> %</td>
                  <td int nf sgst><?=$irow->tax/2?></td>
                  <?php else: ?>
                  <td center><?=$irow->tax_value?> %</td>
                  <td int nf igst><?=$irow->tax?></td>
                  <?php endif; ?>
                  <td int nf amount><?=$irow->total_price?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="fill-row">
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
                  <td colspan="3"><strong>Total :</strong> </td>
                  <td int total_qty style="width: auto;" >0</td>
                  <td colspan=""></td>
                  <td int total_list_price>0</td>
                  <td colspan="2"></td>
                  
                 <!--  <td int>1000</td>
                  <td int>500</td> -->
                  <?php if(@$row['is_igst']==0): ?>
                  <td int nf total_cgst colspan="2">0</td>
                  <td int nf total_sgst colspan="2">0</td>
                  <?php else: ?>
                  <td int total_igst colspan="2">0</td>
                  <?php endif; ?>
                  <td int nf total_amount>0</td>
                </tr>
              </tbody>
            </table>

            <style type="text/css">
              .space>tbody>tr>td{
                height: 100px;
              } 
              .space>tbody>tr{
                border-top: 0px;
                border-bottom: 0px;
              } 
            </style>
            <table class="table table-bordered space">
              <tbody>
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </table>

            <style type="text/css">
              .total_amount_words>tbody>tr{
                border-top: 0px;
                border-bottom: 0px;
                font-weight: 500;
              }
            </style>
            <table class="table table-bordered total_amount_words">
              <tbody>
                <tr>
                  <td>
                    <div total_amount_words></div>
                  </td>
                </tr>
              </tbody>
            </table>


            <style type="text/css">
              .terms-signature{

              }
              .terms-signature .terms{
                width: 40%;
              }
              .terms-signature .signature{
                width: 60%;
              }
              .terms-signature .terms ol{
                    padding-left: 13px;
              }
              .terms-signature .signature .w-100:not(:last-child){
                height: 50px;
              }
              
              
            </style>
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
                        <li>Interest @ 18% p.a. will be charged if the payment is not made with in the stipulated time.</li>
                        <li>Subject to KANPUR jurisdiction only.</li>
                      </ol>
                    </div>
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




    $("tr.item-row").last().css('border-bottom','0px');
    var items_tb_height = 350;
    var tb_height = 0;
    $('.item-row').each(function(){
      tb_height += Number($(this).height());
      $("tr.fill-row").css('height',items_tb_height - tb_height);
    })

    $(document).ready(function(){
      $('[nf]').each(function(){
        // $(this).text(number_format($(this).text(),2));
        $(this).text(parseFloat($(this).text()).toFixed(2));
      })
      

      if ($('[qty]').exists()) {
        $('[qty]').each(function(){
          $('[total_qty]').text( parseFloat(Number($(this).text()) + Number($('[total_qty]').text()))
            );
        })
      }

      if ($('[list_price]').exists()) {
        $('[list_price]').each(function(){
          $('[total_list_price]').text( parseFloat(Number($(this).text()) + Number($('[total_list_price]').text())).toFixed(2));
        })
      }

      if ($('[cgst]').exists()) {
        $('[cgst]').each(function(){
          $('[total_cgst]').text( parseFloat(Number($(this).text()) + Number($('[total_cgst]').text())).toFixed(2));
        })
      }

      if ($('[sgst]').exists()) {
        $('[sgst]').each(function(){
          $('[total_sgst]').text( parseFloat(Number($(this).text()) + Number($('[total_sgst]').text())).toFixed(2));
        })
      }

      if ($('[igst]').exists()) {
        $('[igst]').each(function(){
          $('[total_igst]').text( parseFloat(Number($(this).text()) + Number($('[total_igst]').text())).toFixed(2));
        })
      }


      if ($('[amount]').exists()) {
        $('[amount]').each(function(){
          $('[total_amount]').text( parseFloat(Number($(this).text()) + Number($('[total_amount]').text())).toFixed(2));
          $('[total_amount_words]').text(numberToWords( Number($('[total_amount]').text())));
        })
      }

      // window.print();
    })

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>



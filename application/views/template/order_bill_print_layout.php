<!DOCTYPE html>
<html>
<head>
	<title>Bill Invoice</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/fav-icon.png'); ?>">
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css'); ?>" rel="stylesheet">
	<style type="text/css">
		@page {
		  size: A4 portrait;
		}

		@page :first {
			margin-top: 35pt;
		}
		@page :left {
			margin-right: 30pt;
		}
		@page :right {
			margin-left: 30pt;
		}
		@media print {
			footer {
				display: none;
				position: fixed;
				bottom: 0;
			}
			header {
				display: none;
				position: fixed;
				top: 0;
			}
            .fa-download{
                display: none;
            }
		}
		table, figure {
			page-break-inside: avoid;
		}
		
		* { 
			margin: 0;
			padding: 0;
		}
		body {
			width: 100%;
			display: block;
		}
		#page-wrap { 
			width: 800px;
			margin: 0 auto;
			page-break-before: always;
            border: 1px solid;
		}
		#header { 
			height: 15px;
			width: 100%;
			margin: 20px 0;
			background: #3b3b3e;
			text-align: center;
			color: white;
			font: bold 15px Helvetica, Sans-Serif;
			text-transform: uppercase;
			letter-spacing: 20px;
			padding: 8px 0px;
			page-break-before: always;
		}
		#shop-header { 
			height: 15px;
			width: 100%;
			margin: 20px 0;
			background: #eee ;
			text-align: center;
			color: black;
			font: bold 15px Helvetica, Sans-Serif;
			text-transform: uppercase;
			padding: 8px 0px;
			/* page-break-before: always; */
            margin-top: 0px;
            font-size: 17px;
		}
		#company-details {
			
		}
		#company-logo {
			margin: 10px;
			max-width: 140px;
			max-height: 140px;
			overflow: none;
			position: absolute;
		}
		#company-logo > img {
			width: 100%;
			height: 100%;
		}
		#logo-header {
			margin-left: 200px;
			position: absolute;
			max-width: 600px;
            margin-top: 47px;
		}
		.copy {
			font: bolder 15px Helvetica, Sans-Serif;
			width: 600px;
			text-transform: uppercase;
			text-align: center;
			resize: none;	
			padding-top: 5px;
		}

		#customer {
			overflow: hidden;
			margin-top: 26px;
            margin-bottom: 103px;
            margin-left: 19px;
		}
		#customer-data {
			position: absolute;
		}
		#customer-ship-to { 
			font-size: 13px;
			font-weight: bold;
			float: left; 
		}
		.customer-details {
			padding-top: 3px;
			font-size: 14px;
			font-weight: lighter;
			float: left; 	
		}
		#meta { 
			margin-left: 500px;
			margin-top: 1px;
			width: 300px;
			float: right;
		}

		#meta td {
			text-align: right;
		}
		#meta td.meta-head {
			text-align: left;
			background: #eee;
		}
		#meta td p {
			width: 100%;
			height: 20px;text-align: right;
		}

		#items {
			clear: both;
			width: 100%;
			margin: 30px 0 0 0;
			border: 1px solid black;
            text-align:center;
		}
		#items th {
			background: #eee;
		}
		
		#items th#cost { 
			width: 90px;
		}
		#items th#qty { 
			width: 90px;
		}
		#items th#tax { 
			width: 90px;
		}
		#items th#price { 
			width: 90px;
		}
		#items tr#item-row td {
			border: 0;
			vertical-align: top;
		}

		p { border: 0; font: 14px, Serif; overflow: hidden; resize: none; }
		table { border-collapse: collapse; }
		table td, table th { border: 1px solid black; padding: 5px; }

		#items p { width: 80px; height: 50px; }
		
		
		#items th.description p, #items td.item-name p { width: 100%; }
		#items td.total-line { border-right: 0; text-align: right; }
		
		#items td.total-value { border-left: 0; padding: 10px; }
		
		#items td.total-value p { height: 20px; background: none; }
		#items td.balance { background: #eee; }
		#items td.blank { border: 0; }

		#total-amount { margin: 20px 0 0 5px; }

		#shop-details{
            text-align : center;
        }
        #invoice {
			overflow: hidden;
			margin-top: 190px;
		}
        #customer-name{
            font-size: 16px; 
        }
        #customer-text{
            font-size: 16px;
            margin-top: 3px;    
        }
		hr{
            border: 1px solid black;
            margin-top:15px;
        }
        #shop-contact{
            margin-top:5px
        }
        #authorised
        {
            margin: 11px;
        }
	</style>
</head>
<body onload="window.print()">
	<div id="page-wrap">
		<p id="header" >BILL INVOICE</p>
		<div id="company-details">
			<div id="company-logo">
            	<img id="image" src="<?= base_url('application/photo/logo.jpg'); ?>" alt="logo"/>
            </div>
            <div id="logo-header">
            	<p class="copy">
                INVOICE NO.: <?= $invoice->orderid ?>
            	</p>
            	<p class="copy">
                DATE: <?= date_format_func($invoice->order_date); ?>
            	</p>
            </div>
		</div>
		
		<div id="invoice">
            <p id="shop-header"><?= $invoice->shop_name; ?></p>
            <div id="shop-details">
            	<p><?= $invoice->address.' , '.$invoice->city_name.' , '.$invoice->state_name.' , '.$invoice->pin_code; ?></p>
            	<p id="shop-contact"><b>Contact:</b> <?= $invoice->contact; ?> | <b>Email:</b> <?= $invoice->email; ?></p>
            	<p id="shop-contact"><b>GSTIN:</b> <?= $invoice->gstin; ?></p>
            </div>
		</div>
       <hr>
       <?php if($invoice->address_id == null)
        {
            $address = $invoice->random_address;
            $name = $invoice->fname.' '.$invoice->lname;
            $mobile = $invoice->mobile;
        }
        else
        {
            $address = $invoice->address;
            $name = $invoice->contact_name;
            $mobile = $invoice->contact;
        } 
        ?>

		<div id="customer">
                <div id="customer-data">
                    <p id="customer-name"><strong>Name - <?= $name; ?></strong></p>
                    <p id="customer-text">Address - <?= $address; ?></p>
                    <p id="customer-text">Phone - <?= $mobile; ?></p>
                    <p id="customer-text">Email- <?= $invoice->cust_email; ?></p>
                </div>
               
		</div>
		<?php 
            $inclusive_tax = $invoice->total_value - ($invoice->total_value * (100/ (100 + $invoice->tax_value)));   
            $rate =($invoice->total_value/$invoice->item_qty) - $inclusive_tax;
        ?>
		<table id="items">
			<tr>
				<th id="item-name">Particular(s)</th>
				<th id="qty">Qty</th>
				<th id="cost">Rate</th>
				<th id="price">Amount</th>
			</tr>
            <tr>
                <td><?= $invoice->product_name; ?></td>
                <td><?= $invoice->item_qty; ?></td>
                <td>₹<?= round($rate,2); ?></td>
                <td>₹<?= round($rate*$invoice->item_qty,2); ?></td>
            </tr>
		  
		</table>
        <?php if($invoice->is_igst == '1')
        {
            $igst = $invoice->order_tax * $invoice->item_qty;
            $cgst = '0';
            $sgst = '0';
            $igst_per = $invoice->tax_value;
            $cgst_per = '0';
            $sgst_per = '0';
        }
        else
        {
            $igst = '0';
            $cgst = ($invoice->order_tax * $invoice->item_qty)/2;
            $sgst = ($invoice->order_tax * $invoice->item_qty)/2;
            $igst_per = '0';
            $cgst_per = $invoice->tax_value/2;
            $sgst_per = $invoice->tax_value/2;
        } 
        ?>
		<table id="items">
			<tr>
				<th id="item-name">Total</th>
                <td>₹<?= round($rate*$invoice->item_qty,2); ?></td>
			</tr>
			<tr>
				<th id="item-name">SGST @ <?= round($sgst_per,2).'%'; ?></th>
                <td>₹ <?= round($sgst,2); ?></td>
			</tr>
			<tr>
				<th id="item-name">CGST @ <?= round($cgst_per,2).'%'; ?></th>
                <td>₹ <?= round($cgst,2); ?></td>
			</tr>
			<tr>
				<th id="item-name">IGST @ <?= round($igst_per,2).'%'; ?></th>
                <td>₹ <?= round($igst,2); ?></td>
			</tr>
			<tr>
				<th id="grand-total">Grand Total</th>
                <th>₹<?= round($invoice->total_value,2); ?></th>
			</tr>
		  	
		</table>
		<div id="total-amount">
		  	<h3>Total Amount (INR - in words) : <?= number_to_word($invoice->total_value); ?></h3>
		</div>
        <hr>
        <div>
		  	<h3 id="authorised">Authorised Signatory</h3>
		</div>
	</div>
</body>
</html>

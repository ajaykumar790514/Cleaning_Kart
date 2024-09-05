<div class="row return-box">
	<form action="<?=base_url()?>purchase_return/store"	 method="POST" class="return-form ajaxsubmit reload-tb add-form">
		<div class="col-md-6">
			<strong>Vendor : </strong><span class="vendor_name"></span>
			<input type="hidden" name="vendor_id">
		</div>

		<div class="col-md-6">
			<strong>Product : </strong><span class="product_name"></span>
			<input type="hidden" name="product_id" >

		</div>
		<div class="col-12"><br></div>

		<div class="col-md-3">
            <div class="form-group">
	            <label class="control-label">Qty<sup>*</sup> :</label>
	            <input type="number" class="form-control" name="return_qty" min="1" >
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
	            <label class="control-label">Return Rate<sup>*</sup> : </label>
	            <input type="number" class="form-control" name="return_rate" min="1" step="0.01">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
	            <label class="control-label">Total : </label>
	            <input type="number" class="form-control" name="return_total" readonly>
            </div>
        </div>

       <!--  <div class="col-md-3">
        	<div class="form-group">
	            <label class="control-label">Invoice No : </label>
	            <input type="text" class="form-control" name="invoice_no">
            </div>
        </div> -->

        <div class="col-md-3">
        	<div class="form-group">
	            <label class="control-label">Return Date : </label>
	            <input type="date" class="form-control" name="return_date">
            </div>
        </div>

        <div class="col-md-12">
        	<div class="form-group">
	            <label class="control-label">Remark : </label>
	            <input type="text" class="form-control" name="remark">
            </div>
        </div>

		<div class="col-12">
	        <div class="form-group" >
	            <label class="control-label">Select Stock For Return<sup>*</sup></label>
	            <span class="stock"></span>
	        </div>         
		</div>

		<div class="col-12">
            <div class="form-group">
	            <label class="control-label"><br></label>
	            <input type="submit" class="btn btn-primary btn-sm text-white" value="Save" name="return_store" >
            </div>
        </div>
	</form>
</div>

<script type="text/javascript">
	var vendor_id = $('.tb-filter select[name=vendor_id]').val();
	var pro_id = $('.tb-filter select[name=product_id]').val();

	if (vendor_id!='' && pro_id!='') {
		var vendor_name = $('.tb-filter select[name=vendor_id] option:selected').text();
		var product_name = $('.tb-filter select[name=product_id] option:selected').text();
		$('.vendor_name').text(vendor_name);
		$('.product_name').text(product_name);
		$('.stock').load(`<?=base_url()?>purchase_return/get_stocks/`+pro_id+'/'+vendor_id);
		$('input[name=vendor_id]').val(vendor_id);
		$('input[name=product_id]').val(pro_id);
	}
	else{
		$('.return-box').html(`<h2 class='text-center text-danger w-100'>Select vendor and product</h2>`);
	}
	
</script>
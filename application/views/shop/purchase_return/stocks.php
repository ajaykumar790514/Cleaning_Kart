<table class="table table-bordered w-100 table-sm">
	<tbody>
		<tr>
			<th></th>
			<th>Vendor</th>
			<th int>Qty</th>
			<th int>Purchase Rate</th>
			<th int>MRP</th>
			<th>Expiry Date</th>
		</tr>
		<?php foreach ($stocks as $key => $row) : 
			$check_box_id = uniqid().$key; ?>
		<tr>
			<td center>
				<fieldset class="vendors">
                    <input type='radio' name='stock_id' value="<?=$row->id?>" id="<?=$check_box_id?>" >
                    <label for="<?=$check_box_id?>" class="control-label"></label>
                </fieldset>
			</td>
			<td><?=$row->vendor_name?> (<?=$row->vendor_code?>)</td>
			<td int><?=$row->qty?></td>
			<td int><?=$row->purchase_rate?></td>
			<td int><?=$row->mrp?></td>
			<td><?=$row->expiry_date?></td>
		</tr>
			
		<?php endforeach; ?>
	</tbody>
</table>
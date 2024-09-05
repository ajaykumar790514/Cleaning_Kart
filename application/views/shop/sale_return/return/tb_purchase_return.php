
<div class='table-responsive'>
	<table class='table table-bordered table-sm'>
		<thead>
			<tr>
				<th>Sr. No.</th>
				<th>Name</th>
				<th>Product</th>
				<th int>Qty</th>
				<th int>Return Rate</th>
				<th int>Total</th>
				<th>Date</th>
				<th>Invoice No.</th>
				<th>Remark</th>
				<!-- <th>Action</th>  -->
			</tr>
		</thead>
		<tbody>
		<?php 
		if (@$rows) :
			foreach ($rows as $key => $value) :
				$i = $key+1;
				echo "<tr>
					<td> $i </td>
					<td> $value->name ( $value->code ) </td>
					<td> $value->product_name ( $value->product_code ) </td>
					<td int> $value->qty </td>
					<td int> $value->rate </td>
					<td int> $value->total </td>
					<td> ".date_format_func($value->date)." </td>
					<td> $value->invoice_no </td>
					<td> $value->remark </td>
				</tr>";
			endforeach;
		else:
			echo "<tr><td colspan=7 class='text-center tex-danger'>Data Not Found!</td></tr>";
		endif; 
		?>
		</tbody>
	</table>
</div>



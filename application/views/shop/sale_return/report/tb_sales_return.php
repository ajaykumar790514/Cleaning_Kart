
<div class='table-responsive'>
	<table class='table table-bordered table-sm'>
		<thead>
			<tr>
				<th>Sr. No.</th>
				<th>Name</th>
				<th>Product</th>
				<th int	>Quantity</th>
				<th int>Return Rate</th>
				<th int>Total</th>
				<th int>Discount %</th>
				<th center>Date</th>
				<th>Invoice No.</th>
				<th>Remark</th>
				<!-- <th>Action</th>  -->
			</tr>
		</thead>
		<tbody>
		<?php 
		if (@$rows) :
			$total = 0;
			foreach ($rows as $key => $value) :
				$i = $key+1;
				$total += $value->total;
				$free = (@$value->free) ? "( $value->free free )" : '';
				echo "<tr>
					<td> $i </td>
					<td> $value->name ( $value->code ) </td>
					<td> $value->product_name ( $value->product_code ) </td>
					<td int> $value->qty $free </td>
					<td int> $value->rate </td>
					<td int> $value->total </td>
					<td int> $value->discount </td>
					<td center> ".date_format_func($value->date)." </td>
					<td> $value->invoice_no </td>
					<td> $value->remark </td>
				</tr>";
			endforeach;
			echo "<tr>
					<td colspan='5' int><strong> Total </strong> </td>
					<td int> <strong> "._nf($total)." </strong> </td>
					<td colspan='5'></td>
				</tr>";
		else:
			echo "<tr><td colspan='10' class='text-center tex-danger'>Data Not Found!</td></tr>";
		endif; 
		?>
		</tbody>
	</table>
</div>



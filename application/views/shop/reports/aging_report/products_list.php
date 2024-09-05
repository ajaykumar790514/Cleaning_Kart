<style type="text/css">
	table ul{
		padding: 0;
		list-style: none;
		white-space: nowrap;
	}
	table [desc]{
		max-width: 170px;
	}
</style>
<table class="table table-sm">
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th desc>Product Name</th>
			<th desc>Category</th>
			<th>Unit Type</th>
			<th class=""></th>
			<?php foreach (array_keys($rows[0]['months']) as $thmonth) {
				echo "<th int> $thmonth </th>";
			} ?>
		</tr>
	</thead>
	<tbody>

		<?php
		if (!@$rows) {
			echo "<tr><td class='text-center' colspan='6'><h4 class='text-danger'>Data Not Found!</h4></td></tr>";
		}

		foreach ($rows as $key => $row) { ?>
		<tr>
			<td><?=++$key?></td>
			<td desc><?=$row['Product Name']?></td>
			<td desc><?=$row['Category']?></td>
			<td><?=$row['Unit Type']?></td>
			<td>
				<ul>
					<li>Opening Stock</li>
					<li>Purchase</li>
					<li>Sale</li>
					<li>Closing Stock</li>
				</ul>
			</td>
			<?php foreach ($row['months'] as $tdmonth) { ?>
			<td int>
				<ul>
				<?php foreach ($tdmonth as $tdvalue) { ?>
					<li><?=$tdvalue?></li>
				<?php } ?>
					
				</ul>
			</td>	
			<?php } ?>

		</tr>	
		<?php } ?>
	</tbody>
</table>
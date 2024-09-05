<table class="table" style="border:1px solid black">
<thead class="thead-light">
    <tr style="border:1px solid black">
        <th class="text-center">Available Slots</th>
    </tr>
    </thead>
    <tbody>
        <?php if(!empty($available_slots)){ foreach($available_slots as $slots) {?>
    <tr>
        <td class="text-center"><?php echo $slots->timestart; ?> - <?php echo $slots->timeend; ?></td>
    </tr>
    <?php } } else{ ?>
    <tr>
        <td class="text-center">No Slots Found!!</td>
    </tr>
    <?php } ?>
    </tbody>
</table>
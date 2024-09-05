<?php if($flg==1)
            {?> 
        <a class="btn btn-sm btn-success" href="javascript:void(0)" onclick="remove_offer(<?= $oid.','.$value.','.$discount_type;?>)">Remove</a>
        <?php } 
            else { ?>
      <a class="btn btn-sm btn-success" href="javascript:void(0)" onclick="add_offer(<?= $oid.','.$value.','.$discount_type;?>)">Apply</a>
      <?php } ?>
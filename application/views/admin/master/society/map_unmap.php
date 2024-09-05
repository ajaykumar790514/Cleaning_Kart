<?php if($flg==1){?> 
    <input type='checkbox' value='1' class="checkbtn" id="btn<?= $shop_id;?>" onclick="remove_linked_shop(<?= $shop_id;?>)" checked>
    <label for="btn<?= $shop_id;?>"></label>
<?php } else { ?>
    <input type='checkbox' value='1' class="checkbtn" id="btn<?= $shop_id;?>" onclick="link_shop(<?= $shop_id;?>)">
    <label for="btn<?= $shop_id;?>"></label>
<?php } ?>
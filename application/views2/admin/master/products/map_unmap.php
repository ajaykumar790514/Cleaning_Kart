<?php if($flg==1)

            {?> 
            <input type='checkbox' onclick="remove_map_product(<?= $pid ?>);" id="pcheckbox<?= $pid ?>" checked>
            <label for="pcheckbox<?= $pid ?>"></label>

        <?php } 

            else { ?>
            <input type='checkbox' onclick="map_product(<?= $pid ?>);" id="box<?= $pid ?>">
            <label for="box<?= $pid ?>"></label>
            <?php } ?>

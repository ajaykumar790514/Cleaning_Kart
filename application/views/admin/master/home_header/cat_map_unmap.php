<?php if($flg==1)
            {?> 
            <a class="color-white" href="javascript:void(0)" onclick="remove_map_category(<?= $cid ?>);" style="color:white;"> Remove </a>
        <?php } 
            else { ?>
            <a href="javascript:void(0)" onclick="map_category(<?= $cid ?>);" style="color:white;">Map</a>
            <?php } ?>
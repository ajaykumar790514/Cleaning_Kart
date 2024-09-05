<?php if($status_data->active == 0) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $status_data->socity_id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $status_data->socity_id;?>)">Inactive</button>
                                                        <?php }?>
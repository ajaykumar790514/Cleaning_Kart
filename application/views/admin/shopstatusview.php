<?php if($status_data->isActive == 0) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $status_data->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $status_data->id;?>)">Inactive</button>
                                                        <?php }?>
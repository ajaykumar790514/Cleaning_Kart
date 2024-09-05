<div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><strong>Order Status</strong></h4>
                                <div class="table-responsive">
                                <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>
                                                    <select class="select" id="order-status" style="width: 100%" data-placeholder="Choose">
                                                    <?php if($order_status_id =='4' || $order_status_id =='6' || $order_status_id =='1'){
                                                                if($order_status_id =='4'){ 
                                                                    echo '<option value="4">Completed</option>';
                                                                }else if($order_status_id=='1') {
                                                                    echo '<option value="1">Pending Payment</option>';
                                                                }else{
                                                                    echo '<option value="6">Cancelled</option>';
                                                                }
                                                            } else{?>
                                                            <option value="">Select</option>
                                                            <?php foreach ($orderStatus as $status) { ?>
                                                            <option value="<?= $status->id; ?>" <?php if($order_status_id == $status->id){echo "selected";} ?>>
                                                                
                                                                <?= $status->name; ?>
                                                            </option>
                                                            <?php }} ?>
                                                    </select>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"><button class="btn btn-danger float-right" onclick="update_order_status(<?= $sid ?>)">Update Status</button></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>


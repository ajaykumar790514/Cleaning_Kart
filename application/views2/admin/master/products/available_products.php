<style>

    input[type=number]:focus {

     border: 3px solid #555;

     color:red;

    }

    input[type=number] {

        /* width: 100%; */

        padding: 10px 0px;

        /* margin: 8px 0; */

        box-sizing: border-box;

        border: 2px solid #555;

        font-size : 17px;

        text-align : center;

    }

</style>
<input type="hidden" value=<?php echo $product_id; ?> id="product_id">

<table class="table table-striped table-bordered base-style" style="border:1px solid black">
<thead>

    <tr style="border:1px solid black">

        <th class="text-center">Image</th>

        <th class="text-center">Product Name</th>

        <th class="text-center">Product Code</th>

        <th class="text-center">Action</th>

    </tr>

    </thead>

    <tbody>

        <?php

        $flg=0;

        

        foreach($available_products as $products) {?>

    <tr>

        <td class="text-center"><img src="<?php echo IMGS_URL.$products->img; ?>" alt="image" height="100"></td>

        <td class="text-center"><?= $products->name.'('.$products->unit_value.' '.$products->unit_type.')';?></td>

        <td class="text-center"><?= $products->product_code;?></td>


        <?php foreach($product_mapping as $mapping) 

        {

             if($mapping->map_pro_id == $products->id || $mapping->pro_id == $products->id)

             {

                     $flg=1;   

             }

        }

        ?>
        <td id="changeaction2<?= $products->id ?>">

        <?php if($flg==1)

            {?> 
            <input type='checkbox' onclick="remove_map_product(<?= $products->id ?>);" id="pcheckbox<?= $products->id ?>" checked>
            <label for="pcheckbox<?= $products->id ?>"></label>

        <?php } 

            else { ?>
            <input type='checkbox' onclick="map_product(<?= $products->id ?>);" id="box<?= $products->id ?>">
            <label for="box<?= $products->id ?>"></label>

            <?php } ?>

        </td>

       

    </tr>

    <?php $flg=0; }?>

    </tbody>

</table>

<script type="text/javascript">

   function map_product(pid)

   {


    if(confirm('Are you sure?') == true)

    {
        var product_id = $('#product_id').val();

        $.ajax({

            url: "<?php echo base_url('master-data/products/map_product'); ?>",

            method: "POST",

            data: {

                pid:pid,

                product_id:product_id,

            },

            success: function(data){
                toastr.success('Product Mapped Successfully..');
                $("#changeaction2"+pid).html(data);
            },

        });

    }

   }

</script>



   <script type="text/javascript">

   function remove_map_product(pid)

   {

    if(confirm('Do you want to remove this?') == true)

    {

        var product_id = $('#product_id').val();

        $.ajax({

            url: "<?php echo base_url('master-data/products/remove_map_product'); ?>",

            method: "POST",

            data: {

                pid:pid,

                product_id:product_id

            },

            success: function(data){
                toastr.success('Product Unmapped Successfully..');
                $("#changeaction2"+pid).html(data);

            },

        });

    }

   }

</script>
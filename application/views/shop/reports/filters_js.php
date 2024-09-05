<script type="text/javascript">
	// Ankit Verma
jQuery.fn.exists = function(){return this.length>0;}

function fill_products(){
    if($('[name=product_id]').exists()){
        var filter_data = $('.tb-filter').serialize();
        $.ajax({
            url: '<?=base_url('reports/fill_products')?>',
            type: "POST",
            data: filter_data,
            success: function(data){
                $('[name=product_id]').html(data);
            },
        });
    }
}


$('body').on('submit','.tb-filter',function() {
    // $("#tb").html('<div class="cla text-center"><img src="loader.gif"></div>');
    var t = $(this);
    $.ajax({
        url: t.attr("action"),
        type: t.attr("method"),
        data: t.serialize(),
        success: function(data){
            $("#tb").html(data);
        }
    });
    return false;
})

$('body').on('click','.export-to-excel',function(){
    var t = $(this);
    $.ajax({
        url: t.attr("href"),
        type: 'POST',
        data: $('.tb-filter').serialize(),
        success: function(data){
            // $("#tb").html(data);
        }
    });
    return false;
})

$('body').on('change','[name=vendor_id]',function() {
	fill_products();
})

$('body').on('change','[name=parent_id]',function() {
    var parent_id = $(this).val();
    if($('[name=product_id]').exists()){
        $('[name=product_id]').html(`<option value='' >Select Category First</option>`);
    }
    $('[name=parent_cat_id]').load(`<?=base_url('reports/fetch_category?parent_id=')?>${parent_id}`);
})

$('body').on('change','[name=parent_cat_id]',function() {
    var parent_id = $(this).val();

    if($('[name=product_id]').exists()){
        $('[name=product_id]').html(`<option value='' >Select Category First</option>`);
    }
    fill_products();
    if($('[name=sub_cat_id]').exists()){
        $('[name=sub_cat_id]').load(`<?=base_url('reports/fetch_category?parent_id=')?>${parent_id}`);
    }
})

$('body').on('change','[name=sub_cat_id]',function() {
    fill_products();
})


$('body').on('change','[name=brand_id]',function() {
	fill_products();
})


$(document).on('click', '.pag-link', function(event){
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0;

    $.ajax({
        url: $(this).attr('href'),
        type: 'post',
        data: $('.tb-filter').serialize(),
        success: function(data){
            $("#tb").html(data);
        },
    });
    return false;
})

$(document).ready(function(){
    $('body').on('change | keyup','.tb-filter',function() {
        $('.tb-filter').submit();
        return false;
    })


    $('body').on('click','.tb-filter input[type=reset]',function() {
        $('.tb-filter')[0].reset();
        $('.tb-filter').submit();
        return false;
    })

$.ajax()

// display: none; */
//     opacity: .5;

})

$( document ).ajaxStart(function() {
  $('.preloader').addClass('preloader-ajax');
  setTimeout(function() {
    $('.preloader').removeClass('preloader-ajax');
  }, 2000);
});
$( document ).ajaxStop(function() {
  $('.preloader').removeClass('preloader-ajax');
});


</script>
<style type="text/css">
    .preloader-ajax{
        display: block!important;
        background: transparent;
    }
</style>
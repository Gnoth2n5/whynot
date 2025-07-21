$(document).ready(function(){
   console.log('product-detail.js loaded');
   let sizes = JSON.parse(jQuery('#data-size').attr('data-sizes'))
   let color = $('#data-color').val()
   showSize(color, sizes);
   updateDynamicPrice();
   //lắng nghe sự thay đổi của màu sắc
   $(document).on('change', '#data-color', function(){
      console.log('Color changed');
      let color = $('#data-color').val()
      showSize(color, sizes);
      updateDynamicPrice();
   })

   // lắng nghe sự thay đổi của size
   $(document).on('change', '#data-size', function(){
      console.log('Size changed');
      let sizes = JSON.parse(jQuery('#data-size').attr('data-sizes'))
      updateDynamicPrice();
      let productSizeId = $('#data-size').val();
      let dataColor = $('#data-color').val()
      sizes.forEach(element => {
         if (element.product_color_id == dataColor && element.product_size_id == productSizeId) {
            $('#quantity_remain').val(element.quantity)
         }
      });
   })

   // khi dùng chọn sao thì tô màu
   $(document).on('click', '.star', function(){
         $('.rating label .fa-star').css({
            "color": "#b1b1b1",
         })
         let star = $(this).attr('id');
         for (let i = 1; i <= star.split('star')[1]; i++){
            $(`#icon-star${i} i`).css({
               "color": "#F5A623",
            });
         }
   })
 })

function showSize(color, sizes)
{
   let option = '';
   sizes.forEach(element => {
    if (element.product_color_id == color) {
       option += `
          <option value='${element.product_size_id}'>${element.size_name}</option>
       `
    }
   });
   $('#data-size').html(option)
   showQuantity(sizes);
}

function showQuantity(sizes)
{
   let size = $('#data-size').val()
   sizes.forEach(element => {
      if (element.product_size_id == size) {
         $('#quantity_remain').val(element.quantity)
      }
     });
}

function updateDynamicPrice() {
   let sizes = JSON.parse(jQuery('#data-size').attr('data-sizes'));
   let productSizeId = $('#data-size').val();
   let dataColor = $('#data-color').val();
   let found = false;
   sizes.forEach(element => {
      if (element.product_color_id == dataColor && element.product_size_id == productSizeId) {
         if (element.price_sell && element.price_sell > 0) {
            console.log('Dynamic price found:', element.price_sell);
            $('.amount').text(element.price_sell.toLocaleString('vi-VN') + ' VNĐ');
            found = true;
         }
      }
   });
   if (!found) {
      console.log('No dynamic price');
      $('.amount').text($('#amount-default').data('default'));
   }
}
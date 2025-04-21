window.onload = function(){
  $('#sessionMessage').modal('show');
};

$(function() {
  $('.calendar').datepicker({
    // buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
    buttonText: "<i class='fa fa-calendar'></i>", // ツールチップ表示文言
    buttonImageOnly: false,           // 画像として表示
    showOn: "both",                 // カレンダー呼び出し元の定義
    onSelect: function (date, obj) {
      if(obj.id == 'date_purchase'){
        $('#date_start').val(date);
      }
      if(obj.id == 'date_purchase' || obj.id == 'date_start'){
        var date_end = new Date(date);
        date_end.setFullYear(date_end.getFullYear()+10);
        date_end.setDate( date_end.getDate()-1);
        var year = date_end.getFullYear();
        var month = ('0'+(date_end.getMonth()+1)).slice(-2);
        var day = ('0'+date_end.getDate()).slice(-2);
        $('#date_end').val(year + '-' + month + '-' + day);
      }
    }
  });
});


$(document).ready(function() {
  $('.list-table').tablesorter({
    headers: {
      0: { sorter: false },
      6: { sorter: false },
      7: { sorter: false },
      8: { sorter: false },
   }
  });
});

  // 入力できる行数の最大値
  var MAX_LINE_NUM = 2;
  var textarea = document.getElementById("payee");
  if(textarea !== null){
    textarea.addEventListener("input", function() {
      let lines = textarea.value.split("\n");
      if (lines.length > MAX_LINE_NUM) {
        var result = "";
        for (var i = 0; i < MAX_LINE_NUM; i++) {
          result += lines[i] + "\n";
        }
        textarea.value = result;
      }
    }, false);
  }


$(function(){
  //非表示にしたい要素
  var hide_elm = $('.header, .nav-serach, .form-submit');
  //ボタンをクリック
  $('.printStart').click(function(){
    //非表示
    hide_elm.addClass('non_print');
    //印刷
    window.print();
    //元に戻す
    hide_elm.removeClass('non_print');
  });
});

// $(function() {
//   var $product_name = $('#product_name');
//   var product_name_html = $product_name.html();

//   $('#product_maker').change(function() {
//     var product_maker = $(this).val();

//     $product_name.html(product_name_html).find('option').each(function() {
//       var maker_id = $(this).data('val');

//       if(!product_maker){
//       }else if (product_maker != maker_id) {
//         $(this).not('optgroup').remove();
//       }
//     });
//   });
// });

// $(function() {
//   var $name_pre = $('#product_name');
//   var name_pre_html = $name_pre.html();
  
//   var maker_pre = $('#product_maker').val();

//   $name_pre.html(name_pre_html).find('option').each(function() {
//     console.log(maker_pre);
//     var maker_id_pre = $(this).data('val');
//     if(!maker_pre){
//     }else if (maker_id_pre != maker_pre) {
//       $(this).not('optgroup').remove();
//     }
//   });
// });
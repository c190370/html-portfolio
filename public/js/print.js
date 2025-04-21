$(function(){
    //非表示にしたい要素
    var hide_elm = $('.invoice_print');
    //ボタンをクリック
    $('.invoice_print').click(function(){
      //非表示
      hide_elm.addClass('non_print');
      //印刷
      window.print();
      //元に戻す
      hide_elm.removeClass('non_print');
    });
  });
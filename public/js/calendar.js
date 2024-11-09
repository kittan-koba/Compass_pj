// $(function(){

//   // ここにモーダルが開いてキャンセルするか否かの内容を記載する。

// });

// ---ここより下に記載---

$(function () {
    $('.modal_open').on('click', function () {
        $('.delete_modal').show();

        var reservePart = $(this).attr('reserve_part');
        var reserveDate = $(this).attr('reserve_date');

        $('.reserve_part').val(reservePart);
        $('.reserve_date').val(reserveDate);

        $('.reserve_date').text('予約日：' + reserveDate);
        $('.reserve_part').text('時間：リモ' + reservePart + '部');
    });


    $('.modal_close').on('click', function () {
        $('.delete_modal').hide();
    });
});

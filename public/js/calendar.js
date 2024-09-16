$(function () {
  $('.js-modal-open').on('click', function () {
    var setting_reserve = $(this).val(); // 予約日
    var reserve_part = $(this).attr('reserve_part'); // 部数

    // モーダル内のフィールドに値をセット
    $('.modal-inner-date input').val(setting_reserve);
    $('.modal-inner-time input').val(reserve_part);

    // モーダルを表示
    $('.js-modal').fadeIn();
    return false; // デフォルトの動作をキャンセル
  });

  // モーダルの背景をクリックで閉じる
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false; // デフォルトの動作をキャンセル
  });
});

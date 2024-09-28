$(function () {
  //カテゴリのトグル表示:
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  //いいねボタンのトグル:
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text(); //現在のいいね数を取得します
    var countInt = Number(count); //数字に変換

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {
    });
  });

  // いいね数をサーバーから取得して更新する関数
  function updateLikeCount(post_id) {
    $.ajax({
      url: "/get-like-count/" + post_id,
      method: "GET",
      success: function (data) {
        $('.like_counts' + post_id).text(data.like_count);
      },
      error: function () {
        console.log('Failed to update like count');
      }
    });
  }

  //編集モーダルの表示と閉じる:
  //編集モーダルを開く
  $('.edit-modal-open').on('click', function () {
    //モーダルの表示:
    $('.js-modal').fadeIn();
    //データの取得:
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    //モーダル内のタイトル入力フィールドとテキストエリアに、取得したデータを設定
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });

  //編集モーダルを閉じる
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});


document.addEventListener('DOMContentLoaded', function () {
  // 全てのメインカテゴリーを取得
  const mainCategories = document.querySelectorAll('.main_categories_title');

  // それぞれのメインカテゴリーにクリックイベントを追加
  mainCategories.forEach(function (category) {
    category.addEventListener('click', function () {
      // クリックしたメインカテゴリーの次の要素としてサブカテゴリーリストを取得
      const subCategories = this.nextElementSibling;

      // サブカテゴリーを表示・非表示に切り替え
      if (subCategories.style.display === 'none' || subCategories.style.display === '') {
        subCategories.style.display = 'block'; // 表示
      } else {
        subCategories.style.display = 'none';  // 非表示
      }

      // 矢印の向きを切り替えるために.activeクラスをトグル
      this.classList.toggle('active');
    });
  });
});

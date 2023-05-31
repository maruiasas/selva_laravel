$(function () {

  // 商品カテゴリの変更イベントを検知
  $('#product_categories').on('change', function (){

    // 選択されたカテゴリのIDを取得
    let id = $("#product_categories").val();

    // Ajaxリクエストを送信
    $.ajax({
      type: "GET",
      url: "/products/category",
      data: { "id" : id },
      dataType : "json"
    })
    .done(function(data){ // 成功時の処理

      $('#product_subcategories option').remove();

      //取得jsonデータ
      let data_stringify = JSON.stringify(data);
      let data_json = JSON.parse(data_stringify);

      //出力
      var groups = {};
      for (var key in data_json) {
        var id = data_json[key].id;
        var name = data_json[key].name;
        if (groups[id]) {
          groups[id].push(name);
        } else {
          groups[id] = [name];
        }
      }

      // セレクトボックスに表示
      var selectBox = $('#product_subcategories');
      for (var id in groups) {
        var group = groups[id];
        var option = $('<option>');
        var optionText = '';
        for (var i = 0; i < group.length; i++) {
          var name = group[i];
          optionText += name;
          if (i !== group.length - 1) {
            optionText += ' / ';
          }
        }
        option.text(optionText);
        option.attr('value', id); // value属性を設定
        selectBox.append(option);
      }
    })
    .fail(function (data) {
      // error
      console.log('error');
    });
  });
});

  // 画像アップロードのイベントを検知
  $("[name^='image_']").on('change', function() {
    alert('aaa');
      // csrfをセット
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // アップロードするファイルのデータ取得
    let fileData = this.files[0];
    // フォームデータを作成する
    let formData = new FormData();
    // フォームデータにアップロードファイルの情報を追加
    formData.append('file', fileData);

    let uncle = $(this).parent().prev();

    // Ajaxリクエストを送信
    $.ajax({
      type: "POST",
      url: "/members/upload",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
    })
    .done(function(data){ // 成功時の処理

    console.log(fileData);
      // JSONオブジェクトを受信したら、'upload'キーに対応する値を取得する
    var uploadPath = data.upload;
  
    // 画面に表示するために、適切なHTML要素を作成する
    var imgElement = "<img src='" + uploadPath + "'/>";

    // 作成したHTML要素を、適切な場所に挿入する
  uncle.html(imgElement);

    }).fail(function (data) {
      // error
      alert('ファイルの容量が大きすぎます');
    });
  });
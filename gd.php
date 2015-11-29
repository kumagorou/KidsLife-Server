<?php
if (!empty($_GET['url'])) {
    $image_file = $_GET['url'];
}

$new_width = 100;
if (!empty($_GET['width'])) {
    $new_width = $_GET['width'];
}

// 元画像のファイルサイズを取得
list($original_width, $original_height) = getimagesize($image_file);

//元画像の比率を計算し、高さを設定
$proportion = $original_width / $original_height;
$new_height = $new_width / $proportion;

//高さが幅より大きい場合は、高さを幅に合わせ、横幅を縮小
if($proportion < 1){
    $new_height = $new_width;
    $new_width = $new_width * $proportion;
}

$file_type = strtolower(end(explode('.', $image_file)));

if ($file_type === "jpg" || $file_type === "jpeg") {

    $original_image = ImageCreateFromJPEG($image_file); //JPEGファイルを読み込む
    $new_image = ImageCreateTrueColor($new_width, $new_height); // 画像作成

} elseif ($file_type === "gif") {

    $original_image = ImageCreateFromGIF($image_file); //GIFファイルを読み込む
    $new_image = ImageCreateTrueColor($new_width, $new_height); // 画像作成

    /* ----- 透過問題解決 ------ */
    $alpha = imagecolortransparent($original_image);  // 元画像から透過色を取得する
    imagefill($new_image, 0, 0, $alpha);       // その色でキャンバスを塗りつぶす
    imagecolortransparent($new_image, $alpha); // 塗りつぶした色を透過色として指定する

} elseif ($file_type === "png") {

    $original_image = ImageCreateFromPNG($image_file); //PNGファイルを読み込む
    $new_image = ImageCreateTrueColor($new_width, $new_height); // 画像作成

    /* ----- 透過問題解決 ------ */
    imagealphablending($new_image, false);  // アルファブレンディングをoffにする
    imagesavealpha($new_image, true);       // 完全なアルファチャネル情報を保存するフラグをonにする

} else {
    // 何も当てはまらなかった場合の処理は書いてませんので注意！
    return;

}

// 元画像から再サンプリング
ImageCopyResampled($new_image,$original_image,0,0,0,0,$new_width,$new_height,$original_width,$original_height);

// 画像をブラウザに表示
if ($file_type === "jpg" || $file_type === "jpeg") {
    ImageJPEG($new_image);
} elseif ($file_type === "gif") {
    ImageGIF($new_image);
} elseif ($file_type === "png") {
    ImagePNG($new_image);
}

// メモリを開放する
imagedestroy($new_image);
imagedestroy($original_image);

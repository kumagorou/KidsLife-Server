<?php
require_once('config.php');
require_once('functions.php');

session_start();

if (preg_match('/^[1-9][0-9]*$/', $_GET['id'])) {
    $id = (int)$_GET['id'];
} else {
    echo "not found!";
    exit;
}
$favFlag = false;
if(isset($_COOKIE['favorites'])) {
  $favList = explode(',',$_COOKIE['favorites']);
  foreach ($favList as $favPage) {
    if ($favPage == $id) {
      $favFlag = true;
    }
  }
}
$dbh = connectDb();
$sql = "SELECT * FROM `events` WHERE `id` = :id LIMIT 1";
$stmt = $dbh->prepare($sql);
$params = array(":id" => $id);
$stmt->execute($params);
$info = $stmt->fetch() or die("not found!");
$event_name = $info['event_name'];

$keyword = 'バーベキュー';
$list = array();
// APIパラメータ
$params = array(
  'api_id' => 'qcxzfA2UW91EAeqMnGLz',
  'affiliate_id' => 'hackson-990',
  'operation' => 'ItemList',
  'version' => '2.00',
  'timestamp' => date('Y-m-d H:i:s'),
  'site' => 'DMM.com',
  'hits' => 5,
  'keyword' => mb_convert_encoding($keyword, 'EUC-JP', 'UTF-8'),
  'sort' => 'rank',
  'service' => 'nandemo'
);

$query = http_build_query($params);
$url = sprintf('http://affiliate-api.dmm.com?%s', $query);
var_dump($url);
$response = file_get_contents($url);
$data = simplexml_load_string($response);
$list = $data->result->items->item;

?>
<?php include('view/common/header.html'); ?>
<div id="main-wrapp">
  <main id="main" role="main">
    <?php include('view/event/article.html'); ?>
  </main>
</div>
<?php include('view/common/footer.html'); ?>
<script type="text/javascript">
  $(function(){
    var favoriteList = [];
    var cookieName = 'favorites';
    $('.favorite').click(function(event) {
      var id = $(this).val();
      if($.cookie(cookieName)) {
        favoriteList = $.cookie(cookieName).split(",");
        favoriteList = $.grep(favoriteList, function(e){return e !== "";});
        if($.inArray(id, favoriteList)<0){
          favoriteList.push(id);
          $(this).text('お気に入りから削除');
        } else {
          favoriteList.splice($.inArray(id, favoriteList),1);
          $(this).text('お気に入りに追加');
        }
      } else {
        favoriteList.push(id);
        $(this).text('お気に入りから削除');
      }
      $.cookie(cookieName, favoriteList);
      console.log($.cookie(cookieName));
    });

    var g = new google.maps.Geocoder(),
      map ,
      latlng;

    g.geocode({
        address: '<?php echo h($info['address']); ?>'
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            latlng = results[0].geometry.location;
            initialize();
        }
    });
    function initialize() {
        var options = {
            center: latlng,
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: true,
            disableDefaultUI: true,
            panControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER
            }
        };
        map = new google.maps.Map(document.getElementById('googlemap'), options);
        var markerOptions = {
        position: latlng,
          map: map
      };
      var marker = new google.maps.Marker(markerOptions);
    }
  });
  </script>

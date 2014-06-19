<?php
include_once "tadtools_header.php";
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/jwplayer_new.php")){
    redirect_header("index.php",3, _MD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";
include_once XOOPS_ROOT_PATH."/modules/tadtools/jwplayer_new.php";

$media=$_GET['file_name'];
$image=XOOPS_URL."/modules/tadtools/images/video.png";
$jw=new JwPlayer("video" , $media, $image, '100%', NULL, NULL, NULL,NULL,true);
//JwPlayer($id="",$file="",$image="",$width="",$height="",$skin="",$mode="",$display="",$autostart=false,$repeat=false, $other_code="")
?>
<!DOCTYPE html>
<html lang="zh-TW">
  <head>
    <meta charset="utf-8">
    <title>video</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <?php
      echo get_jquery();
      echo $jw->render();
    ?>
  </body>
</html>
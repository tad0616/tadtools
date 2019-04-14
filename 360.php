<?php
include_once 'tadtools_header.php';
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
// $sn    = system_CleanVars($_REQUEST, 'sn', '', 'int');
$photo = system_CleanVars($_REQUEST, 'photo', '', 'string');
$photo = filter_var($photo, FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A simple example</title>
    <link rel="stylesheet" href="/modules/tadtools/pannellum/pannellum.css"/>
    <script type="text/javascript" src="/modules/tadtools/pannellum/pannellum.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0px;
        }

        }font-family:

        #panorama {
          width: 100%;
          height: 100%;
        }
    </style>
</head>
<body>
<div id="panorama"></div>
<script>
pannellum.viewer('panorama', {
    "type": "equirectangular",
    "autoLoad":true,
    "panorama": "<?php echo $photo; ?>",
    "compass":true
});
</script>

</body>
</html>

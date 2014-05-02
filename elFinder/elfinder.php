<?php
include_once "../../../mainfile.php";
include_once "../jquery.php";
$jquery=get_jquery(true);
$LANGCODE=str_replace("-","_",_LANGCODE);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>elFinder 2.0</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<?php echo $jquery;?>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="<?php echo XOOPS_URL;?>/modules/tadtools/elFinder/css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo XOOPS_URL;?>/modules/tadtools/elFinder/css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script src="<?php echo XOOPS_URL;?>/modules/tadtools/elFinder/js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script src="<?php echo XOOPS_URL;?>/modules/tadtools/elFinder/js/i18n/elfinder.<?php echo $LANGCODE;?>.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Helper function to get parameters from the query string.
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
            var match = window.location.search.match(reParam) ;

            return (match && match.length > 1) ? match[1] : '' ;
        }

        $().ready(function() {
            var funcNum = getUrlParam('CKEditorFuncNum');

            var elf = $('#elfinder').elfinder({
                url : '<?php echo XOOPS_URL;?>/modules/tadtools/elFinder/php/connector.minimal.php?type=<?php echo $_GET['type'];?>',
                lang : '<?php echo $LANGCODE;?>',
                getFileCallback : function(file) {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, file);
                    window.close();
                },
                commandsOptions : {
                   getfile : { onlyURL  : true, multiple : false, folders  : false, oncomplete : 'close' }
                },
                resizable: false
            }).elfinder('instance');
        });
    </script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>

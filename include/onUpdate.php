<?php

function xoops_module_update_tadtools(&$module, $old_version) {
    GLOBAL $xoopsDB;
    
  	mk_dir(XOOPS_ROOT_PATH."/uploads/tadtools");
  	mk_dir(XOOPS_ROOT_PATH."/uploads/tadtools/file");
  	mk_dir(XOOPS_ROOT_PATH."/uploads/tadtools/image");
  	mk_dir(XOOPS_ROOT_PATH."/uploads/tadtools/image/.thumbs");

		if(!chk_chk1()) go_update1();
		if(!chk_chk2()) go_update2();
    /*

		$old_fckeditor=XOOPS_ROOT_PATH."/modules/tadtools/fckeditor";
		if(is_dir($old_fckeditor)){
			delete_directory($old_fckeditor);
		}
		*/
    return true;
}

function chk_chk1(){
	global $xoopsDB;
	$sql="select count(*) from ".$xoopsDB->prefix("tadtools_setup");
	$result=$xoopsDB->queryF($sql);
	if(empty($result)) return false;
	return true;
}


function go_update1(){
	global $xoopsDB;
	$sql="CREATE TABLE `".$xoopsDB->prefix("tadtools_setup")."` (
  `tt_sn` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tt_theme`  varchar(255) NOT NULL default '',
  `tt_use_bootstrap`  varchar(255) NOT NULL default '',
  PRIMARY KEY  (`tt_sn`),
  UNIQUE KEY `tt_theme` (`tt_theme`)
  ) ENGINE = MYISAM";
  
	$xoopsDB->queryF($sql);
}


//新增BootStrap顏色欄位
function chk_chk2(){
	global $xoopsDB;
	$sql="select count(`tt_bootstrap_color`) from ".$xoopsDB->prefix("tadtools_setup");
	$result=$xoopsDB->query($sql);
	if(empty($result)) return false;
	return true;
}

function go_update2(){
	global $xoopsDB;
	$sql="ALTER TABLE ".$xoopsDB->prefix("tadtools_setup")." ADD `tt_bootstrap_color` varchar(255) NOT NULL  default ''";
	$xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
	return true;
}

//建立目錄
function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))return;
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}

//拷貝目錄
function full_copy( $source="", $target=""){
	if ( is_dir( $source ) ){
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ){
			if ( $entry == '.' || $entry == '..' ){
				continue;
			}

			$Entry = $source . '/' . $entry;
			if ( is_dir( $Entry ) )	{
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
		$d->close();
	}else{
		copy( $source, $target );
	}
}


function rename_win($oldfile,$newfile) {
   if (!rename($oldfile,$newfile)) {
      if (copy ($oldfile,$newfile)) {
         unlink($oldfile);
         return TRUE;
      }
      return FALSE;
   }
   return TRUE;
}

function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}



//做縮圖
function thumbnail($filename="",$thumb_name="",$type="image/jpeg",$width="120"){

	ini_set('memory_limit', '50M');
	// Get new sizes
	list($old_width, $old_height) = getimagesize($filename);

	$percent=($old_width>$old_height)?round($width/$old_width,2):round($width/$old_height,2);

	$newwidth = ($old_width>$old_height)?$width:$old_width * $percent;
	$newheight = ($old_width>$old_height)?$old_height * $percent:$width;

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	if($type=="image/jpeg" or $type=="image/jpg" or $type=="image/pjpg" or $type=="image/pjpeg"){
		$source = imagecreatefromjpeg($filename);
		$type="image/jpeg";
	}elseif($type=="image/png"){
		$source = imagecreatefrompng($filename);
		$type="image/png";
	}elseif($type=="image/gif"){
		$source = imagecreatefromgif($filename);
		$type="image/gif";
	}

	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);

  header("Content-type: image/png");
	imagepng($thumb,$thumb_name);

	return;
	exit;
}
?>

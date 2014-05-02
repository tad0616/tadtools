<?php
include_once "tadtools_header.php";

class syntaxhighlighter{

	//建構函數
	function syntaxhighlighter(){

	}

	//產生語法
	function render(){
		$syntaxhighlighter="<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shCore.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushCss.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushJScript.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushPhp.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushPlain.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushJava.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushSql.js'></script>
  	<script type='text/javascript' src='".TADTOOLS_URL."/syntaxhighlighter/scripts/shBrushXml.js'></script>
  	<link type='text/css' rel='stylesheet' href='".TADTOOLS_URL."/syntaxhighlighter/styles/shCore.css'/>
  	<link type='text/css' rel='stylesheet' href='".TADTOOLS_URL."/syntaxhighlighter/styles/shThemeDefault.css'/>
  	<script type='text/javascript'>
  		SyntaxHighlighter.config.clipboardSwf = '".TADTOOLS_URL."/syntaxhighlighter/scripts/clipboard.swf';
  		SyntaxHighlighter.all();
  	</script>";
    return $syntaxhighlighter;
  }
}
?>

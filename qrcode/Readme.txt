***********************************************************************
Readme for "PHP QR Code Class"
***********************************************************************
Licensed under GPLv3, full text at http://www.gnu.org/licenses/gpl-3.0.txt
Files:
	qrcode.php --- Main Class File with Comments
	console.php --- Sample console-output shell
Requirements:
	PHP 5.0+
Optional:
	GD for image output
	ICONV for Shift_JIS and JIS8 conversion
Purpose:
	A native-PHP class for producing QR Codes, fully-implemented 
	(except for structured append). Only 20KiB when minified.
Usage:
	$a = new QR(sample text,[ecc level]);
	//Image Output
	either header('Content-Type: image/gif');echo $a->image([magnification]);
	or file_put_contents([filename],$a->image([magnification]);
	//Text Output
	either echo $a->text(true);//Console (white on black)
	or echo $a->text(false);//Document (black on white)
Notes:
	Text-detecting proceeds according to the specification, either all-
	numeric, alphanumeric ([A-Z0-9 $%*+-./:]), byte-mode, or two-byte
	Kanji. Byte-mode text should be encoded as JIS8 (notably forward-
	slash will appear as the Yen symbol). Kanji text must be encoded as
	Shift_JIS (and will be validated).
Speed & Size:
	Several speed (and size) improvements are possible, including:
	* Remove text-detection code and other formats in prepare()
	* Remove unused masks and scoring code in mask()
	* Remove either image() or text()
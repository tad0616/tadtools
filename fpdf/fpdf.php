<?php
/*******************************************************************************
* Software: FPDF                                                               *
* Version:  1.53                                                               *
* Date:     2004-12-31                                                         *
* Author:   Olivier PLATHEY                                                    *
* License:  Freeware                                                           *
*                                                                              *
* You may use, modify and redistribute this software as you wish.              *
*******************************************************************************/

if (!class_exists('FPDF')) {
    define('FPDF_VERSION', '1.53');
    define('K_CELL_HEIGHT_RATIO', '1.2');
    define('K_SMALL_RATIO', 2 / 3);
    define('K_PATH_URL', 'http://test.suntravel.com.tw/fpdf/');
    define('K_PATH_URL_CACHE', K_PATH_URL . 'cache/');
    define('K_PATH_MAIN', '/web/www/fpdf/');
    define('K_PATH_CACHE', K_PATH_MAIN . 'cache/');
    define('K_PATH_IMAGES', K_PATH_MAIN . 'images/');
    define('K_BLANK_IMAGE', K_PATH_IMAGES . '_blank.png');

    class fpdf
    {
        //Private properties
public $page;               //current page number
public $n;                  //current object number
public $offsets;            //array of object offsets
public $buffer;             //buffer holding in-memory PDF
public $pages;              //array containing pages
public $state;              //current document state
public $compress;           //compression flag
public $DefOrientation;     //default orientation
public $CurOrientation;     //current orientation
public $OrientationChanges; //array indicating orientation changes
public $k;                  //scale factor (number of points in user unit)
public $fwPt;
        public $fhPt;         //dimensions of page format in points
        public $fw;
        public $fh;             //dimensions of page format in user unit
        public $wPt;
        public $hPt;           //current dimensions of page in points
        public $w;
        public $h;               //current dimensions of page in user unit
public $lMargin;            //left margin
public $tMargin;            //top margin
public $rMargin;            //right margin
public $bMargin;            //page break margin
public $cMargin;            //cell margin
public $x;
        public $y;               //current position in user unit for cell positioning
public $lasth;              //height of last cell printed
public $LineWidth;          //line width in user unit
public $CoreFonts;          //array of standard font names
public $fonts;              //array of used fonts
public $FontFiles;          //array of font files
public $diffs;              //array of encoding differences
public $images;             //array of used images
public $PageLinks;          //array of links in pages
public $links;              //array of internal links
public $FontFamily;         //current font family
public $FontStyle;          //current font style
public $underline;          //underlining flag
public $CurrentFont;        //current font info
public $FontSizePt;         //current font size in points
public $FontSize;           //current font size in user unit
public $DrawColor;          //commands for drawing color
public $FillColor;          //commands for filling color
public $TextColor;          //commands for text color
public $ColorFlag;          //indicates whether fill and text colors are different
public $ws;                 //word spacing
public $AutoPageBreak;      //automatic page breaking
public $PageBreakTrigger;   //threshold used to trigger page breaks
public $InFooter;           //flag set when processing footer
public $ZoomMode;           //zoom display mode
public $LayoutMode;         //layout display mode
public $title;              //title
public $subject;            //subject
public $author;             //author
public $keywords;           //keywords
public $creator;            //creator
public $AliasNbPages;       //alias for total number of pages
public $PDFVersion;         //PDF version number

/*******************************************************************************
*
*							Creak From TCPDF
*
*******************************************************************************/
        /**
         * @var Minimum distance between header and top page margin.
         * @access private
         */
        public $header_margin;

        /**
         * @var Minimum distance between footer and bottom page margin.
         * @access var
         */
        public $footer_margin;

        /**
         * @var original left margin value
         * @access var
         * @since 1.53.0.TC013
         */
        public $original_lMargin;

        /**
         * @var original right margin value
         * @access var
         * @since 1.53.0.TC013
         */
        public $original_rMargin;

        /**
         * @var Header font.
         * @access var
         */
        public $header_font = [];

        /**
         * @var Footer font.
         * @access var
         */
        public $footer_font = [];

        /**
         * @var If true prints header
         * @access var
         */
        public $print_header = false;

        /**
         * @var If true prints footer.
         * @access var
         */
        public $print_footer = false;

        /**
         * @var Header width (0 = full page width).
         * @access var
         */
        public $header_width = 0;

        /**
         * @var Header image logo.
         * @access var
         */
        public $header_logo = '';

        /**
         * @var Header image logo width in mm.
         * @access var
         */
        public $header_logo_width = 30;

        /**
         * @var string to print as title on document header.
         * @access var
         */
        public $header_title = '';

        /**
         * @var string to print on document header.
         * @access var
         */
        public $header_string = '';

        /**
         * @var Default number of columns for html table.
         * @access private
         */
        public $default_table_columns = 4;

        // variables for html parser

        /**
         * @var HTML PARSER: store current link.
         * @access private
         */
        public $HREF;

        /**
         * @var HTML PARSER: store font list.
         * @access private
         */
        public $fontList;

        /**
         * @var HTML PARSER: true when font attribute is set.
         * @access private
         */
        public $issetfont;

        /**
         * @var HTML PARSER: true when color attribute is set.
         * @access private
         */
        public $issetcolor;

        /**
         * @var HTML PARSER: true in case of ordered list (OL), false otherwise.
         * @access private
         */
        public $listordered = false;

        /**
         * @var HTML PARSER: count list items.
         * @access private
         */
        public $listcount = 0;

        /**
         * @var HTML PARSER: size of table border.
         * @access private
         */
        public $tableborder = 0;

        /**
         * @var HTML PARSER: true at the beginning of table.
         * @access private
         */
        public $tdbegin = false;

        /**
         * @var HTML PARSER: table width.
         * @access private
         */
        public $tdwidth = 0;

        /**
         * @var HTML PARSER: table height.
         * @access private
         */
        public $tdheight = 0;

        /**
         * @var HTML PARSER: table align.
         * @access private
         */
        public $tdalign = 'L';

        /**
         * @var HTML PARSER: table background color.
         * @access private
         */
        public $tdbgcolor = false;
        /**
         * @var Store temporary font size in points.
         * @access private
         */
        public $tempfontsize = 10;

        /**
         * @var Bold font style status.
         * @access var
         */
        public $b;

        /**
         * @var Underlined font style status.
         * @access var
         */
        public $u;

        /**
         * @var Italic font style status.
         * @access var
         */
        public $i;

        /**
         * @var spacer for LI tags.
         * @access var
         */
        public $lispacer = '';

        /**
         * @var default encoding
         * @access var
         * @since 1.53.0.TC010
         */
        public $encoding = 'UTF-8';

        /**
         * @var PHP internal encoding
         * @access var
         * @since 1.53.0.TC016
         */
        public $internal_encoding;

        /**
         * @var store previous fill color as RGB array
         * @access var
         * @since 1.53.0.TC017
         */
        public $prevFillColor = [255, 255, 255];

        /**
         * @var store previous text color as RGB array
         * @access var
         * @since 1.53.0.TC017
         */
        public $prevTextColor = [0, 0, 0];

        /**
         * @var store previous font family
         * @access var
         * @since 1.53.0.TC017
         */
        public $prevFontFamily;

        /**
         * @var store previous font style
         * @access var
         * @since 1.53.0.TC017
         */
        public $prevFontStyle;

        /**
         * @var indicates if the document language is Right-To-Left
         * @access var
         * @since 2.0.000
         */
        public $rtl = false;

        /**
         * @var used to force RTL or LTR string inversion
         * @access var
         * @since 2.0.000
         */
        public $tmprtl = false;

        /*******************************************************************************
        *                                                                              *
        *                               Public methods                                 *
        *                                                                              *
        *******************************************************************************/
        public function FPDF($orientation = 'P', $unit = 'mm', $format = 'A4')
        {
            //Some checks
            $this->_dochecks();
            //Initialization of properties
            $this->page = 0;
            $this->n = 2;
            $this->buffer = '';
            $this->pages = [];
            $this->OrientationChanges = [];
            $this->state = 0;
            $this->fonts = [];
            $this->FontFiles = [];
            $this->diffs = [];
            $this->images = [];
            $this->links = [];
            $this->InFooter = false;
            $this->lasth = 0;
            $this->FontFamily = '';
            $this->FontStyle = '';
            $this->FontSizePt = 12;
            $this->underline = false;
            $this->DrawColor = '0 G';
            $this->FillColor = '0 g';
            $this->TextColor = '0 g';
            $this->ColorFlag = false;
            $this->ws = 0;
            //Standard fonts
            $this->CoreFonts = ['courier' => 'Courier', 'courierB' => 'Courier-Bold', 'courierI' => 'Courier-Oblique', 'courierBI' => 'Courier-BoldOblique',
        'helvetica' => 'Helvetica', 'helveticaB' => 'Helvetica-Bold', 'helveticaI' => 'Helvetica-Oblique', 'helveticaBI' => 'Helvetica-BoldOblique',
        'times' => 'Times-Roman', 'timesB' => 'Times-Bold', 'timesI' => 'Times-Italic', 'timesBI' => 'Times-BoldItalic',
        'symbol' => 'Symbol', 'zapfdingbats' => 'ZapfDingbats', ];
            //Scale factor
            if ('pt' == $unit) {
                $this->k = 1;
            } elseif ('mm' == $unit) {
                $this->k = 72 / 25.4;
            } elseif ('cm' == $unit) {
                $this->k = 72 / 2.54;
            } elseif ('in' == $unit) {
                $this->k = 72;
            } else {
                $this->Error('Incorrect unit: ' . $unit);
            }
            //Page format
            if (is_string($format)) {
                $format = mb_strtolower($format);
                if ('a3' == $format) {
                    $format = [841.89, 1190.55];
                } elseif ('a4' == $format) {
                    $format = [595.28, 841.89];
                } elseif ('a5' == $format) {
                    $format = [420.94, 595.28];
                } elseif ('letter' == $format) {
                    $format = [612, 792];
                } elseif ('legal' == $format) {
                    $format = [612, 1008];
                } else {
                    $this->Error('Unknown page format: ' . $format);
                }
                $this->fwPt = $format[0];
                $this->fhPt = $format[1];
            } else {
                $this->fwPt = $format[0] * $this->k;
                $this->fhPt = $format[1] * $this->k;
            }
            $this->fw = $this->fwPt / $this->k;
            $this->fh = $this->fhPt / $this->k;
            //Page orientation
            $orientation = mb_strtolower($orientation);
            if ('p' == $orientation || 'portrait' == $orientation) {
                $this->DefOrientation = 'P';
                $this->wPt = $this->fwPt;
                $this->hPt = $this->fhPt;
            } elseif ('l' == $orientation || 'landscape' == $orientation) {
                $this->DefOrientation = 'L';
                $this->wPt = $this->fhPt;
                $this->hPt = $this->fwPt;
            } else {
                $this->Error('Incorrect orientation: ' . $orientation);
            }
            $this->CurOrientation = $this->DefOrientation;
            $this->w = $this->wPt / $this->k;
            $this->h = $this->hPt / $this->k;
            //Page margins (1 cm)
            $margin = 28.35 / $this->k;
            $this->SetMargins($margin, $margin);
            //Interior cell margin (1 mm)
            $this->cMargin = $margin / 10;
            //Line width (0.2 mm)
            $this->LineWidth = .567 / $this->k;
            //Automatic page break
            $this->SetAutoPageBreak(true, 2 * $margin);
            //Full width display mode
            $this->SetDisplayMode('fullwidth');
            //Enable compression
            $this->SetCompression(true);
            //Set default PDF version number
            $this->PDFVersion = '1.3';
        }

        public function SetMargins($left, $top, $right = -1)
        {
            //Set left, top and right margins
            $this->lMargin = $left;
            $this->tMargin = $top;
            if (-1 == $right) {
                $right = $left;
            }
            $this->rMargin = $right;
        }

        public function SetLeftMargin($margin)
        {
            //Set left margin
            $this->lMargin = $margin;
            if ($this->page > 0 && $this->x < $margin) {
                $this->x = $margin;
            }
        }

        public function SetTopMargin($margin)
        {
            //Set top margin
            $this->tMargin = $margin;
        }

        public function SetRightMargin($margin)
        {
            //Set right margin
            $this->rMargin = $margin;
        }

        public function SetAutoPageBreak($auto, $margin = 0)
        {
            //Set auto page break mode and triggering margin
            $this->AutoPageBreak = $auto;
            $this->bMargin = $margin;
            $this->PageBreakTrigger = $this->h - $margin;
        }

        public function SetDisplayMode($zoom, $layout = 'continuous')
        {
            //Set display mode in viewer
            if ('fullpage' == $zoom || 'fullwidth' == $zoom || 'real' == $zoom || 'default' == $zoom || !is_string($zoom)) {
                $this->ZoomMode = $zoom;
            } else {
                $this->Error('Incorrect zoom display mode: ' . $zoom);
            }
            if ('single' == $layout || 'continuous' == $layout || 'two' == $layout || 'default' == $layout) {
                $this->LayoutMode = $layout;
            } else {
                $this->Error('Incorrect layout display mode: ' . $layout);
            }
        }

        public function SetCompression($compress)
        {
            //Set page compression
            if (function_exists('gzcompress')) {
                $this->compress = $compress;
            } else {
                $this->compress = false;
            }
        }

        public function SetTitle($title)
        {
            //Title of document
            $this->title = $title;
        }

        public function SetSubject($subject)
        {
            //Subject of document
            $this->subject = $subject;
        }

        public function SetAuthor($author)
        {
            //Author of document
            $this->author = $author;
        }

        public function SetKeywords($keywords)
        {
            //Keywords of document
            $this->keywords = $keywords;
        }

        public function SetCreator($creator)
        {
            //Creator of document
            $this->creator = $creator;
        }

        public function AliasNbPages($alias = '{nb}')
        {
            //Define an alias for total number of pages
            $this->AliasNbPages = $alias;
        }

        public function Error($msg)
        {
            //Fatal error
            die('<B>FPDF error: </B>' . $msg);
        }

        public function Open()
        {
            //Begin document
            $this->state = 1;
        }

        public function Close()
        {
            //Terminate document
            if (3 == $this->state) {
                return;
            }
            if (0 == $this->page) {
                $this->AddPage();
            }
            //Page footer
            $this->InFooter = true;
            $this->Footer();
            $this->InFooter = false;
            //Close page
            $this->_endpage();
            //Close document
            $this->_enddoc();
        }

        public function AddPage($orientation = '')
        {
            //Start a new page
            if (0 == $this->state) {
                $this->Open();
            }
            $family = $this->FontFamily;
            $style = $this->FontStyle . ($this->underline ? 'U' : '');
            $size = $this->FontSizePt;
            $lw = $this->LineWidth;
            $dc = $this->DrawColor;
            $fc = $this->FillColor;
            $tc = $this->TextColor;
            $cf = $this->ColorFlag;
            if ($this->page > 0) {
                //Page footer
                $this->InFooter = true;
                $this->Footer();
                $this->InFooter = false;
                //Close page
                $this->_endpage();
            }
            //Start new page
            $this->_beginpage($orientation);
            //Set line cap style to square
            $this->_out('2 J');
            //Set line width
            $this->LineWidth = $lw;
            $this->_out(sprintf('%.2f w', $lw * $this->k));
            //Set font
            if ($family) {
                $this->SetFont($family, $style, $size);
            }
            //Set colors
            $this->DrawColor = $dc;
            if ('0 G' != $dc) {
                $this->_out($dc);
            }
            $this->FillColor = $fc;
            if ('0 g' != $fc) {
                $this->_out($fc);
            }
            $this->TextColor = $tc;
            $this->ColorFlag = $cf;
            //Page header
            $this->Header();
            //Restore line width
            if ($this->LineWidth != $lw) {
                $this->LineWidth = $lw;
                $this->_out(sprintf('%.2f w', $lw * $this->k));
            }
            //Restore font
            if ($family) {
                $this->SetFont($family, $style, $size);
            }
            //Restore colors
            if ($this->DrawColor != $dc) {
                $this->DrawColor = $dc;
                $this->_out($dc);
            }
            if ($this->FillColor != $fc) {
                $this->FillColor = $fc;
                $this->_out($fc);
            }
            $this->TextColor = $tc;
            $this->ColorFlag = $cf;
        }

        public function PageNo()
        {
            //Get current page number
            return $this->page;
        }

        public function SetDrawColor($r, $g = -1, $b = -1)
        {
            //Set color for all stroking operations
            if ((0 == $r && 0 == $g && 0 == $b) || -1 == $g) {
                $this->DrawColor = sprintf('%.3f G', $r / 255);
            } else {
                $this->DrawColor = sprintf('%.3f %.3f %.3f RG', $r / 255, $g / 255, $b / 255);
            }
            if ($this->page > 0) {
                $this->_out($this->DrawColor);
            }
        }

        public function SetFillColor($r, $g = -1, $b = -1)
        {
            //Set color for all filling operations
            if ((0 == $r && 0 == $g && 0 == $b) || -1 == $g) {
                $this->FillColor = sprintf('%.3f g', $r / 255);
            } else {
                $this->FillColor = sprintf('%.3f %.3f %.3f rg', $r / 255, $g / 255, $b / 255);
            }
            $this->ColorFlag = ($this->FillColor != $this->TextColor);
            if ($this->page > 0) {
                $this->_out($this->FillColor);
            }
        }

        public function SetTextColor($r, $g = -1, $b = -1)
        {
            //Set color for text
            if ((0 == $r && 0 == $g && 0 == $b) || -1 == $g) {
                $this->TextColor = sprintf('%.3f g', $r / 255);
            } else {
                $this->TextColor = sprintf('%.3f %.3f %.3f rg', $r / 255, $g / 255, $b / 255);
            }
            $this->ColorFlag = ($this->FillColor != $this->TextColor);
        }

        public function GetStringWidth($s)
        {
            //Get width of a string in the current font
            $s = (string)$s;
            $cw = &$this->CurrentFont['cw'];
            $w = 0;
            $l = mb_strlen($s);
            for ($i = 0; $i < $l; $i++) {
                $w += $cw[$s[$i]];
            }

            return $w * $this->FontSize / 1000;
        }

        public function SetLineWidth($width)
        {
            //Set line width
            $this->LineWidth = $width;
            if ($this->page > 0) {
                $this->_out(sprintf('%.2f w', $width * $this->k));
            }
        }

        public function Line($x1, $y1, $x2, $y2)
        {
            //Draw a line
            $this->_out(sprintf('%.2f %.2f m %.2f %.2f l S', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k));
        }

        public function Rect($x, $y, $w, $h, $style = '')
        {
            //Draw a rectangle
            if ('F' == $style) {
                $op = 'f';
            } elseif ('FD' == $style || 'DF' == $style) {
                $op = 'B';
            } else {
                $op = 'S';
            }
            $this->_out(sprintf('%.2f %.2f %.2f %.2f re %s', $x * $this->k, ($this->h - $y) * $this->k, $w * $this->k, -$h * $this->k, $op));
        }

        public function AddFont($family, $style = '', $file = '')
        {
            //Add a TrueType or Type1 font
            $family = mb_strtolower($family);
            if ('' == $file) {
                $file = str_replace(' ', '', $family) . mb_strtolower($style) . '.php';
            }
            if ('arial' == $family) {
                $family = 'helvetica';
            }
            $style = mb_strtoupper($style);
            if ('IB' == $style) {
                $style = 'BI';
            }
            $fontkey = $family . $style;
            if (isset($this->fonts[$fontkey])) {
                $this->Error('Font already added: ' . $family . ' ' . $style);
            }
            include($this->_getfontpath() . $file);
            if (!isset($name)) {
                $this->Error('Could not include font definition file');
            }
            $i = count($this->fonts) + 1;
            $this->fonts[$fontkey] = ['i' => $i, 'type' => $type, 'name' => $name, 'desc' => $desc, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'enc' => $enc, 'file' => $file];
            if ($diff) {
                //Search existing encodings
                $d = 0;
                $nb = count($this->diffs);
                for ($i = 1; $i <= $nb; $i++) {
                    if ($this->diffs[$i] == $diff) {
                        $d = $i;
                        break;
                    }
                }
                if (0 == $d) {
                    $d = $nb + 1;
                    $this->diffs[$d] = $diff;
                }
                $this->fonts[$fontkey]['diff'] = $d;
            }
            if ($file) {
                if ('TrueType' == $type) {
                    $this->FontFiles[$file] = ['length1' => $originalsize];
                } else {
                    $this->FontFiles[$file] = ['length1' => $size1, 'length2' => $size2];
                }
            }
        }

        public function SetFont($family, $style = '', $size = 0)
        {
            //Select a font; size given in points
            global $fpdf_charwidths;

            $family = mb_strtolower($family);
            if ('' == $family) {
                $family = $this->FontFamily;
            }
            if ('arial' == $family) {
                $family = 'helvetica';
            } elseif ('symbol' == $family || 'zapfdingbats' == $family) {
                $style = '';
            }
            $style = mb_strtoupper($style);
            if (false !== mb_strpos($style, 'U')) {
                $this->underline = true;
                $style = str_replace('U', '', $style);
            } else {
                $this->underline = false;
            }
            if ('IB' == $style) {
                $style = 'BI';
            }
            if (0 == $size) {
                $size = $this->FontSizePt;
            }
            //Test if font is already selected
            if ($this->FontFamily == $family && $this->FontStyle == $style && $this->FontSizePt == $size) {
                return;
            }
            //Test if used for the first time
            $fontkey = $family . $style;
            if (!isset($this->fonts[$fontkey])) {
                //Check if one of the standard fonts
                if (isset($this->CoreFonts[$fontkey])) {
                    if (!isset($fpdf_charwidths[$fontkey])) {
                        //Load metric file
                        $file = $family;
                        if ('times' == $family || 'helvetica' == $family) {
                            $file .= mb_strtolower($style);
                        }
                        include($this->_getfontpath() . $file . '.php');
                        if (!isset($fpdf_charwidths[$fontkey])) {
                            $this->Error('Could not include font metric file');
                        }
                    }
                    $i = count($this->fonts) + 1;
                    $this->fonts[$fontkey] = ['i' => $i, 'type' => 'core', 'name' => $this->CoreFonts[$fontkey], 'up' => -100, 'ut' => 50, 'cw' => $fpdf_charwidths[$fontkey]];
                } else {
                    $this->Error('Undefined font: ' . $family . ' ' . $style);
                }
            }
            //Select it
            $this->FontFamily = $family;
            $this->FontStyle = $style;
            $this->FontSizePt = $size;
            $this->FontSize = $size / $this->k;
            $this->CurrentFont = &$this->fonts[$fontkey];
            if ($this->page > 0) {
                $this->_out(sprintf('BT /F%d %.2f Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
            }
        }

        public function SetFontSize($size)
        {
            //Set font size in points
            if ($this->FontSizePt == $size) {
                return;
            }
            $this->FontSizePt = $size;
            $this->FontSize = $size / $this->k;
            if ($this->page > 0) {
                $this->_out(sprintf('BT /F%d %.2f Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
            }
        }

        public function AddLink()
        {
            //Create a new internal link
            $n = count($this->links) + 1;
            $this->links[$n] = [0, 0];

            return $n;
        }

        public function SetLink($link, $y = 0, $page = -1)
        {
            //Set destination of internal link
            if (-1 == $y) {
                $y = $this->y;
            }
            if (-1 == $page) {
                $page = $this->page;
            }
            $this->links[$link] = [$page, $y];
        }

        public function Link($x, $y, $w, $h, $link)
        {
            //Put a link on the page
            $this->PageLinks[$this->page][] = [$x * $this->k, $this->hPt - $y * $this->k, $w * $this->k, $h * $this->k, $link];
        }

        public function Text($x, $y, $txt)
        {
            //Output a string
            $s = sprintf('BT %.2f %.2f Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
            if ($this->underline && '' != $txt) {
                $s .= ' ' . $this->_dounderline($x, $y, $txt);
            }
            if ($this->ColorFlag) {
                $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
            }
            $this->_out($s);
        }

        public function AcceptPageBreak()
        {
            //Accept automatic page break or not
            return $this->AutoPageBreak;
        }

        public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '')
        {
            //Output a cell
            $k = $this->k;
            if ($this->y + $h > $this->PageBreakTrigger && !$this->InFooter && $this->AcceptPageBreak()) {
                //Automatic page break
                $x = $this->x;
                $ws = $this->ws;
                if ($ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->AddPage($this->CurOrientation);
                $this->x = $x;
                if ($ws > 0) {
                    $this->ws = $ws;
                    $this->_out(sprintf('%.3f Tw', $ws * $k));
                }
            }
            if (0 == $w) {
                $w = $this->w - $this->rMargin - $this->x;
            }
            $s = '';
            if (1 == $fill || 1 == $border) {
                if (1 == $fill) {
                    $op = (1 == $border) ? 'B' : 'f';
                } else {
                    $op = 'S';
                }
                $s = sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
            }
            if (is_string($border)) {
                $x = $this->x;
                $y = $this->y;
                if (false !== mb_strpos($border, 'L')) {
                    $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
                }
                if (false !== mb_strpos($border, 'T')) {
                    $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
                }
                if (false !== mb_strpos($border, 'R')) {
                    $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
                }
                if (false !== mb_strpos($border, 'B')) {
                    $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
                }
            }
            if ('' !== $txt) {
                if ('R' == $align) {
                    $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
                } elseif ('C' == $align) {
                    $dx = ($w - $this->GetStringWidth($txt)) / 2;
                } else {
                    $dx = $this->cMargin;
                }
                if ($this->ColorFlag) {
                    $s .= 'q ' . $this->TextColor . ' ';
                }
                $txt2 = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                $s .= sprintf('BT %.2f %.2f Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt2);
                if ($this->underline) {
                    $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                }
                if ($this->ColorFlag) {
                    $s .= ' Q';
                }
                if ($link) {
                    $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $this->GetStringWidth($txt), $this->FontSize, $link);
                }
            }
            if ($s) {
                $this->_out($s);
            }
            $this->lasth = $h;
            if ($ln > 0) {
                //Go to next line
                $this->y += $h;
                if (1 == $ln) {
                    $this->x = $this->lMargin;
                }
            } else {
                $this->x += $w;
            }
        }

        public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = 0)
        {
            //Output text with automatic or explicit line breaks
            $cw = &$this->CurrentFont['cw'];
            if (0 == $w) {
                $w = $this->w - $this->rMargin - $this->x;
            }
            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
            $s = str_replace("\r", '', $txt);
            $nb = mb_strlen($s);
            if ($nb > 0 && "\n" == $s[$nb - 1]) {
                $nb--;
            }
            $b = 0;
            if ($border) {
                if (1 == $border) {
                    $border = 'LTRB';
                    $b = 'LRT';
                    $b2 = 'LR';
                } else {
                    $b2 = '';
                    if (false !== mb_strpos($border, 'L')) {
                        $b2 .= 'L';
                    }
                    if (false !== mb_strpos($border, 'R')) {
                        $b2 .= 'R';
                    }
                    $b = (false !== mb_strpos($border, 'T')) ? $b2 . 'T' : $b2;
                }
            }
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $ns = 0;
            $nl = 1;
            while ($i < $nb) {
                //Get next character
                $c = $s[$i];
                if ("\n" == $c) {
                    //Explicit line break
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w, $h, mb_substr($s, $j, $i - $j), $b, 2, $align, $fill);
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $ns = 0;
                    $nl++;
                    if ($border && 2 == $nl) {
                        $b = $b2;
                    }
                    continue;
                }
                if (' ' == $c) {
                    $sep = $i;
                    $ls = $l;
                    $ns++;
                }
                $l += $cw[$c];
                if ($l > $wmax) {
                    //Automatic line break
                    if (-1 == $sep) {
                        if ($i == $j) {
                            $i++;
                        }
                        if ($this->ws > 0) {
                            $this->ws = 0;
                            $this->_out('0 Tw');
                        }
                        $this->Cell($w, $h, mb_substr($s, $j, $i - $j), $b, 2, $align, $fill);
                    } else {
                        if ('J' == $align) {
                            $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                            $this->_out(sprintf('%.3f Tw', $this->ws * $this->k));
                        }
                        $this->Cell($w, $h, mb_substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                        $i = $sep + 1;
                    }
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $ns = 0;
                    $nl++;
                    if ($border && 2 == $nl) {
                        $b = $b2;
                    }
                } else {
                    $i++;
                }
            }
            //Last chunk
            if ($this->ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            if ($border && false !== mb_strpos($border, 'B')) {
                $b .= 'B';
            }
            $this->Cell($w, $h, mb_substr($s, $j, $i - $j), $b, 2, $align, $fill);
            $this->x = $this->lMargin;
        }

        public function Write($h, $txt, $link = '')
        {
            //Output text in flowing mode
            $cw = &$this->CurrentFont['cw'];
            $w = $this->w - $this->rMargin - $this->x;
            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
            $s = str_replace("\r", '', $txt);
            $nb = mb_strlen($s);
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
            while ($i < $nb) {
                //Get next character
                $c = $s[$i];
                if ("\n" == $c) {
                    //Explicit line break
                    $this->Cell($w, $h, mb_substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    if (1 == $nl) {
                        $this->x = $this->lMargin;
                        $w = $this->w - $this->rMargin - $this->x;
                        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                    }
                    $nl++;
                    continue;
                }
                if (' ' == $c) {
                    $sep = $i;
                }
                $l += $cw[$c];
                if ($l > $wmax) {
                    //Automatic line break
                    if (-1 == $sep) {
                        if ($this->x > $this->lMargin) {
                            //Move to next line
                            $this->x = $this->lMargin;
                            $this->y += $h;
                            $w = $this->w - $this->rMargin - $this->x;
                            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                            $i++;
                            $nl++;
                            continue;
                        }
                        if ($i == $j) {
                            $i++;
                        }
                        $this->Cell($w, $h, mb_substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                    } else {
                        $this->Cell($w, $h, mb_substr($s, $j, $sep - $j), 0, 2, '', 0, $link);
                        $i = $sep + 1;
                    }
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    if (1 == $nl) {
                        $this->x = $this->lMargin;
                        $w = $this->w - $this->rMargin - $this->x;
                        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                    }
                    $nl++;
                } else {
                    $i++;
                }
            }
            //Last chunk
            if ($i != $j) {
                $this->Cell($l / 1000 * $this->FontSize, $h, mb_substr($s, $j), 0, 0, '', 0, $link);
            }
        }

        public function Image($file, $x, $y, $w = 0, $h = 0, $type = '', $link = '')
        {
            //Put an image on the page
            if (!isset($this->images[$file])) {
                //First use of image, get info
                if ('' == $type) {
                    $pos = mb_strrpos($file, '.');
                    if (!$pos) {
                        $this->Error('Image file has no extension and no type was specified: ' . $file);
                    }
                    $type = mb_substr($file, $pos + 1);
                }
                $type = mb_strtolower($type);
                $mqr = get_magic_quotes_runtime();
                set_magic_quotes_runtime(0);
                if ('jpg' == $type || 'jpeg' == $type) {
                    $info = $this->_parsejpg($file);
                } elseif ('png' == $type) {
                    $info = $this->_parsepng($file);
                } else {
                    //Allow for additional formats
                    $mtd = '_parse' . $type;
                    if (!method_exists($this, $mtd)) {
                        $this->Error('Unsupported image type: ' . $type);
                    }
                    $info = $this->$mtd($file);
                }
                set_magic_quotes_runtime($mqr);
                $info['i'] = count($this->images) + 1;
                $this->images[$file] = $info;
            } else {
                $info = $this->images[$file];
            }
            //Automatic width and height calculation if needed
            if (0 == $w && 0 == $h) {
                //Put image at 72 dpi
                $w = $info['w'] / $this->k;
                $h = $info['h'] / $this->k;
            }
            if (0 == $w) {
                $w = $h * $info['w'] / $info['h'];
            }
            if (0 == $h) {
                $h = $w * $info['h'] / $info['w'];
            }
            $this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q', $w * $this->k, $h * $this->k, $x * $this->k, ($this->h - ($y + $h)) * $this->k, $info['i']));
            if ($link) {
                $this->Link($x, $y, $w, $h, $link);
            }
        }

        public function Ln($h = '')
        {
            //Line feed; default value is last cell height
            $this->x = $this->lMargin;
            if (is_string($h)) {
                $this->y += $this->lasth;
            } else {
                $this->y += $h;
            }
        }

        public function GetX()
        {
            //Get x position
            return $this->x;
        }

        public function SetX($x)
        {
            //Set x position
            if ($x >= 0) {
                $this->x = $x;
            } else {
                $this->x = $this->w + $x;
            }
        }

        public function GetY()
        {
            //Get y position
            return $this->y;
        }

        public function SetY($y)
        {
            //Set y position and reset x
            $this->x = $this->lMargin;
            if ($y >= 0) {
                $this->y = $y;
            } else {
                $this->y = $this->h + $y;
            }
        }

        public function SetXY($x, $y)
        {
            //Set x and y positions
            $this->SetY($y);
            $this->SetX($x);
        }

        public function Output($name = '', $dest = '')
        {
            //Output PDF to some destination
            //Finish document if necessary
            if ($this->state < 3) {
                $this->Close();
            }
            //Normalize parameters
            if (is_bool($dest)) {
                $dest = $dest ? 'D' : 'F';
            }
            $dest = mb_strtoupper($dest);
            if ('' == $dest) {
                if ('' == $name) {
                    $name = 'doc.pdf';
                    $dest = 'I';
                } else {
                    $dest = 'F';
                }
            }
            switch ($dest) {
        case 'I':
            //Send to standard output
            if (ob_get_contents()) {
                $this->Error('Some data has already been output, can\'t send PDF file');
            }
            if ('cli' != php_sapi_name()) {
                //We send to a browser
                header('Content-Type: application/pdf');
                if (headers_sent()) {
                    $this->Error('Some data has already been output to browser, can\'t send PDF file');
                }
                header('Content-Length: ' . mb_strlen($this->buffer));
                header('Content-disposition: inline; filename="' . $name . '"');
            }
            echo $this->buffer;
            break;
        case 'D':
            //Download file
            if (ob_get_contents()) {
                $this->Error('Some data has already been output, can\'t send PDF file');
            }
            if (isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                header('Content-Type: application/force-download');
            } else {
                header('Content-Type: application/octet-stream');
            }
            if (headers_sent()) {
                $this->Error('Some data has already been output to browser, can\'t send PDF file');
            }
            header('Content-Length: ' . mb_strlen($this->buffer));
            header('Content-disposition: attachment; filename="' . $name . '"');
            echo $this->buffer;
            break;
        case 'F':
            //Save to local file
            $f = fopen($name, 'wb');
            if (!$f) {
                $this->Error('Unable to create output file: ' . $name);
            }
            fwrite($f, $this->buffer, mb_strlen($this->buffer));
            fclose($f);
            break;
        case 'S':
            //Return as a string
            return $this->buffer;
        default:
            $this->Error('Incorrect output destination: ' . $dest);
    }

            return '';
        }

        /*******************************************************************************
        *                                                                              *
        *                              Protected methods                               *
        *                                                                              *
        *******************************************************************************/
        public function _dochecks()
        {
            //Check for locale-related bug
            if (1.1 == 1) {
                $this->Error('Don\'t alter the locale before including class file');
            }
            //Check for decimal separator
            if ('1.0' != sprintf('%.1f', 1.0)) {
                setlocale(LC_NUMERIC, 'C');
            }
        }

        public function _getfontpath()
        {
            if (!defined('FPDF_FONTPATH') && is_dir(__DIR__ . '/font')) {
                define('FPDF_FONTPATH', __DIR__ . '/font/');
            }

            return defined('FPDF_FONTPATH') ? FPDF_FONTPATH : '';
        }

        public function _putpages()
        {
            $nb = $this->page;
            if (!empty($this->AliasNbPages)) {
                //Replace number of pages
                for ($n = 1; $n <= $nb; $n++) {
                    $this->pages[$n] = str_replace($this->AliasNbPages, $nb, $this->pages[$n]);
                }
            }
            if ('P' == $this->DefOrientation) {
                $wPt = $this->fwPt;
                $hPt = $this->fhPt;
            } else {
                $wPt = $this->fhPt;
                $hPt = $this->fwPt;
            }
            $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
            for ($n = 1; $n <= $nb; $n++) {
                //Page
                $this->_newobj();
                $this->_out('<</Type /Page');
                $this->_out('/Parent 1 0 R');
                if (isset($this->OrientationChanges[$n])) {
                    $this->_out(sprintf('/MediaBox [0 0 %.2f %.2f]', $hPt, $wPt));
                }
                $this->_out('/Resources 2 0 R');
                if (isset($this->PageLinks[$n])) {
                    //Links
                    $annots = '/Annots [';
                    foreach ($this->PageLinks[$n] as $pl) {
                        $rect = sprintf('%.2f %.2f %.2f %.2f', $pl[0], $pl[1], $pl[0] + $pl[2], $pl[1] - $pl[3]);
                        $annots .= '<</Type /Annot /Subtype /Link /Rect [' . $rect . '] /Border [0 0 0] ';
                        if (is_string($pl[4])) {
                            $annots .= '/A <</S /URI /URI ' . $this->_textstring($pl[4]) . '>>>>';
                        } else {
                            $l = $this->links[$pl[4]];
                            $h = isset($this->OrientationChanges[$l[0]]) ? $wPt : $hPt;
                            $annots .= sprintf('/Dest [%d 0 R /XYZ 0 %.2f null]>>', 1 + 2 * $l[0], $h - $l[1] * $this->k);
                        }
                    }
                    $this->_out($annots . ']');
                }
                $this->_out('/Contents ' . ($this->n + 1) . ' 0 R>>');
                $this->_out('endobj');
                //Page content
                $p = ($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
                $this->_newobj();
                $this->_out('<<' . $filter . '/Length ' . mb_strlen($p) . '>>');
                $this->_putstream($p);
                $this->_out('endobj');
            }
            //Pages root
            $this->offsets[1] = mb_strlen($this->buffer);
            $this->_out('1 0 obj');
            $this->_out('<</Type /Pages');
            $kids = '/Kids [';
            for ($i = 0; $i < $nb; $i++) {
                $kids .= (3 + 2 * $i) . ' 0 R ';
            }
            $this->_out($kids . ']');
            $this->_out('/Count ' . $nb);
            $this->_out(sprintf('/MediaBox [0 0 %.2f %.2f]', $wPt, $hPt));
            $this->_out('>>');
            $this->_out('endobj');
        }

        public function _putfonts()
        {
            $nf = $this->n;
            foreach ($this->diffs as $diff) {
                //Encodings
                $this->_newobj();
                $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences [' . $diff . ']>>');
                $this->_out('endobj');
            }
            $mqr = get_magic_quotes_runtime();
            set_magic_quotes_runtime(0);
            foreach ($this->FontFiles as $file => $info) {
                //Font file embedding
                $this->_newobj();
                $this->FontFiles[$file]['n'] = $this->n;
                $font = '';
                $f = fopen($this->_getfontpath() . $file, 'rb', 1);
                if (!$f) {
                    $this->Error('Font file not found');
                }
                while (!feof($f)) {
                    $font .= fread($f, 8192);
                }
                fclose($f);
                $compressed = ('.z' == mb_substr($file, -2));
                if (!$compressed && isset($info['length2'])) {
                    $header = (128 == ord($font[0]));
                    if ($header) {
                        //Strip first binary header
                        $font = mb_substr($font, 6);
                    }
                    if ($header && 128 == ord($font[$info['length1']])) {
                        //Strip second binary header
                        $font = mb_substr($font, 0, $info['length1']) . mb_substr($font, $info['length1'] + 6);
                    }
                }
                $this->_out('<</Length ' . mb_strlen($font));
                if ($compressed) {
                    $this->_out('/Filter /FlateDecode');
                }
                $this->_out('/Length1 ' . $info['length1']);
                if (isset($info['length2'])) {
                    $this->_out('/Length2 ' . $info['length2'] . ' /Length3 0');
                }
                $this->_out('>>');
                $this->_putstream($font);
                $this->_out('endobj');
            }
            set_magic_quotes_runtime($mqr);
            foreach ($this->fonts as $k => $font) {
                //Font objects
                $this->fonts[$k]['n'] = $this->n + 1;
                $type = $font['type'];
                $name = $font['name'];
                if ('core' == $type) {
                    //Standard font
                    $this->_newobj();
                    $this->_out('<</Type /Font');
                    $this->_out('/BaseFont /' . $name);
                    $this->_out('/Subtype /Type1');
                    if ('Symbol' != $name && 'ZapfDingbats' != $name) {
                        $this->_out('/Encoding /WinAnsiEncoding');
                    }
                    $this->_out('>>');
                    $this->_out('endobj');
                } elseif ('Type1' == $type || 'TrueType' == $type) {
                    //Additional Type1 or TrueType font
                    $this->_newobj();
                    $this->_out('<</Type /Font');
                    $this->_out('/BaseFont /' . $name);
                    $this->_out('/Subtype /' . $type);
                    $this->_out('/FirstChar 32 /LastChar 255');
                    $this->_out('/Widths ' . ($this->n + 1) . ' 0 R');
                    $this->_out('/FontDescriptor ' . ($this->n + 2) . ' 0 R');
                    if ($font['enc']) {
                        if (isset($font['diff'])) {
                            $this->_out('/Encoding ' . ($nf + $font['diff']) . ' 0 R');
                        } else {
                            $this->_out('/Encoding /WinAnsiEncoding');
                        }
                    }
                    $this->_out('>>');
                    $this->_out('endobj');
                    //Widths
                    $this->_newobj();
                    $cw = &$font['cw'];
                    $s = '[';
                    for ($i = 32; $i <= 255; $i++) {
                        $s .= $cw[chr($i)] . ' ';
                    }
                    $this->_out($s . ']');
                    $this->_out('endobj');
                    //Descriptor
                    $this->_newobj();
                    $s = '<</Type /FontDescriptor /FontName /' . $name;
                    foreach ($font['desc'] as $k => $v) {
                        $s .= ' /' . $k . ' ' . $v;
                    }
                    $file = $font['file'];
                    if ($file) {
                        $s .= ' /FontFile' . ('Type1' == $type ? '' : '2') . ' ' . $this->FontFiles[$file]['n'] . ' 0 R';
                    }
                    $this->_out($s . '>>');
                    $this->_out('endobj');
                } else {
                    //Allow for additional types
                    $mtd = '_put' . mb_strtolower($type);
                    if (!method_exists($this, $mtd)) {
                        $this->Error('Unsupported font type: ' . $type);
                    }
                    $this->$mtd($font);
                }
            }
        }

        public function _putimages()
        {
            $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
            reset($this->images);
            while (list($file, $info) = each($this->images)) {
                $this->_newobj();
                $this->images[$file]['n'] = $this->n;
                $this->_out('<</Type /XObject');
                $this->_out('/Subtype /Image');
                $this->_out('/Width ' . $info['w']);
                $this->_out('/Height ' . $info['h']);
                if ('Indexed' == $info['cs']) {
                    $this->_out('/ColorSpace [/Indexed /DeviceRGB ' . (mb_strlen($info['pal']) / 3 - 1) . ' ' . ($this->n + 1) . ' 0 R]');
                } else {
                    $this->_out('/ColorSpace /' . $info['cs']);
                    if ('DeviceCMYK' == $info['cs']) {
                        $this->_out('/Decode [1 0 1 0 1 0 1 0]');
                    }
                }
                $this->_out('/BitsPerComponent ' . $info['bpc']);
                if (isset($info['f'])) {
                    $this->_out('/Filter /' . $info['f']);
                }
                if (isset($info['parms'])) {
                    $this->_out($info['parms']);
                }
                if (isset($info['trns']) && is_array($info['trns'])) {
                    $trns = '';
                    for ($i = 0; $i < count($info['trns']); $i++) {
                        $trns .= $info['trns'][$i] . ' ' . $info['trns'][$i] . ' ';
                    }
                    $this->_out('/Mask [' . $trns . ']');
                }
                $this->_out('/Length ' . mb_strlen($info['data']) . '>>');
                $this->_putstream($info['data']);
                unset($this->images[$file]['data']);
                $this->_out('endobj');
                //Palette
                if ('Indexed' == $info['cs']) {
                    $this->_newobj();
                    $pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
                    $this->_out('<<' . $filter . '/Length ' . mb_strlen($pal) . '>>');
                    $this->_putstream($pal);
                    $this->_out('endobj');
                }
            }
        }

        public function _putxobjectdict()
        {
            foreach ($this->images as $image) {
                $this->_out('/I' . $image['i'] . ' ' . $image['n'] . ' 0 R');
            }
        }

        public function _putresourcedict()
        {
            $this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
            $this->_out('/Font <<');
            foreach ($this->fonts as $font) {
                $this->_out('/F' . $font['i'] . ' ' . $font['n'] . ' 0 R');
            }
            $this->_out('>>');
            $this->_out('/XObject <<');
            $this->_putxobjectdict();
            $this->_out('>>');
        }

        public function _putresources()
        {
            $this->_putfonts();
            $this->_putimages();
            //Resource dictionary
            $this->offsets[2] = mb_strlen($this->buffer);
            $this->_out('2 0 obj');
            $this->_out('<<');
            $this->_putresourcedict();
            $this->_out('>>');
            $this->_out('endobj');
        }

        public function _putinfo()
        {
            $this->_out('/Producer ' . $this->_textstring('FPDF ' . FPDF_VERSION));
            if (!empty($this->title)) {
                $this->_out('/Title ' . $this->_textstring($this->title));
            }
            if (!empty($this->subject)) {
                $this->_out('/Subject ' . $this->_textstring($this->subject));
            }
            if (!empty($this->author)) {
                $this->_out('/Author ' . $this->_textstring($this->author));
            }
            if (!empty($this->keywords)) {
                $this->_out('/Keywords ' . $this->_textstring($this->keywords));
            }
            if (!empty($this->creator)) {
                $this->_out('/Creator ' . $this->_textstring($this->creator));
            }
            $this->_out('/CreationDate ' . $this->_textstring('D:' . date('YmdHis')));
        }

        public function _putcatalog()
        {
            $this->_out('/Type /Catalog');
            $this->_out('/Pages 1 0 R');
            if ('fullpage' == $this->ZoomMode) {
                $this->_out('/OpenAction [3 0 R /Fit]');
            } elseif ('fullwidth' == $this->ZoomMode) {
                $this->_out('/OpenAction [3 0 R /FitH null]');
            } elseif ('real' == $this->ZoomMode) {
                $this->_out('/OpenAction [3 0 R /XYZ null null 1]');
            } elseif (!is_string($this->ZoomMode)) {
                $this->_out('/OpenAction [3 0 R /XYZ null null ' . ($this->ZoomMode / 100) . ']');
            }
            if ('single' == $this->LayoutMode) {
                $this->_out('/PageLayout /SinglePage');
            } elseif ('continuous' == $this->LayoutMode) {
                $this->_out('/PageLayout /OneColumn');
            } elseif ('two' == $this->LayoutMode) {
                $this->_out('/PageLayout /TwoColumnLeft');
            }
        }

        public function _putheader()
        {
            $this->_out('%PDF-' . $this->PDFVersion);
        }

        public function _puttrailer()
        {
            $this->_out('/Size ' . ($this->n + 1));
            $this->_out('/Root ' . $this->n . ' 0 R');
            $this->_out('/Info ' . ($this->n - 1) . ' 0 R');
        }

        public function _enddoc()
        {
            $this->_putheader();
            $this->_putpages();
            $this->_putresources();
            //Info
            $this->_newobj();
            $this->_out('<<');
            $this->_putinfo();
            $this->_out('>>');
            $this->_out('endobj');
            //Catalog
            $this->_newobj();
            $this->_out('<<');
            $this->_putcatalog();
            $this->_out('>>');
            $this->_out('endobj');
            //Cross-ref
            $o = mb_strlen($this->buffer);
            $this->_out('xref');
            $this->_out('0 ' . ($this->n + 1));
            $this->_out('0000000000 65535 f ');
            for ($i = 1; $i <= $this->n; $i++) {
                $this->_out(sprintf('%010d 00000 n ', $this->offsets[$i]));
            }
            //Trailer
            $this->_out('trailer');
            $this->_out('<<');
            $this->_puttrailer();
            $this->_out('>>');
            $this->_out('startxref');
            $this->_out($o);
            $this->_out('%%EOF');
            $this->state = 3;
        }

        public function _beginpage($orientation)
        {
            $this->page++;
            $this->pages[$this->page] = '';
            $this->state = 2;
            $this->x = $this->lMargin;
            $this->y = $this->tMargin;
            $this->FontFamily = '';
            //Page orientation
            if (!$orientation) {
                $orientation = $this->DefOrientation;
            } else {
                $orientation = mb_strtoupper($orientation[0]);
                if ($orientation != $this->DefOrientation) {
                    $this->OrientationChanges[$this->page] = true;
                }
            }
            if ($orientation != $this->CurOrientation) {
                //Change orientation
                if ('P' == $orientation) {
                    $this->wPt = $this->fwPt;
                    $this->hPt = $this->fhPt;
                    $this->w = $this->fw;
                    $this->h = $this->fh;
                } else {
                    $this->wPt = $this->fhPt;
                    $this->hPt = $this->fwPt;
                    $this->w = $this->fh;
                    $this->h = $this->fw;
                }
                $this->PageBreakTrigger = $this->h - $this->bMargin;
                $this->CurOrientation = $orientation;
            }
        }

        public function _endpage()
        {
            //End of page contents
            $this->state = 1;
        }

        public function _newobj()
        {
            //Begin a new object
            $this->n++;
            $this->offsets[$this->n] = mb_strlen($this->buffer);
            $this->_out($this->n . ' 0 obj');
        }

        public function _dounderline($x, $y, $txt)
        {
            //Underline text
            $up = $this->CurrentFont['up'];
            $ut = $this->CurrentFont['ut'];
            $w = $this->GetStringWidth($txt) + $this->ws * mb_substr_count($txt, ' ');

            return sprintf('%.2f %.2f %.2f %.2f re f', $x * $this->k, ($this->h - ($y - $up / 1000 * $this->FontSize)) * $this->k, $w * $this->k, -$ut / 1000 * $this->FontSizePt);
        }

        public function _parsejpg($file)
        {
            //Extract info from a JPEG file
            $a = getimagesize($file);
            if (!$a) {
                $this->Error('Missing or incorrect image file: ' . $file);
            }
            if (2 != $a[2]) {
                $this->Error('Not a JPEG file: ' . $file);
            }
            if (!isset($a['channels']) || 3 == $a['channels']) {
                $colspace = 'DeviceRGB';
            } elseif (4 == $a['channels']) {
                $colspace = 'DeviceCMYK';
            } else {
                $colspace = 'DeviceGray';
            }
            $bpc = isset($a['bits']) ? $a['bits'] : 8;
            //Read whole file
            $f = fopen($file, 'rb');
            $data = '';
            while (!feof($f)) {
                $data .= fread($f, 4096);
            }
            fclose($f);

            return ['w' => $a[0], 'h' => $a[1], 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data];
        }

        public function _parsepng($file)
        {
            //Extract info from a PNG file
            $f = fopen($file, 'rb');
            if (!$f) {
                $this->Error('Can\'t open image file: ' . $file);
            }
            //Check signature
            if (fread($f, 8) != chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10)) {
                $this->Error('Not a PNG file: ' . $file);
            }
            //Read header chunk
            fread($f, 4);
            if ('IHDR' != fread($f, 4)) {
                $this->Error('Incorrect PNG file: ' . $file);
            }
            $w = $this->_freadint($f);
            $h = $this->_freadint($f);
            $bpc = ord(fread($f, 1));
            if ($bpc > 8) {
                $this->Error('16-bit depth not supported: ' . $file);
            }
            $ct = ord(fread($f, 1));
            if (0 == $ct) {
                $colspace = 'DeviceGray';
            } elseif (2 == $ct) {
                $colspace = 'DeviceRGB';
            } elseif (3 == $ct) {
                $colspace = 'Indexed';
            } else {
                $this->Error('Alpha channel not supported: ' . $file);
            }
            if (0 != ord(fread($f, 1))) {
                $this->Error('Unknown compression method: ' . $file);
            }
            if (0 != ord(fread($f, 1))) {
                $this->Error('Unknown filter method: ' . $file);
            }
            if (0 != ord(fread($f, 1))) {
                $this->Error('Interlacing not supported: ' . $file);
            }
            fread($f, 4);
            $parms = '/DecodeParms <</Predictor 15 /Colors ' . (2 == $ct ? 3 : 1) . ' /BitsPerComponent ' . $bpc . ' /Columns ' . $w . '>>';
            //Scan chunks looking for palette, transparency and image data
            $pal = '';
            $trns = '';
            $data = '';
            do {
                $n = $this->_freadint($f);
                $type = fread($f, 4);
                if ('PLTE' == $type) {
                    //Read palette
                    $pal = fread($f, $n);
                    fread($f, 4);
                } elseif ('tRNS' == $type) {
                    //Read transparency info
                    $t = fread($f, $n);
                    if (0 == $ct) {
                        $trns = [ord(mb_substr($t, 1, 1))];
                    } elseif (2 == $ct) {
                        $trns = [ord(mb_substr($t, 1, 1)), ord(mb_substr($t, 3, 1)), ord(mb_substr($t, 5, 1))];
                    } else {
                        $pos = mb_strpos($t, chr(0));
                        if (false !== $pos) {
                            $trns = [$pos];
                        }
                    }
                    fread($f, 4);
                } elseif ('IDAT' == $type) {
                    //Read image data block
                    $data .= fread($f, $n);
                    fread($f, 4);
                } elseif ('IEND' == $type) {
                    break;
                } else {
                    fread($f, $n + 4);
                }
            } while ($n);
            if ('Indexed' == $colspace && empty($pal)) {
                $this->Error('Missing palette in ' . $file);
            }
            fclose($f);

            return ['w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'parms' => $parms, 'pal' => $pal, 'trns' => $trns, 'data' => $data];
        }

        public function _freadint($f)
        {
            //Read a 4-byte integer from file
            $a = unpack('Ni', fread($f, 4));

            return $a['i'];
        }

        public function _textstring($s)
        {
            //Format a text string
            return '(' . $this->_escape($s) . ')';
        }

        public function _escape($s)
        {
            //Add \ before \, ( and )
            return str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $s)));
        }

        public function _putstream($s)
        {
            $this->_out('stream');
            $this->_out($s);
            $this->_out('endstream');
        }

        public function _out($s)
        {
            //Add a line to the document
            if (2 == $this->state) {
                $this->pages[$this->page] .= $s . "\n";
            } else {
                $this->buffer .= $s . "\n";
            }
        }

        public function writeHTML($html, $ln = true, $fill = 0, $reseth = false, $cell = false)
        {
            // store some variables
            $html = strip_tags($html, '<h1><h2><h3><h4><h5><h6><b><u><i><a><img><p><br><br><strong><em><font><blockquote><li><ul><ol><hr><td><th><tr><table><sup><sub><small><span><div>'); //remove all unsupported tags
            //replace carriage returns, newlines and tabs
            $repTable = ["\t" => '', "\n" => '', "\r" => '', "\0" => '', "\x0B" => ''];
            $html = strtr($html, $repTable);
            $pattern = '/(<[^>]+>)/Uu';
            $a = preg_split($pattern, $html, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY); //explodes the string

            if ((empty($this->lasth)) or ($reseth)) {
                //set row height
                $this->lasth = $this->FontSize * K_CELL_HEIGHT_RATIO;
            }

            foreach ($a as $key => $element) {
                if (!preg_match($pattern, $element)) {
                    //Text
                    if ($this->HREF) {
                        $this->addHtmlLink($this->HREF, $element);
                    } elseif ($this->tdbegin) {
                        if ((mb_strlen(trim($element)) > 0) and ('&nbsp;' != $element)) {
                            $this->Cell($this->tdwidth, $this->tdheight, $this->unhtmlentities($element), $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
                        } elseif ('&nbsp;' == $element) {
                            $this->Cell($this->tdwidth, $this->tdheight, '', $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
                        }
                    } else {
                        $ctmpmargin = $this->cMargin;
                        if (!$cell) {
                            $this->cMargin = 0;
                        }
                        $this->Write($this->lasth, stripslashes($this->unhtmlentities($element)), '', $fill);
                        $this->cMargin = $ctmpmargin;
                    }
                } else {
                    $element = mb_substr($element, 1, -1);
                    //Tag
                    if ('/' == $element[0]) {
                        $this->closedHTMLTagHandler(mb_strtolower(mb_substr($element, 1)));
                    } else {
                        //Extract attributes
                        // get tag name
                        preg_match('/([a-zA-Z0-9]*)/', $element, $tag);
                        $tag = mb_strtolower($tag[0]);
                        // get attributes
                        preg_match_all('/([^=\s]*)=["\']?([^"\']*)["\']?/', $element, $attr_array, PREG_PATTERN_ORDER);
                        $attr = []; // reset attribute array
                        while (list($id, $name) = each($attr_array[1])) {
                            $attr[mb_strtolower($name)] = $attr_array[2][$id];
                        }
                        $this->openHTMLTagHandler($tag, $attr, $fill);
                    }
                }
            }
            if ($ln) {
                $this->Ln($this->lasth);
            }
        }

        public function openHTMLTagHandler($tag, $attr, $fill = 0)
        {
            // check for text direction attribute
            if (isset($attr['dir'])) {
                $this->tmprtl = 'rtl' == $attr['dir'] ? 'R' : 'L';
            } else {
                $this->tmprtl = false;
            }
            //Opening tag
            switch ($tag) {
                case 'table': {
                    if ((isset($attr['border'])) and ('' != $attr['border'])) {
                        $this->tableborder = $attr['border'];
                    } else {
                        $this->tableborder = 0;
                    }
                    break;
                }
                case 'tr': {
                    break;
                }
                case 'td':
                case 'th': {
                    if ((isset($attr['width'])) and ('' != $attr['width'])) {
                        $this->tdwidth = ($attr['width'] / 4);
                    } else {
                        $this->tdwidth = (($this->w - $this->lMargin - $this->rMargin) / $this->default_table_columns);
                    }
                    if ((isset($attr['height'])) and ('' != $attr['height'])) {
                        $this->tdheight = ($attr['height'] / $this->k);
                    } else {
                        $this->tdheight = $this->lasth;
                    }
                    if ((isset($attr['align'])) and ('' != $attr['align'])) {
                        switch ($attr['align']) {
                            case 'center': {
                                $this->tdalign = 'C';
                                break;
                            }
                            case 'right': {
                                $this->tdalign = 'R';
                                break;
                            }
                            default:
                            case 'left': {
                                $this->tdalign = 'L';
                                break;
                            }
                        }
                    } else {
                        if ($this->rtl) {
                            $this->tdalign = 'R';
                        } else {
                            $this->tdalign = 'L';
                        }
                    }
                    if ((isset($attr['bgcolor'])) and ('' != $attr['bgcolor'])) {
                        $coul = $this->convertColorHexToDec($attr['bgcolor']);
                        $this->SetFillColor($coul['R'], $coul['G'], $coul['B']);
                        $this->tdbgcolor = true;
                    }
                    $this->tdbegin = true;
                    break;
                }
                case 'hr': {
                    $this->Ln();
                    if ((isset($attr['width'])) and ('' != $attr['width'])) {
                        $hrWidth = $attr['width'];
                    } else {
                        $hrWidth = $this->w - $this->lMargin - $this->rMargin;
                    }
                    $x = $this->GetX();
                    $y = $this->GetY();
                    $this->GetLineWidth();
                    $prevlinewidth = $this->SetLineWidth(0.2);
                    $this->Line($x, $y, $x + $hrWidth, $y);
                    $this->SetLineWidth($prevlinewidth);
                    $this->Ln();
                    break;
                }
                case 'strong': {
                    $this->setStyle('b', true);
                    break;
                }
                case 'em': {
                    $this->setStyle('i', true);
                    break;
                }
                case 'b':
                case 'i':
                case 'u': {
                    $this->setStyle($tag, true);
                    break;
                }
                case 'a': {
                    $this->HREF = $attr['href'];
                    break;
                }
                case 'img': {
                    if (isset($attr['src'])) {
                        // replace relative path with real server path
                        $attr['src'] = str_replace(K_PATH_URL_CACHE, K_PATH_CACHE, $attr['src']);
                        if (!isset($attr['width'])) {
                            $attr['width'] = 0;
                        }
                        if (!isset($attr['height'])) {
                            $attr['height'] = 0;
                        }
                        if (!isset($attr['align'])) {
                            $align = 'N';
                        } else {
                            switch ($attr['align']) {
                                case 'top':{
                                    $align = 'T';
                                    break;
                                }
                                case 'middle':{
                                    $align = 'M';
                                    break;
                                }
                                case 'bottom':{
                                    $align = 'B';
                                    break;
                                }
                                default:{
                                    $align = 'N';
                                    break;
                                }
                            }
                        }
                        $this->Image($attr['src'], $this->GetX(), $this->GetY(), $this->pixelsToMillimeters($attr['width']), $this->pixelsToMillimeters($attr['height']), '', '', $align);
                    }
                    break;
                }
                case 'ul': {
                    $this->listordered = false;
                    $this->listcount = 0;
                    break;
                }
                case 'ol': {
                    $this->listordered = true;
                    $this->listcount = 0;
                    break;
                }
                case 'li': {
                    $this->Ln();
                    if ($this->listordered) {
                        if (isset($attr['value'])) {
                            $this->listcount = intval($attr['value']);
                        }
                        $this->lispacer = '    ' . (++$this->listcount) . '. ';
                    } else {
                        //unordered list simbol
                        $this->lispacer = '    -  ';
                    }
                    $rtldir = $this->tmprtl;
                    $this->tmprtl = false;
                    $this->Write($this->lasth, $this->lispacer, '', $fill);
                    $this->tmprtl = $rtldir;
                    break;
                }
                case 'blockquote':
                case 'br': {
                    $this->Ln();
                    if (mb_strlen($this->lispacer) > 0) {
                        if ($this->rtl) {
                            $this->x -= $this->GetStringWidth($this->lispacer);
                        } else {
                            $this->x += $this->GetStringWidth($this->lispacer);
                        }
                    }
                    break;
                }
                case 'p': {
                    $this->Ln();
                    $this->Ln();
                    break;
                }
                case 'sup': {
                    $currentFontSize = $this->FontSize;
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetFontSize($this->FontSizePt * K_SMALL_RATIO);
                    $this->SetXY($this->GetX(), $this->GetY() - (($currentFontSize - $this->FontSize) * (K_SMALL_RATIO)));
                    break;
                }
                case 'sub': {
                    $currentFontSize = $this->FontSize;
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetFontSize($this->FontSizePt * K_SMALL_RATIO);
                    $this->SetXY($this->GetX(), $this->GetY() + (($currentFontSize - $this->FontSize) * (K_SMALL_RATIO)));
                    break;
                }
                case 'small': {
                    $currentFontSize = $this->FontSize;
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetFontSize($this->FontSizePt * K_SMALL_RATIO);
                    $this->SetXY($this->GetX(), $this->GetY() + (($currentFontSize - $this->FontSize) / 3));
                    break;
                }
                case 'font': {
                    if (isset($attr['color']) and '' != $attr['color']) {
                        $coul = $this->convertColorHexToDec($attr['color']);
                        $this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
                        $this->issetcolor = true;
                    }
                    if (isset($attr['face']) and in_array(mb_strtolower($attr['face']), $this->fontlist, true)) {
                        $this->SetFont(mb_strtolower($attr['face']));
                        $this->issetfont = true;
                    }
                    if (isset($attr['size'])) {
                        $headsize = intval($attr['size']);
                    } else {
                        $headsize = 0;
                    }
                    $currentFontSize = $this->FontSize;
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetFontSize($this->FontSizePt + $headsize);
                    $this->lasth = $this->FontSize * K_CELL_HEIGHT_RATIO;
                    break;
                }
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6': {
                    $headsize = (4 - mb_substr($tag, 1)) * 2;
                    $currentFontSize = $this->FontSize;
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetFontSize($this->FontSizePt + $headsize);
                    $this->setStyle('b', true);
                    $this->lasth = $this->FontSize * K_CELL_HEIGHT_RATIO;
                    break;
                }
            }
        }

        public function closedHTMLTagHandler($tag)
        {
            //Closing tag
            switch ($tag) {
                case 'td':
                case 'th': {
                    $this->tdbegin = false;
                    $this->tdwidth = 0;
                    $this->tdheight = 0;
                    if ($this->rtl) {
                        $this->tdalign = 'R';
                    } else {
                        $this->tdalign = 'L';
                    }
                    $this->tdbgcolor = false;
                    $this->SetFillColor($this->prevFillColor[0], $this->prevFillColor[1], $this->prevFillColor[2]);
                    break;
                }
                case 'tr': {
                    $this->Ln();
                    break;
                }
                case 'table': {
                    $this->tableborder = 0;
                    break;
                }
                case 'strong': {
                    $this->setStyle('b', false);
                    break;
                }
                case 'em': {
                    $this->setStyle('i', false);
                    break;
                }
                case 'b':
                case 'i':
                case 'u': {
                    $this->setStyle($tag, false);
                    break;
                }
                case 'a': {
                    $this->HREF = '';
                    break;
                }
                case 'sup': {
                    $currentFontSize = $this->FontSize;
                    $this->SetFontSize($this->tempfontsize);
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetXY($this->GetX(), $this->GetY() - (($currentFontSize - $this->FontSize) * (K_SMALL_RATIO)));
                    break;
                }
                case 'sub': {
                    $currentFontSize = $this->FontSize;
                    $this->SetFontSize($this->tempfontsize);
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetXY($this->GetX(), $this->GetY() + (($currentFontSize - $this->FontSize) * (K_SMALL_RATIO)));
                    break;
                }
                case 'small': {
                    $currentFontSize = $this->FontSize;
                    $this->SetFontSize($this->tempfontsize);
                    $this->tempfontsize = $this->FontSizePt;
                    $this->SetXY($this->GetX(), $this->GetY() - (($this->FontSize - $currentFontSize) / 3));
                    break;
                }
                case 'font': {
                    if (true === $this->issetcolor) {
                        $this->SetTextColor($this->prevTextColor[0], $this->prevTextColor[1], $this->prevTextColor[2]);
                    }
                    if ($this->issetfont) {
                        $this->FontFamily = $this->prevFontFamily;
                        $this->FontStyle = $this->prevFontStyle;
                        $this->SetFont($this->FontFamily);
                        $this->issetfont = false;
                    }
                    $currentFontSize = $this->FontSize;
                    $this->SetFontSize($this->tempfontsize);
                    $this->tempfontsize = $this->FontSizePt;
                    //$this->TextColor = $this->prevTextColor;
                    $this->lasth = $this->FontSize * K_CELL_HEIGHT_RATIO;
                    break;
                }
                case 'p': {
                    $this->Ln();
                    $this->Ln();
                    break;
                }
                case 'ul':
                case 'ol': {
                    $this->Ln();
                    $this->Ln();
                    break;
                }
                case 'li': {
                    $this->lispacer = '';
                    break;
                }
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6': {
                    $currentFontSize = $this->FontSize;
                    $this->SetFontSize($this->tempfontsize);
                    $this->tempfontsize = $this->FontSizePt;
                    $this->setStyle('b', false);
                    $this->Ln();
                    $this->lasth = $this->FontSize * K_CELL_HEIGHT_RATIO;
                    break;
                }
                default: {
                    break;
                }
            }
            $this->tmprtl = false;
        }

        public function addHtmlLink($url, $name)
        {
            //Put a hyperlink
            $this->SetTextColor(0, 0, 255);
            $this->setStyle('u', true);
            $this->Write($this->lasth, $name, $url);
            $this->SetTextColor(0);
            $this->setStyle('u', false);
        }

        public function unhtmlentities($text_to_convert)
        {
            return html_entity_decode($text_to_convert, ENT_QUOTES, $this->encoding);
        }

        public function convertColorHexToDec($color = '#000000')
        {
            $tbl_color = [];
            $tbl_color['R'] = hexdec(mb_substr($color, 1, 2));
            $tbl_color['G'] = hexdec(mb_substr($color, 3, 2));
            $tbl_color['B'] = hexdec(mb_substr($color, 5, 2));

            return $tbl_color;
        }

        public function setStyle($tag, $enable)
        {
            //Modify style and select corresponding font
            $this->$tag += ($enable ? 1 : -1);
            $style = '';
            foreach (['b', 'i', 'u'] as $s) {
                if ($this->$s > 0) {
                    $style .= $s;
                }
            }
            $this->SetFont('', $style);
        }

        public function GetLineWidth()
        {
            return $this->LineWidth;
        }

        public function pixelsToMillimeters($px)
        {
            return $px / 4; //* 25.4 / 72;
        }

        public function Header()
        {
            if ($this->print_header) {
                if (!isset($this->original_lMargin)) {
                    $this->original_lMargin = $this->lMargin;
                }
                if (!isset($this->original_rMargin)) {
                    $this->original_rMargin = $this->rMargin;
                }

                //set current position
                if ($this->rtl) {
                    $this->SetXY($this->original_rMargin, $this->header_margin);
                } else {
                    $this->SetXY($this->original_lMargin, $this->header_margin);
                }

                if (($this->header_logo) and (K_BLANK_IMAGE != $this->header_logo)) {
                    $this->Image(K_PATH_IMAGES . $this->header_logo, $this->GetX(), $this->header_margin, $this->header_logo_width);
                } else {
                    $this->img_rb_x = $this->GetX();
                    $this->img_rb_y = $this->GetY();
                }

                $cell_height = round((K_CELL_HEIGHT_RATIO * $this->header_font[2]) / $this->k, 2);
                // set starting margin for text data cell
                if ($this->rtl) {
                    $header_x = $this->original_rMargin + ($this->header_logo_width * 1.1);
                } else {
                    $header_x = $this->original_lMargin + ($this->header_logo_width * 1.1);
                }

                // header title
                $this->SetFont($this->header_font[0], 'B', $this->header_font[2] + 1);
                $this->SetX($header_x);
                $this->Cell($this->header_width, $cell_height, $this->header_title, 0, 1, '');

                // header string
                $this->SetFont($this->header_font[0], $this->header_font[1], $this->header_font[2]);
                $this->SetX($header_x);
                $this->MultiCell($this->header_width, $cell_height, $this->header_string, 0, '', 0);

                // print an ending header line
                if (empty($this->header_width)) {
                    //set style for cell border
                    $prevlinewidth = $this->GetLineWidth();
                    $line_width = 0.3;
                    $this->SetLineWidth($line_width);
                    $this->SetDrawColor(0, 0, 0);
                    $this->SetY(1 + max($this->img_rb_y, $this->GetY()));
                    if ($this->rtl) {
                        $this->SetX($this->original_rMargin);
                    } else {
                        $this->SetX($this->original_lMargin);
                    }
                    $this->Cell(0, 0, '', 'T', 0, 'C');
                    $this->SetLineWidth($prevlinewidth);
                }

                //restore position
                if ($this->rtl) {
                    $this->SetXY($this->original_rMargin, $this->tMargin);
                } else {
                    $this->SetXY($this->original_lMargin, $this->tMargin);
                }
            }
        }

        public function Footer()
        {
            if ($this->print_footer) {
                if (!isset($this->original_lMargin)) {
                    $this->original_lMargin = $this->lMargin;
                }
                if (!isset($this->original_rMargin)) {
                    $this->original_rMargin = $this->rMargin;
                }

                //set font
                $this->SetFont($this->footer_font[0], $this->footer_font[1], $this->footer_font[2]);
                //set style for cell border
                $prevlinewidth = $this->GetLineWidth();
                $line_width = 0.3;
                $this->SetLineWidth($line_width);
                $this->SetDrawColor(0, 0, 0);

                $footer_height = round((K_CELL_HEIGHT_RATIO * $this->footer_font[2]) / $this->k, 2); //footer height
                //get footer y position
                $footer_y = $this->h - $this->footer_margin - $footer_height;
                //set current position
                if ($this->rtl) {
                    $this->SetXY($this->original_rMargin, $footer_y);
                } else {
                    $this->SetXY($this->original_lMargin, $footer_y);
                }

                $pagenumtxt = $this->l['w_page'] . ' ' . $this->PageNo() . ' / ' . count($this->pages);

                $this->SetY($footer_y);

                //Print page number
                if ($this->rtl) {
                    $this->SetX($this->original_rMargin);
                    $this->Cell(0, $footer_height, $pagenumtxt, 'T', 0, 'L');
                } else {
                    $this->SetX($this->original_lMargin);
                    $this->Cell(0, $footer_height, $pagenumtxt, 'T', 0, 'R');
                }
                // restore line width
                $this->SetLineWidth($prevlinewidth);
            }
        }

        public function setHeaderFont($font)
        {
            $this->header_font = $font;
        }

        public function setFooterFont($font)
        {
            $this->footer_font = $font;
        }

        public function setHeaderData($ln = '', $lw = 0, $ht = '', $hs = '')
        {
            $this->header_logo = $ln;
            $this->header_logo_width = $lw;
            $this->header_title = $ht;
            $this->header_string = $hs;
        }

        public function setHeaderMargin($hm = 10)
        {
            $this->header_margin = $hm;
        }

        public function setFooterMargin($fm = 10)
        {
            $this->footer_margin = $fm;
        }

        public function setPrintHeader($val = true)
        {
            $this->print_header = $val;
        }

        public function setPrintFooter($val = true)
        {
            $this->print_footer = $val;
        }

        //End of class
    }

    //Handle special IE contype request
    if (isset($_SERVER['HTTP_USER_AGENT']) && 'contype' == $_SERVER['HTTP_USER_AGENT']) {
        header('Content-Type: application/pdf');
        exit;
    }
}

<?php

namespace XoopsModules\Tadtools;

class Wcag
{

    private static $check_items = [];
    private static $check_title = [];
    private static $regular = [];

    public static function getVar($var)
    {
        self::$check_items['fontsize'] = ['font-size:'];
        self::$check_title['fontsize'] = TADTOOLS_CHK_FONTSIZE;
        self::$regular['fontsize'] = ['fontsize' => "/font-size:\s*([+-]?\d*|\d*\.\d*)(px|pt|)\s*;/Ui"];

        self::$check_items['no_need'] = ['font-size-adjust:'];
        self::$check_title['no_need'] = TADTOOLS_CHK_NO_NEED;
        self::$regular['no_need'] = ['font_size_adjust' => "/font-size-adjust:.*;/Uim"];

        self::$check_items['size'] = ['font:'];
        self::$check_title['size'] = TADTOOLS_CHK_FONTSIZE2;
        self::$regular['size'] = ['size' => "/font:\s?(\d*|\d*\.\d*)(px|pt)/Ui"];

        self::$check_items['need_title'] = ['<iframe ', '<object ', '<applet ', '<embed ', '<input ', '<select ', '<textarea '];
        self::$check_title['need_title'] = TADTOOLS_CHK_NEED_TITLE;
        self::$regular['need_title'] = ['iframe' => "/(<iframe[^>]*>.*<\/iframe>)/Uims", 'object' => "/<object (.*)><\/object>/Ui", 'applet' => "/<applet (.*)><\/applet>/Ui", 'embed' => "/<embed (.*)><\/embed>/Ui", 'input' => "/<input.*?\s.*?>/im", 'select' => "/<select.*?\s.*?>/im", 'textarea' => "/<textarea.*?\s.*?>/im"];

        self::$check_items['img'] = ['<img '];
        self::$check_title['img'] = TADTOOLS_CHK_IMG;
        self::$regular['img'] = ['img' => "/<\s*img\s+(.*)\/?\s?>/i"];

        self::$check_items['blockquote'] = ['<blockquote'];
        self::$check_title['blockquote'] = TADTOOLS_CHK_BLOCKQUOTE;
        self::$regular['blockquote'] = ['blockquote' => "/<blockquote(.*)<\/blockquote>/Ui"];

        self::$check_items['unable_tag'] = ['<font', '<center>', '<big>'];
        self::$check_title['unable_tag'] = TADTOOLS_CHK_UNABLE_TAG;
        self::$regular['unable_tag'] = ['empty_font' => "/(<font[^>]*><\/font>)/Uim", 'font' => "/(<font[^>]*>)|(<\/font>)/Uim", 'center' => "/<center>/Ui", 'big' => "/<big>/Ui"];

        self::$check_items['th'] = ['<th'];
        self::$check_title['th'] = TADTOOLS_CHK_TH;
        self::$regular['th'] = ['th' => "/<th(\s|>)(.*)>/Ui"];

        self::$check_items['a_blank'] = ['<a '];
        self::$check_title['a_blank'] = TADTOOLS_CHK_A_BLANK;
        self::$regular['a_blank'] = ['a_blank' => "/<a(.*)>(.*)<\/a>/Usi", 'same_alt' => "/<a.*>(.*)<\/a>/Usi"];

        self::$check_items['head_blank'] = ['<h'];
        self::$check_title['head_blank'] = TADTOOLS_CHK_HEAD_BLANK;
        self::$regular['head_blank'] = ['head_blank' => "/<h[1-6].*>(.*)<\/h[1-6]>/Ui"];

        self::$check_items['lang_zh_tw'] = ['zh-TW'];
        self::$check_title['lang_zh_tw'] = TADTOOLS_CHK_LANG_ZH_TW;
        self::$regular['lang_zh_tw'] = ['lang_zh_tw' => "/ lang=[\"|\']zh-TW[\"|\']/Uim"];

        return self::$$var;
    }

    public static function amend($content)
    {
        $regular = self::getVar('regular');
        foreach ($regular as $kind => $regular_rules) {
            foreach ($regular_rules as $func => $regular_rule) {
                $num = preg_match_all($regular_rule, $content, $matches);
                if (!empty($num)) {
                    $content = self::$func($content, $matches);
                }
            }
        }
        return $content;
    }

    public static function fontsize($v, $matches)
    {
        foreach ($matches[0] as $sk => $s) {
            if ($matches[2][$sk] == 'pt') {
                $new_val = round($matches[1][$sk] / 12, 2);
            } elseif ($matches[2][$sk] == 'px') {
                $new_val = round($matches[1][$sk] / 16, 2);
            } elseif ($matches[2][$sk] == '') {
                if (stripos($matches[1][$sk], '+') !== false) {
                    $num = $matches[1][$sk];
                    $new_val = 1 + 0.2 * $num;
                } elseif (stripos($matches[1][$sk], '-') !== false) {
                    $num = $matches[1][$sk];
                    $new_val = 1 - 0.2 * $num;
                } else {
                    $num = $matches[1][$sk] - 3;
                    $new_val = 1 + 0.2 * $num;
                }
            }
            $v = str_ireplace($s, "font-size: {$new_val}rem;", $v);
        }
        return $v;
    }

    public static function font_size_adjust($v, $matches)
    {
        foreach ($matches[0] as $old_str) {
            $v = str_ireplace($old_str, '', $v);
        }
        return $v;
    }

    public static function size($v, $matches)
    {
        foreach ($matches[0] as $sk => $s) {
            if ($matches[2][$sk] == 'pt') {
                $new_val = round($matches[1][$sk] / 12, 2);
            } elseif ($matches[2][$sk] == 'px') {
                $new_val = round($matches[1][$sk] / 16, 2);
            }
            $v = str_ireplace($s, "font: {$new_val}rem", $v);
        }
        return $v;
    }

    public static function iframe($v, $matches)
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<iframe ', "<iframe title=iframe ", $old_str);
                $v = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    public static function object($v, $matches)
    {
        if (stripos($v, ' title') === false) {
            $v = str_ireplace('<object ', "<object title=object ", $v);
            $v = str_ireplace('</object>', "<span class='sr-only'>some object</span></object>", $v);
        }

        return $v;
    }

    public static function applet($v, $matches)
    {
        if (stripos($v, ' title') === false) {
            $v = str_ireplace('<applet ', "<applet title=applet ", $v);
            $v = str_ireplace('</applet>', "<span class='sr-only'>some applet</span></applet>", $v);
        }

        return $v;
    }

    public static function embed($v, $matches)
    {
        if (stripos($v, ' title') === false) {
            $v = str_ireplace('<embed ', "<embed title=embed ", $v);
            $v = str_ireplace('</embed>', "<span class='sr-only'>some embed</span></embed>", $v);
        }
        if (stripos($v, 'noembed') === false) {
            $v = str_ireplace('</embed>', "<noembed>No way to embed content</noembed></embed>", $v);
        }

        return $v;
    }

    public static function input($v, $matches)
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title =') === false and stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<input', "<input title=input", $old_str);
                $v = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    public static function select($v, $matches)
    {

        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title =') === false and stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<select', "<select title=select", $old_str);
                $v = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    public static function textarea($v, $matches)
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title =') === false and stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<textarea ', "<textarea title=textarea ", $old_str);
                $v = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    public static function img($v, $matches)
    {
        foreach ($matches[0] as $old_img) {
            if (stripos($old_img, 'alt=') === false) {
                $old_img = str_ireplace("\r\n", " ", $old_img);
                $new_img = str_ireplace('<img ', "<img alt=img ", $old_img);
                $v = str_ireplace($old_img, $new_img, $v);
            }
        }

        return $v;
    }

    public static function blockquote($v, $matches)
    {
        if (stripos($v, ' xml:lang') === false) {
            $v = str_ireplace('<blockquote', "<blockquote xml:lang=zh", $v);
        }
        return $v;
    }

    public static function empty_font($v, $matches)
    {
        foreach ($matches[0] as $empty_str) {
            $v = str_ireplace($empty_str, '', $v);
        }

        return $v;
    }

    public static function font($v, $matches)
    {
        foreach ($matches[0] as $old_str) {
            $q = (stripos($old_str, '"') !== false) ? '"' : "'";
            $new_str = str_ireplace("'", '"', $old_str);
            $style = [];
            if ($new_str == '<font>') {
                $new_str = str_ireplace("<font>", "<span>", $new_str);
            } elseif (stripos($new_str, '<font ') !== false) {
                $re = '/face=[\"|\'](.*)[\"|\']/Uims';
                preg_match($re, $new_str, $face);
                if ($face[1]) {
                    $style[] = "font-family: {$face[1]};";
                }

                $re = '/color=[\"|\'](.*)[\"|\']/Uims';
                preg_match($re, $new_str, $color);
                if ($color[1]) {
                    $style[] = "color: {$color[1]};";
                }

                $re = '/size=[\"|\'](.*)[\"|\']/Uims';
                preg_match($re, $new_str, $size);
                if (stripos($size[1], '+') !== false) {
                    $num = substr($size[1], 1);
                    $new_size = 1 + 0.2 * $num;
                } elseif (stripos($size[1], '-') !== false) {
                    $num = substr($size[1], 1);
                    $new_size = 1 - 0.2 * $num;
                } else {
                    $num = $size[1] - 3;
                    $new_size = 1 + 0.2 * $num;
                }
                if ($size[1]) {
                    $style[] = "font-size: {$new_size}rem;";
                }

                $new_str = strtolower("<span style={$q}" . implode(' ', $style) . "{$q}>");

            } else {
                $new_str = str_ireplace("</font>", "</span>", $new_str);
            }

            $v = str_ireplace($old_str, $new_str, $v);
        }

        return $v;
    }

    public static function center($v, $matches)
    {
        if (stripos($v, '<center') !== false) {
            $v = str_ireplace('<center>', "<div style=\"text-align: center;\">", $v);
            $v = str_ireplace('</center>', "</div>", $v);
        }
        return $v;
    }

    public static function big($v, $matches)
    {
        if (stripos($v, '<big') !== false) {
            $v = str_ireplace('<big>', "<span style=\"font-size: 1.2rem;\">", $v);
            $v = str_ireplace('</big>', "</span>", $v);
        }
        return $v;
    }

    public static function th($v, $matches)
    {
        if (stripos($v, '<th scope') === false && (stripos($v, '<th>') !== false || stripos($v, '<th ') !== false)) {
            $v = str_ireplace('<th>', "<td>", $v);
            $v = str_ireplace('<th ', "<td ", $v);
            $v = str_ireplace('</th>', "</td>", $v);
        }
        return $v;
    }

    public static function a_blank($v, $matches)
    {
        $fix = false;
        foreach ($matches[2] as $key => $content_in_tag) {
            if (stripos($content_in_tag, '<{$') === false and stripos($matches[1][$key], 'href') !== false and empty(trim(strip_tags($content_in_tag)))) {
                $old = $matches[0][$key];
                $linkto = str_ireplace(['href=', '"', "'", 'target=', '_blank', '_self'], '', $matches[1][$key]);
                $new = str_ireplace('</a>', "<span class=sr-only>link to $linkto</span></a>", $old);
                $v = str_ireplace($old, $new, $v);
            }
        }
        return $v;
    }

    public static function same_alt($v, $matches)
    {
        foreach ($matches[1] as $key => $content_in_tag) {
            preg_match_all("/(.*)<img.*alt=[\"|\'](.*?)[\"|\'].*?[\"|\']?>(.*)/is", $content_in_tag, $match);
            $alt = strip_tags(str_ireplace('&nbsp;', '', $match[2][0]));
            $txt1 = strip_tags(str_ireplace('&nbsp;', '', $match[1][0]));
            $txt2 = strip_tags(str_ireplace('&nbsp;', '', $match[3][0]));
            if (!empty($match[2][0]) and stripos($match[2][0], '<{$') === false and ($alt == $txt1 or $alt == $txt2)) {
                $old = $matches[0][$key];
                $new = str_ireplace(["alt='{$match[2][0]}'", 'alt="' . $match[2][0] . '"'], ["alt='image of {$alt}'", 'alt="image of ' . $alt . '"'], $old);
                $v = str_ireplace($old, $new, $v);
            }
        }
        return $v;
    }

    public static function head_blank($v, $matches)
    {
        foreach ($matches[1] as $key => $content_in_tag) {
            if (stripos($content_in_tag, '<{$') === false and empty(trim(strip_tags($content_in_tag)))) {
                $old = $matches[0][$key];
                $new = str_ireplace('</h', "<span class=sr-only>empty head</span></h", $old);
                $v = str_ireplace($old, $new, $v);
            }
        }
        return $v;
    }

    public static function lang_zh_tw($v, $matches)
    {
        foreach ($matches[0] as $key => $content_in_tag) {
            $old = $content_in_tag;
            $new = '';
            $v = str_ireplace($old, $new, $v);
        }
        return $v;
    }

}

/*

use XoopsModules\Tadtools\Wcag;

$check_items = Wcag::getVar('check_items');
$check_title= Wcag::getVar('check_title');
$regular= Wcag::getVar('regular');

$content= Wcag::amend($content);

 */

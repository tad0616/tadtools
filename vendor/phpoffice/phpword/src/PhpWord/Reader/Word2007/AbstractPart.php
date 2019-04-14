<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2016 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Reader\Word2007;

use PhpOffice\Common\XMLReader;
use PhpOffice\PhpWord\PhpWord;

/**
 * Abstract part reader
 *
 * This class is inherited by ODText reader
 *
 * @since 0.10.0
 */
abstract class AbstractPart
{
    /**
     * Conversion method
     *
     * @const int
     */
    const READ_VALUE = 'attributeValue';            // Read attribute value
    const READ_EQUAL = 'attributeEquals';           // Read `true` when attribute value equals specified value
    const READ_TRUE = 'attributeTrue';             // Read `true` when element exists
    const READ_FALSE = 'attributeFalse';            // Read `false` when element exists
    const READ_SIZE = 'attributeMultiplyByTwo';    // Read special attribute value for Font::$size

    /**
     * Document file
     *
     * @var string
     */
    protected $docFile;

    /**
     * XML file
     *
     * @var string
     */
    protected $xmlFile;

    /**
     * Part relationships
     *
     * @var array
     */
    protected $rels = [];

    /**
     * Read part.
     */
    abstract public function read(PhpWord $phpWord);

    /**
     * Create new instance
     *
     * @param string $docFile
     * @param string $xmlFile
     */
    public function __construct($docFile, $xmlFile)
    {
        $this->docFile = $docFile;
        $this->xmlFile = $xmlFile;
    }

    /**
     * Set relationships.
     *
     * @param array $value
     * @return void
     */
    public function setRels($value)
    {
        $this->rels = $value;
    }

    /**
     * Read w:p.
     *
     * @param mixed $parent
     * @param string $docPart
     * @return void
     *
     * @todo Get font style for preserve text
     */
    protected function readParagraph(XMLReader $xmlReader, \DOMElement $domNode, $parent, $docPart = 'document')
    {
        // Paragraph style
        $paragraphStyle = null;
        $headingMatches = [];
        if ($xmlReader->elementExists('w:pPr', $domNode)) {
            $paragraphStyle = $this->readParagraphStyle($xmlReader, $domNode);
            if (is_array($paragraphStyle) && isset($paragraphStyle['styleName'])) {
                preg_match('/Heading(\d)/', $paragraphStyle['styleName'], $headingMatches);
            }
        }

        // PreserveText
        if ($xmlReader->elementExists('w:r/w:instrText', $domNode)) {
            $ignoreText = false;
            $textContent = '';
            $fontStyle = $this->readFontStyle($xmlReader, $domNode);
            $nodes = $xmlReader->getElements('w:r', $domNode);
            foreach ($nodes as $node) {
                $instrText = $xmlReader->getValue('w:instrText', $node);
                if ($xmlReader->elementExists('w:fldChar', $node)) {
                    $fldCharType = $xmlReader->getAttribute('w:fldCharType', $node, 'w:fldChar');
                    if ('begin' == $fldCharType) {
                        $ignoreText = true;
                    } elseif ('end' == $fldCharType) {
                        $ignoreText = false;
                    }
                }
                if (null !== $instrText) {
                    $textContent .= '{' . $instrText . '}';
                } else {
                    if (false === $ignoreText) {
                        $textContent .= $xmlReader->getValue('w:t', $node);
                    }
                }
            }
            $parent->addPreserveText($textContent, $fontStyle, $paragraphStyle);

        // List item
        } elseif ($xmlReader->elementExists('w:pPr/w:numPr', $domNode)) {
            $textContent = '';
            $numId = $xmlReader->getAttribute('w:val', $domNode, 'w:pPr/w:numPr/w:numId');
            $levelId = $xmlReader->getAttribute('w:val', $domNode, 'w:pPr/w:numPr/w:ilvl');
            $nodes = $xmlReader->getElements('w:r', $domNode);
            foreach ($nodes as $node) {
                $textContent .= $xmlReader->getValue('w:t', $node);
            }
            $parent->addListItem($textContent, $levelId, null, "PHPWordList{$numId}", $paragraphStyle);

        // Heading
        } elseif (!empty($headingMatches)) {
            $textContent = '';
            $nodes = $xmlReader->getElements('w:r', $domNode);
            foreach ($nodes as $node) {
                $textContent .= $xmlReader->getValue('w:t', $node);
            }
            $parent->addTitle($textContent, $headingMatches[1]);

        // Text and TextRun
        } else {
            $runCount = $xmlReader->countElements('w:r', $domNode);
            $linkCount = $xmlReader->countElements('w:hyperlink', $domNode);
            $runLinkCount = $runCount + $linkCount;
            if (0 == $runLinkCount) {
                $parent->addTextBreak(null, $paragraphStyle);
            } else {
                $nodes = $xmlReader->getElements('*', $domNode);
                foreach ($nodes as $node) {
                    $this->readRun(
                        $xmlReader,
                        $node,
                        ($runLinkCount > 1) ? $parent->addTextRun($paragraphStyle) : $parent,
                        $docPart,
                        $paragraphStyle
                    );
                }
            }
        }
    }

    /**
     * Read w:r.
     *
     * @param mixed $parent
     * @param string $docPart
     * @param mixed $paragraphStyle
     * @return void
     *
     * @todo Footnote paragraph style
     */
    protected function readRun(XMLReader $xmlReader, \DOMElement $domNode, $parent, $docPart, $paragraphStyle = null)
    {
        if (!in_array($domNode->nodeName, ['w:r', 'w:hyperlink'], true)) {
            return;
        }
        $fontStyle = $this->readFontStyle($xmlReader, $domNode);

        // Link
        if ('w:hyperlink' == $domNode->nodeName) {
            $rId = $xmlReader->getAttribute('r:id', $domNode);
            $textContent = $xmlReader->getValue('w:r/w:t', $domNode);
            $target = $this->getMediaTarget($docPart, $rId);
            if (null !== $target) {
                $parent->addLink($target, $textContent, $fontStyle, $paragraphStyle);
            }
        } else {
            // Footnote
            if ($xmlReader->elementExists('w:footnoteReference', $domNode)) {
                $parent->addFootnote();

            // Endnote
            } elseif ($xmlReader->elementExists('w:endnoteReference', $domNode)) {
                $parent->addEndnote();

            // Image
            } elseif ($xmlReader->elementExists('w:pict', $domNode)) {
                $rId = $xmlReader->getAttribute('r:id', $domNode, 'w:pict/v:shape/v:imagedata');
                $target = $this->getMediaTarget($docPart, $rId);
                if (null !== $target) {
                    $imageSource = "zip://{$this->docFile}#{$target}";
                    $parent->addImage($imageSource);
                }

                // Object
            } elseif ($xmlReader->elementExists('w:object', $domNode)) {
                $rId = $xmlReader->getAttribute('r:id', $domNode, 'w:object/o:OLEObject');
                // $rIdIcon = $xmlReader->getAttribute('r:id', $domNode, 'w:object/v:shape/v:imagedata');
                $target = $this->getMediaTarget($docPart, $rId);
                if (null !== $target) {
                    $textContent = "<Object: {$target}>";
                    $parent->addText($textContent, $fontStyle, $paragraphStyle);
                }

                // TextRun
            } else {
                $textContent = $xmlReader->getValue('w:t', $domNode);
                $parent->addText($textContent, $fontStyle, $paragraphStyle);
            }
        }
    }

    /**
     * Read w:tbl.
     *
     * @param mixed $parent
     * @param string $docPart
     * @return void
     */
    protected function readTable(XMLReader $xmlReader, \DOMElement $domNode, $parent, $docPart = 'document')
    {
        // Table style
        $tblStyle = null;
        if ($xmlReader->elementExists('w:tblPr', $domNode)) {
            $tblStyle = $this->readTableStyle($xmlReader, $domNode);
        }

        /** @var \PhpOffice\PhpWord\Element\Table $table Type hint */
        $table = $parent->addTable($tblStyle);
        $tblNodes = $xmlReader->getElements('*', $domNode);
        foreach ($tblNodes as $tblNode) {
            if ('w:tblGrid' == $tblNode->nodeName) { // Column
                // @todo Do something with table columns
            } elseif ('w:tr' == $tblNode->nodeName) { // Row
                $rowHeight = $xmlReader->getAttribute('w:val', $tblNode, 'w:trPr/w:trHeight');
                $rowHRule = $xmlReader->getAttribute('w:hRule', $tblNode, 'w:trPr/w:trHeight');
                $rowHRule = 'exact' == $rowHRule ? true : false;
                $rowStyle = [
                    'tblHeader' => $xmlReader->elementExists('w:trPr/w:tblHeader', $tblNode),
                    'cantSplit' => $xmlReader->elementExists('w:trPr/w:cantSplit', $tblNode),
                    'exactHeight' => $rowHRule,
                ];

                $row = $table->addRow($rowHeight, $rowStyle);
                $rowNodes = $xmlReader->getElements('*', $tblNode);
                foreach ($rowNodes as $rowNode) {
                    if ('w:trPr' == $rowNode->nodeName) { // Row style
                        // @todo Do something with row style
                    } elseif ('w:tc' == $rowNode->nodeName) { // Cell
                        $cellWidth = $xmlReader->getAttribute('w:w', $rowNode, 'w:tcPr/w:tcW');
                        $cellStyle = null;
                        $cellStyleNode = $xmlReader->getElement('w:tcPr', $rowNode);
                        if (null !== $cellStyleNode) {
                            $cellStyle = $this->readCellStyle($xmlReader, $cellStyleNode);
                        }

                        $cell = $row->addCell($cellWidth, $cellStyle);
                        $cellNodes = $xmlReader->getElements('*', $rowNode);
                        foreach ($cellNodes as $cellNode) {
                            if ('w:p' == $cellNode->nodeName) { // Paragraph
                                $this->readParagraph($xmlReader, $cellNode, $cell, $docPart);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Read w:pPr.
     *
     * @return array|null
     */
    protected function readParagraphStyle(XMLReader $xmlReader, \DOMElement $domNode)
    {
        if (!$xmlReader->elementExists('w:pPr', $domNode)) {
            return null;
        }

        $styleNode = $xmlReader->getElement('w:pPr', $domNode);
        $styleDefs = [
            'styleName' => [self::READ_VALUE, 'w:pStyle'],
            'alignment' => [self::READ_VALUE, 'w:jc'],
            'basedOn' => [self::READ_VALUE, 'w:basedOn'],
            'next' => [self::READ_VALUE, 'w:next'],
            'indent' => [self::READ_VALUE, 'w:ind', 'w:left'],
            'hanging' => [self::READ_VALUE, 'w:ind', 'w:hanging'],
            'spaceAfter' => [self::READ_VALUE, 'w:spacing', 'w:after'],
            'spaceBefore' => [self::READ_VALUE, 'w:spacing', 'w:before'],
            'widowControl' => [self::READ_FALSE, 'w:widowControl'],
            'keepNext' => [self::READ_TRUE,  'w:keepNext'],
            'keepLines' => [self::READ_TRUE,  'w:keepLines'],
            'pageBreakBefore' => [self::READ_TRUE,  'w:pageBreakBefore'],
        ];

        return $this->readStyleDefs($xmlReader, $styleNode, $styleDefs);
    }

    /**
     * Read w:rPr
     *
     * @return array|null
     */
    protected function readFontStyle(XMLReader $xmlReader, \DOMElement $domNode)
    {
        if (null === $domNode) {
            return null;
        }
        // Hyperlink has an extra w:r child
        if ('w:hyperlink' == $domNode->nodeName) {
            $domNode = $xmlReader->getElement('w:r', $domNode);
        }
        if (!$xmlReader->elementExists('w:rPr', $domNode)) {
            return null;
        }

        $styleNode = $xmlReader->getElement('w:rPr', $domNode);
        $styleDefs = [
            'styleName' => [self::READ_VALUE, 'w:rStyle'],
            'name' => [self::READ_VALUE, 'w:rFonts', 'w:ascii'],
            'hint' => [self::READ_VALUE, 'w:rFonts', 'w:hint'],
            'size' => [self::READ_SIZE,  'w:sz'],
            'color' => [self::READ_VALUE, 'w:color'],
            'underline' => [self::READ_VALUE, 'w:u'],
            'bold' => [self::READ_TRUE,  'w:b'],
            'italic' => [self::READ_TRUE,  'w:i'],
            'strikethrough' => [self::READ_TRUE,  'w:strike'],
            'doubleStrikethrough' => [self::READ_TRUE,  'w:dstrike'],
            'smallCaps' => [self::READ_TRUE,  'w:smallCaps'],
            'allCaps' => [self::READ_TRUE,  'w:caps'],
            'superScript' => [self::READ_EQUAL, 'w:vertAlign', 'w:val', 'superscript'],
            'subScript' => [self::READ_EQUAL, 'w:vertAlign', 'w:val', 'subscript'],
            'fgColor' => [self::READ_VALUE, 'w:highlight'],
            'rtl' => [self::READ_TRUE,  'w:rtl'],
        ];

        return $this->readStyleDefs($xmlReader, $styleNode, $styleDefs);
    }

    /**
     * Read w:tblPr
     *
     * @return string|array|null
     * @todo Capture w:tblStylePr w:type="firstRow"
     */
    protected function readTableStyle(XMLReader $xmlReader, \DOMElement $domNode)
    {
        $style = null;
        $margins = ['top', 'left', 'bottom', 'right'];
        $borders = $margins + ['insideH', 'insideV'];

        if ($xmlReader->elementExists('w:tblPr', $domNode)) {
            if ($xmlReader->elementExists('w:tblPr/w:tblStyle', $domNode)) {
                $style = $xmlReader->getAttribute('w:val', $domNode, 'w:tblPr/w:tblStyle');
            } else {
                $styleNode = $xmlReader->getElement('w:tblPr', $domNode);
                $styleDefs = [];
                foreach ($margins as $side) {
                    $ucfSide = ucfirst($side);
                    $styleDefs["cellMargin$ucfSide"] = [self::READ_VALUE, "w:tblCellMar/w:$side", 'w:w'];
                }
                foreach ($borders as $side) {
                    $ucfSide = ucfirst($side);
                    $styleDefs["border{$ucfSide}Size"] = [self::READ_VALUE, "w:tblBorders/w:$side", 'w:sz'];
                    $styleDefs["border{$ucfSide}Color"] = [self::READ_VALUE, "w:tblBorders/w:$side", 'w:color'];
                }
                $style = $this->readStyleDefs($xmlReader, $styleNode, $styleDefs);
            }
        }

        return $style;
    }

    /**
     * Read w:tcPr
     *
     * @return array
     */
    private function readCellStyle(XMLReader $xmlReader, \DOMElement $domNode)
    {
        $styleDefs = [
            'valign' => [self::READ_VALUE, 'w:vAlign'],
            'textDirection' => [self::READ_VALUE, 'w:textDirection'],
            'gridSpan' => [self::READ_VALUE, 'w:gridSpan'],
            'vMerge' => [self::READ_VALUE, 'w:vMerge'],
            'bgColor' => [self::READ_VALUE, 'w:shd/w:fill'],
        ];

        return $this->readStyleDefs($xmlReader, $domNode, $styleDefs);
    }

    /**
     * Read style definition
     *
     * @param \DOMElement $parentNode
     * @param array $styleDefs
     * @ignoreScrutinizerPatch
     * @return array
     */
    protected function readStyleDefs(XMLReader $xmlReader, \DOMElement $parentNode = null, $styleDefs = [])
    {
        $styles = [];

        foreach ($styleDefs as $styleProp => $styleVal) {
            @list($method, $element, $attribute, $expected) = $styleVal;

            if ($xmlReader->elementExists($element, $parentNode)) {
                $node = $xmlReader->getElement($element, $parentNode);

                // Use w:val as default if no attribute assigned
                $attribute = (null === $attribute) ? 'w:val' : $attribute;
                $attributeValue = $xmlReader->getAttribute($attribute, $node);

                $styleValue = $this->readStyleDef($method, $attributeValue, $expected);
                if (null !== $styleValue) {
                    $styles[$styleProp] = $styleValue;
                }
            }
        }

        return $styles;
    }

    /**
     * Return style definition based on conversion method
     *
     * @param string $method
     * @ignoreScrutinizerPatch
     * @param mixed $attributeValue
     * @param mixed $expected
     * @return mixed
     */
    private function readStyleDef($method, $attributeValue, $expected)
    {
        $style = $attributeValue;

        if (self::READ_SIZE == $method) {
            $style = $attributeValue / 2;
        } elseif (self::READ_TRUE == $method) {
            $style = true;
        } elseif (self::READ_FALSE == $method) {
            $style = false;
        } elseif (self::READ_EQUAL == $method) {
            $style = $attributeValue == $expected;
        }

        return $style;
    }

    /**
     * Returns the target of image, object, or link as stored in ::readMainRels
     *
     * @param string $docPart
     * @param string $rId
     * @return string|null
     */
    private function getMediaTarget($docPart, $rId)
    {
        $target = null;

        if (isset($this->rels[$docPart]) && isset($this->rels[$docPart][$rId])) {
            $target = $this->rels[$docPart][$rId]['target'];
        }

        return $target;
    }
}

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

namespace PhpOffice\PhpWord\Writer\Word2007\Style;

/**
 * Font style writer
 *
 * @since 0.10.0
 */
class Font extends AbstractStyle
{
    /**
     * Is inline in element
     *
     * @var bool
     */
    private $isInline = false;

    /**
     * Write style.
     *
     * @return void
     */
    public function write()
    {
        $xmlWriter = $this->getXmlWriter();

        $isStyleName = $this->isInline && null !== $this->style && is_string($this->style);
        if ($isStyleName) {
            $xmlWriter->startElement('w:rPr');
            $xmlWriter->startElement('w:rStyle');
            $xmlWriter->writeAttribute('w:val', $this->style);
            $xmlWriter->endElement();
            $xmlWriter->endElement();
        } else {
            $this->writeStyle();
        }
    }

    /**
     * Write full style.
     *
     * @return void
     */
    private function writeStyle()
    {
        $style = $this->getStyle();
        if (!$style instanceof \PhpOffice\PhpWord\Style\Font) {
            return;
        }
        $xmlWriter = $this->getXmlWriter();

        $xmlWriter->startElement('w:rPr');

        // Style name
        if (true === $this->isInline) {
            $styleName = $style->getStyleName();
            $xmlWriter->writeElementIf(null !== $styleName, 'w:rStyle', 'w:val', $styleName);
        }

        // Font name/family
        $font = $style->getName();
        $hint = $style->getHint();
        if (null !== $font) {
            $xmlWriter->startElement('w:rFonts');
            $xmlWriter->writeAttribute('w:ascii', $font);
            $xmlWriter->writeAttribute('w:hAnsi', $font);
            $xmlWriter->writeAttribute('w:eastAsia', $font);
            $xmlWriter->writeAttribute('w:cs', $font);
            $xmlWriter->writeAttributeIf(null !== $hint, 'w:hint', $hint);
            $xmlWriter->endElement();
        }

        // Color
        $color = $style->getColor();
        $xmlWriter->writeElementIf(null !== $color, 'w:color', 'w:val', $color);

        // Size
        $size = $style->getSize();
        $xmlWriter->writeElementIf(null !== $size, 'w:sz', 'w:val', $size * 2);
        $xmlWriter->writeElementIf(null !== $size, 'w:szCs', 'w:val', $size * 2);

        // Bold, italic
        $xmlWriter->writeElementIf($style->isBold(), 'w:b');
        $xmlWriter->writeElementIf($style->isItalic(), 'w:i');
        $xmlWriter->writeElementIf($style->isItalic(), 'w:iCs');

        // Strikethrough, double strikethrough
        $xmlWriter->writeElementIf($style->isStrikethrough(), 'w:strike');
        $xmlWriter->writeElementIf($style->isDoubleStrikethrough(), 'w:dstrike');

        // Small caps, all caps
        $xmlWriter->writeElementIf($style->isSmallCaps(), 'w:smallCaps');
        $xmlWriter->writeElementIf($style->isAllCaps(), 'w:caps');

        // Underline
        $xmlWriter->writeElementIf('none' != $style->getUnderline(), 'w:u', 'w:val', $style->getUnderline());

        // Foreground-Color
        $xmlWriter->writeElementIf(null !== $style->getFgColor(), 'w:highlight', 'w:val', $style->getFgColor());

        // Superscript/subscript
        $xmlWriter->writeElementIf($style->isSuperScript(), 'w:vertAlign', 'w:val', 'superscript');
        $xmlWriter->writeElementIf($style->isSubScript(), 'w:vertAlign', 'w:val', 'subscript');

        // Spacing
        $xmlWriter->writeElementIf(null !== $style->getScale(), 'w:w', 'w:val', $style->getScale());
        $xmlWriter->writeElementIf(null !== $style->getSpacing(), 'w:spacing', 'w:val', $style->getSpacing());
        $xmlWriter->writeElementIf(null !== $style->getKerning(), 'w:kern', 'w:val', $style->getKerning() * 2);

        // Background-Color
        $shading = $style->getShading();
        if (null !== $shading) {
            $styleWriter = new Shading($xmlWriter, $shading);
            $styleWriter->write();
        }

        // RTL
        if (true === $this->isInline) {
            $styleName = $style->getStyleName();
            $xmlWriter->writeElementIf(null === $styleName && $style->isRTL(), 'w:rtl');
        }

        $xmlWriter->endElement();
    }

    /**
     * Set is inline.
     *
     * @param bool $value
     * @return void
     */
    public function setIsInline($value)
    {
        $this->isInline = $value;
    }
}

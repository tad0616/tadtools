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

namespace PhpOffice\PhpWord\Writer\Word2007\Part;

/**
 * Word2007 settings part writer: word/settings.xml
 *
 * @link http://www.schemacentral.com/sc/ooxml/t-w_CT_Settings.html
 */
class Settings extends AbstractPart
{
    /**
     * Settings value
     *
     * @var array
     */
    private $settings = [];

    /**
     * Write part
     *
     * @return string
     */
    public function write()
    {
        $this->getSettings();

        $xmlWriter = $this->getXmlWriter();

        $xmlWriter->startDocument('1.0', 'UTF-8', 'yes');
        $xmlWriter->startElement('w:settings');
        $xmlWriter->writeAttribute('xmlns:r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');
        $xmlWriter->writeAttribute('xmlns:w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $xmlWriter->writeAttribute('xmlns:m', 'http://schemas.openxmlformats.org/officeDocument/2006/math');
        $xmlWriter->writeAttribute('xmlns:sl', 'http://schemas.openxmlformats.org/schemaLibrary/2006/main');
        $xmlWriter->writeAttribute('xmlns:o', 'urn:schemas-microsoft-com:office:office');
        $xmlWriter->writeAttribute('xmlns:v', 'urn:schemas-microsoft-com:vml');
        $xmlWriter->writeAttribute('xmlns:w10', 'urn:schemas-microsoft-com:office:word');

        foreach ($this->settings as $settingKey => $settingValue) {
            $this->writeSetting($xmlWriter, $settingKey, $settingValue);
        }

        $xmlWriter->endElement(); // w:settings

        return $xmlWriter->getData();
    }

    /**
     * Write indivual setting, recursive to any child settings.
     *
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param string $settingKey
     * @param array|string $settingValue
     * @return void
     */
    protected function writeSetting($xmlWriter, $settingKey, $settingValue)
    {
        if ('' == $settingValue) {
            $xmlWriter->writeElement($settingKey);
        } else {
            $xmlWriter->startElement($settingKey);

            /** @var array $settingValue Type hint */
            foreach ($settingValue as $childKey => $childValue) {
                if ('@attributes' == $childKey) {
                    foreach ($childValue as $key => $val) {
                        $xmlWriter->writeAttribute($key, $val);
                    }
                } else {
                    $this->writeSetting($xmlWriter, $childKey, $childValue);
                }
            }
            $xmlWriter->endElement();
        }
    }

    /**
     * Get settings.
     *
     * @return void
     */
    private function getSettings()
    {
        // Default settings
        $this->settings = [
            'w:zoom' => ['@attributes' => ['w:percent' => '100']],
            'w:defaultTabStop' => ['@attributes' => ['w:val' => '708']],
            'w:hyphenationZone' => ['@attributes' => ['w:val' => '425']],
            'w:characterSpacingControl' => ['@attributes' => ['w:val' => 'doNotCompress']],
            'w:themeFontLang' => ['@attributes' => ['w:val' => 'en-US']],
            'w:decimalSymbol' => ['@attributes' => ['w:val' => '.']],
            'w:listSeparator' => ['@attributes' => ['w:val' => ';']],
            'w:compat' => '',
            'm:mathPr' => [
                'm:mathFont' => ['@attributes' => ['m:val' => 'Cambria Math']],
                'm:brkBin' => ['@attributes' => ['m:val' => 'before']],
                'm:brkBinSub' => ['@attributes' => ['m:val' => '--']],
                'm:smallFrac' => ['@attributes' => ['m:val' => 'off']],
                'm:dispDef' => '',
                'm:lMargin' => ['@attributes' => ['m:val' => '0']],
                'm:rMargin' => ['@attributes' => ['m:val' => '0']],
                'm:defJc' => ['@attributes' => ['m:val' => 'centerGroup']],
                'm:wrapIndent' => ['@attributes' => ['m:val' => '1440']],
                'm:intLim' => ['@attributes' => ['m:val' => 'subSup']],
                'm:naryLim' => ['@attributes' => ['m:val' => 'undOvr']],
            ],
            'w:clrSchemeMapping' => [
                '@attributes' => [
                    'w:bg1' => 'light1',
                    'w:t1' => 'dark1',
                    'w:bg2' => 'light2',
                    'w:t2' => 'dark2',
                    'w:accent1' => 'accent1',
                    'w:accent2' => 'accent2',
                    'w:accent3' => 'accent3',
                    'w:accent4' => 'accent4',
                    'w:accent5' => 'accent5',
                    'w:accent6' => 'accent6',
                    'w:hyperlink' => 'hyperlink',
                    'w:followedHyperlink' => 'followedHyperlink',
                ],
            ],
        ];

        // Other settings
        $this->getProtection();
        $this->getCompatibility();
    }

    /**
     * Get protection settings.
     *
     * @return void
     */
    private function getProtection()
    {
        $protection = $this->getParentWriter()->getPhpWord()->getProtection();
        if (null !== $protection->getEditing()) {
            $this->settings['w:documentProtection'] = [
                '@attributes' => [
                    'w:enforcement' => 1,
                    'w:edit' => $protection->getEditing(),
                ],
            ];
        }
    }

    /**
     * Get compatibility setting.
     *
     * @return void
     */
    private function getCompatibility()
    {
        $compatibility = $this->getParentWriter()->getPhpWord()->getCompatibility();
        if (null !== $compatibility->getOoxmlVersion()) {
            $this->settings['w:compat']['w:compatSetting'] = ['@attributes' => [
                'w:name' => 'compatibilityMode',
                'w:uri' => 'http://schemas.microsoft.com/office/word',
                'w:val' => $compatibility->getOoxmlVersion(),
            ]];
        }
    }
}

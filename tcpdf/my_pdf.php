<?php
require 'tcpdf.php';

class my_pdf extends TCPDF
{
    public $widths;
    public $aligns;
    public $fontSizes = 9;
    public $showfonts;
    public $line_height = 5;

    public function SetLineHeight($lh)
    {
        //Set the array of column font-size
        $this->line_height = $lh;
    }

    public function SetShowFonts($f)
    {
        //Set the array of column font-size
        $this->showfonts = $f;
    }

    public function SetFontSizes($s)
    {
        //Set the array of column font-size
        $this->fontSizes = $s;
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    public function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, 1 + (int) ($this->GetStringWidth($data[$i]) / ($this->widths[$i] - 2 * $this->cMargin)));
        }

        $h = $this->line_height * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $s = $this->fontSizes[$i];
            $f = $this->showfonts[$i];
            if (empty($f)) {
                $f = "droidsansfallback";
            }
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text

            $this->SetFont($f, '', $s);

            $this->MultiCell($w, $this->line_height, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    public function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s    = str_replace("\r", '', $txt);
        $nb   = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i   = 0;
        $j   = 0;
        $l   = 0;
        $nl  = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j   = $i;
                $l   = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }

            //$l+=$cw[$c];

            if (!$cw[$c]) {
                $l += 500;
            } else {
                $l + $cw[$c];
            }

            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }

                $sep = -1;
                $j   = $i;
                $l   = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

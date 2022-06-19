<?php
/**
 *--------------------------------------------------------------------
 *
 * Base class for Barcode 1D and 2D
 *
 *--------------------------------------------------------------------
 * @author  Akhtar Khan <er.akhtarkhan@gmail.com>
 * @link http://www.codeitnow.in
 * @package https://github.com/codeitnowin/barcode-generator   
 */
namespace CodeItNow\BarcodeBundle\Generator;
use CodeItNow\BarcodeBundle\Generator\CINColor;
use CodeItNow\BarcodeBundle\Generator\CINLabel;
use CodeItNow\BarcodeBundle\Generator\CINArgumentException;
use CodeItNow\BarcodeBundle\Generator\CINDrawException;

abstract class CINBarcode {
    const COLOR_BG = 0;
    const COLOR_FG = 1;

    protected $colorFg, $colorBg;       // Color Foreground, Barckground
    protected $scale;                   // Scale of the graphic, default: 1
    protected $offsetX, $offsetY;       // Position where to start the drawing
    protected $labels = array();        // Array of CINLabel
    protected $pushLabel = array(0, 0); // Push for the label, left and top

    /**
     * Constructor.
     */
    protected function __construct() {
        $this->setOffsetX(0);
        $this->setOffsetY(0);
        $this->setForegroundColor(0x000000);
        $this->setBackgroundColor(0xffffff);
        $this->setScale(1);
    }

    /**
     * Parses the text before displaying it.
     *
     * @param mixed $text
     */
    public function parse($text) {
    }

    /**
     * Gets the foreground color of the barcode.
     *
     * @return CINColor
     */
    public function getForegroundColor() {
        return $this->colorFg;
    }

    /**
     * Sets the foreground color of the barcode. It could be a CINColor
     * value or simply a language code (white, black, yellow...) or hex value.
     *
     * @param mixed $code
     */
    public function setForegroundColor($code) {
        if ($code instanceof CINColor) {
            $this->colorFg = $code;
        } else {
            $this->colorFg = new CINColor($code);
        }
    }

    /**
     * Gets the background color of the barcode.
     *
     * @return CINColor
     */
    public function getBackgroundColor() {
        return $this->colorBg;
    }

    /**
     * Sets the background color of the barcode. It could be a CINColor
     * value or simply a language code (white, black, yellow...) or hex value.
     *
     * @param mixed $code
     */
    public function setBackgroundColor($code) {
        if ($code instanceof CINColor) {
            $this->colorBg = $code;
        } else {
            $this->colorBg = new CINColor($code);
        }

        foreach ($this->labels as $label) {
            $label->setBackgroundColor($this->colorBg);
        }
    }

    /**
     * Sets the color.
     *
     * @param mixed $fg
     * @param mixed $bg
     */
    public function setColor($fg, $bg) {
        $this->setForegroundColor($fg);
        $this->setBackgroundColor($bg);
    }

    /**
     * Gets the scale of the barcode.
     *
     * @return int
     */
    public function getScale() {
        return $this->scale;
    }

    /**
     * Sets the scale of the barcode in pixel.
     * If the scale is lower than 1, an exception is raised.
     *
     * @param int $scale
     */
    public function setScale($scale) {
        $scale = intval($scale);
        if ($scale <= 0) {
            throw new CINArgumentException('The scale must be larger than 0.', 'scale');
        }

        $this->scale = $scale;
    }

    /**
     * Abstract method that draws the barcode on the resource.
     *
     * @param resource $im
     */
    public abstract function draw($im);

    /**
     * Returns the maximal size of a barcode.
     * [0]->width
     * [1]->height
     *
     * @param int $w
     * @param int $h
     * @return int[]
     */
    public function getDimension($w, $h) {
        $labels = $this->getBiggestLabels(false);
        $pixelsAround = array(0, 0, 0, 0); // TRBL
        if (isset($labels[CINLabel::POSITION_TOP])) {
            $dimension = $labels[CINLabel::POSITION_TOP]->getDimension();
            $pixelsAround[0] += $dimension[1];
        }

        if (isset($labels[CINLabel::POSITION_RIGHT])) {
            $dimension = $labels[CINLabel::POSITION_RIGHT]->getDimension();
            $pixelsAround[1] += $dimension[0];
        }

        if (isset($labels[CINLabel::POSITION_BOTTOM])) {
            $dimension = $labels[CINLabel::POSITION_BOTTOM]->getDimension();
            $pixelsAround[2] += $dimension[1];
        }

        if (isset($labels[CINLabel::POSITION_LEFT])) {
            $dimension = $labels[CINLabel::POSITION_LEFT]->getDimension();
            $pixelsAround[3] += $dimension[0];
        }

        $finalW = ($w + $this->offsetX) * $this->scale;
        $finalH = ($h + $this->offsetY) * $this->scale;

        // This section will check if a top/bottom label is too big for its width and left/right too big for its height
        $reversedLabels = $this->getBiggestLabels(true);
        foreach ($reversedLabels as $label) {
            $dimension = $label->getDimension();
            $alignment = $label->getAlignment();
            if ($label->getPosition() === CINLabel::POSITION_LEFT || $label->getPosition() === CINLabel::POSITION_RIGHT) {
                if ($alignment === CINLabel::ALIGN_TOP) {
                    $pixelsAround[2] = max($pixelsAround[2], $dimension[1] - $finalH);
                } elseif ($alignment === CINLabel::ALIGN_CENTER) {
                    $temp = ceil(($dimension[1] - $finalH) / 2);
                    $pixelsAround[0] = max($pixelsAround[0], $temp);
                    $pixelsAround[2] = max($pixelsAround[2], $temp);
                } elseif ($alignment === CINLabel::ALIGN_BOTTOM) {
                    $pixelsAround[0] = max($pixelsAround[0], $dimension[1] - $finalH);
                }
            } else {
                if ($alignment === CINLabel::ALIGN_LEFT) {
                    $pixelsAround[1] = max($pixelsAround[1], $dimension[0] - $finalW);
                } elseif ($alignment === CINLabel::ALIGN_CENTER) {
                    $temp = ceil(($dimension[0] - $finalW) / 2);
                    $pixelsAround[1] = max($pixelsAround[1], $temp);
                    $pixelsAround[3] = max($pixelsAround[3], $temp);
                } elseif ($alignment === CINLabel::ALIGN_RIGHT) {
                    $pixelsAround[3] = max($pixelsAround[3], $dimension[0] - $finalW);
                }
            }
        }

        $this->pushLabel[0] = $pixelsAround[3];
        $this->pushLabel[1] = $pixelsAround[0];

        $finalW = ($w + $this->offsetX) * $this->scale + $pixelsAround[1] + $pixelsAround[3];
        $finalH = ($h + $this->offsetY) * $this->scale + $pixelsAround[0] + $pixelsAround[2];

        return array($finalW, $finalH);
    }

    /**
     * Gets the X offset.
     *
     * @return int
     */
    public function getOffsetX() {
        return $this->offsetX;
    }

    /**
     * Sets the X offset.
     *
     * @param int $offsetX
     */
    public function setOffsetX($offsetX) {
        $offsetX = intval($offsetX);
        if ($offsetX < 0) {
            throw new CINArgumentException('The offset X must be 0 or larger.', 'offsetX');
        }

        $this->offsetX = $offsetX;
    }

    /**
     * Gets the Y offset.
     *
     * @return int
     */
    public function getOffsetY() {
        return $this->offsetY;
    }

    /**
     * Sets the Y offset.
     *
     * @param int $offsetY
     */
    public function setOffsetY($offsetY) {
        $offsetY = intval($offsetY);
        if ($offsetY < 0) {
            throw new CINArgumentException('The offset Y must be 0 or larger.', 'offsetY');
        }

        $this->offsetY = $offsetY;
    }

    /**
     * Adds the label to the drawing.
     *
     * @param CINLabel $label
     */
    public function addLabel(CINLabel $label) {
        $label->setBackgroundColor($this->colorBg);
        $label->setForegroundColor($this->colorFg);
        $this->labels[] = $label;
    }

    /**
     * Removes the label from the drawing.
     *
     * @param CINLabel $label
     */
    public function removeLabel(CINLabel $label) {
        $remove = -1;
        $c = count($this->labels);
        for ($i = 0; $i < $c; $i++) {
            if ($this->labels[$i] === $label) {
                $remove = $i;
                break;
            }
        }

        if ($remove > -1) {
            array_splice($this->labels, $remove, 1);
        }
    }

    /**
     * Clears the labels.
     */
    public function clearLabels() {
        $this->labels = array();
    }

    /**
     * Draws the text.
     * The coordinate passed are the positions of the barcode.
     * $x1 and $y1 represent the top left corner.
     * $x2 and $y2 represent the bottom right corner.
     *
     * @param resource $im
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     */
    protected function drawText($im, $x1, $y1, $x2, $y2) {
        foreach ($this->labels as $label) {
            $label->draw($im,
                ($x1 + $this->offsetX) * $this->scale + $this->pushLabel[0],
                ($y1 + $this->offsetY) * $this->scale + $this->pushLabel[1],
                ($x2 + $this->offsetX) * $this->scale + $this->pushLabel[0],
                ($y2 + $this->offsetY) * $this->scale + $this->pushLabel[1]);
        }
    }

    /**
     * Draws 1 pixel on the resource at a specific position with a determined color.
     *
     * @param resource $im
     * @param int $x
     * @param int $y
     * @param int $color
     */
    protected function drawPixel($im, $x, $y, $color = self::COLOR_FG) {
        $xR = ($x + $this->offsetX) * $this->scale + $this->pushLabel[0];
        $yR = ($y + $this->offsetY) * $this->scale + $this->pushLabel[1];

        // We always draw a rectangle
        imagefilledrectangle($im,
            $xR,
            $yR,
            $xR + $this->scale - 1,
            $yR + $this->scale - 1,
            $this->getColor($im, $color));
    }

    /**
     * Draws an empty rectangle on the resource at a specific position with a determined color.
     *
     * @param resource $im
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $color
     */
    protected function drawRectangle($im, $x1, $y1, $x2, $y2, $color = self::COLOR_FG) {
        if ($this->scale === 1) {
            imagefilledrectangle($im,
                ($x1 + $this->offsetX) + $this->pushLabel[0],
                ($y1 + $this->offsetY) + $this->pushLabel[1],
                ($x2 + $this->offsetX) + $this->pushLabel[0],
                ($y2 + $this->offsetY) + $this->pushLabel[1],
                $this->getColor($im, $color));
        } else {
            imagefilledrectangle($im, ($x1 + $this->offsetX) * $this->scale + $this->pushLabel[0], ($y1 + $this->offsetY) * $this->scale + $this->pushLabel[1], ($x2 + $this->offsetX) * $this->scale + $this->pushLabel[0] + $this->scale - 1, ($y1 + $this->offsetY) * $this->scale + $this->pushLabel[1] + $this->scale - 1, $this->getColor($im, $color));
            imagefilledrectangle($im, ($x1 + $this->offsetX) * $this->scale + $this->pushLabel[0], ($y1 + $this->offsetY) * $this->scale + $this->pushLabel[1], ($x1 + $this->offsetX) * $this->scale + $this->pushLabel[0] + $this->scale - 1, ($y2 + $this->offsetY) * $this->scale + $this->pushLabel[1] + $this->scale - 1, $this->getColor($im, $color));
            imagefilledrectangle($im, ($x2 + $this->offsetX) * $this->scale + $this->pushLabel[0], ($y1 + $this->offsetY) * $this->scale + $this->pushLabel[1], ($x2 + $this->offsetX) * $this->scale + $this->pushLabel[0] + $this->scale - 1, ($y2 + $this->offsetY) * $this->scale + $this->pushLabel[1] + $this->scale - 1, $this->getColor($im, $color));
            imagefilledrectangle($im, ($x1 + $this->offsetX) * $this->scale + $this->pushLabel[0], ($y2 + $this->offsetY) * $this->scale + $this->pushLabel[1], ($x2 + $this->offsetX) * $this->scale + $this->pushLabel[0] + $this->scale - 1, ($y2 + $this->offsetY) * $this->scale + $this->pushLabel[1] + $this->scale - 1, $this->getColor($im, $color));
        }
    }

    /**
     * Draws a filled rectangle on the resource at a specific position with a determined color.
     *
     * @param resource $im
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $color
     */
    protected function drawFilledRectangle($im, $x1, $y1, $x2, $y2, $color = self::COLOR_FG) {
        if ($x1 > $x2) { // Swap
            $x1 ^= $x2 ^= $x1 ^= $x2;
        }

        if ($y1 > $y2) { // Swap
            $y1 ^= $y2 ^= $y1 ^= $y2;
        }

        imagefilledrectangle($im,
            ($x1 + $this->offsetX) * $this->scale + $this->pushLabel[0],
            ($y1 + $this->offsetY) * $this->scale + $this->pushLabel[1],
            ($x2 + $this->offsetX) * $this->scale + $this->pushLabel[0] + $this->scale - 1,
            ($y2 + $this->offsetY) * $this->scale + $this->pushLabel[1] + $this->scale - 1,
            $this->getColor($im, $color));
    }

    /**
     * Allocates the color based on the integer.
     *
     * @param resource $im
     * @param int $color
     * @return resource
     */
    protected function getColor($im, $color) {
        if ($color === self::COLOR_BG) {
            return $this->colorBg->allocate($im);
        } else {
            return $this->colorFg->allocate($im);
        }
    }

    /**
     * Returning the biggest label widths for LEFT/RIGHT and heights for TOP/BOTTOM.
     *
     * @param bool $reversed
     * @return CINLabel[]
     */
    private function getBiggestLabels($reversed = false) {
        $searchLR = $reversed ? 1 : 0;
        $searchTB = $reversed ? 0 : 1;

        $labels = array();
        foreach ($this->labels as $label) {
            $position = $label->getPosition();
            if (isset($labels[$position])) {
                $savedDimension = $labels[$position]->getDimension();
                $dimension = $label->getDimension();
                if ($position === CINLabel::POSITION_LEFT || $position === CINLabel::POSITION_RIGHT) {
                    if ($dimension[$searchLR] > $savedDimension[$searchLR]) {
                        $labels[$position] = $label;
                    }
                } else {
                    if ($dimension[$searchTB] > $savedDimension[$searchTB]) {
                        $labels[$position] = $label;
                    }
                }
            } else {
                $labels[$position] = $label;
            }
        }

        return $labels;
    }
}
?>
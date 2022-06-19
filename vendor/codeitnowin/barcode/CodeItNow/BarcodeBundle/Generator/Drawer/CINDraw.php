<?php
/**
 *--------------------------------------------------------------------
 *
 * Base class to draw images
 *
 *--------------------------------------------------------------------
 * @author  Akhtar Khan <er.akhtarkhan@gmail.com>
 * @link http://www.codeitnow.in
 * @package https://github.com/codeitnowin/barcode-generator  
 */
namespace CodeItNow\BarcodeBundle\Generator\Drawer;

abstract class CINDraw {
    protected $im;
    protected $filename;

    /**
     * Constructor.
     *
     * @param resource $im
     */
    protected function __construct($im) {
        $this->im = $im;
    }

    /**
     * Sets the filename.
     *
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * Method needed to draw the image based on its specification (JPG, GIF, etc.).
     */
    abstract public function draw();
}
?>
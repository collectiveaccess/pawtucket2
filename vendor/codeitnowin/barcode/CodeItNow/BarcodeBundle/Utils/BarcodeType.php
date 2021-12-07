<?php
/**
 * BarcodeGenerator
 * @author  Akhtar Khan <er.akhtarkhan@gmail.com>
 * @link http://www.codeitnow.in
 * @package https://github.com/codeitnowin/barcode-generator  
 */
namespace CodeItNow\BarcodeBundle\Utils;

class BarcodeType {
    /**
     * Codabar
     */
    const Codabar = "CINcodabar";
    /**
     * Code 11
     */
    const Code11 = "CINcode11";
    /**
     * Code 39
     */
    const Code39 = "CINcode39";
    /**
     * Code 39 Extended
     */
    const Code39Extended = "CINcode39extended";
    /**
     * Code 128
     */
    const Code128 = "CINcode128";
    /**
     * EAN-8
     */
    const Ean8 = "CINean8";
    /**
     * EAN-13
     */
    const Ean13 = "CINean13";
    /**
     * GS1-128 (EAN-128)
     */
    const Gs1128 = "CINgs1128";
    /**
     * GS1-128 (EAN-128)
     */
    const Ean128 = "CINgs1128";
    /**
     * ISBN
     */
    const Isbn = "CINisbn";
    /**
     * Interleaved 2 of 5
     */
    const I25 = "CINi25";
    /**
     * Standard 2 of 5
     */
    const S25 = "CINs25";
    /**
     * MSI Plessey
     */
    const Msi = "CINmsi";
    /**
     * UPC-A
     */
    const Upca = "CINupca";
    /**
     * UPC-E
     */
    const Upce = "CINupce";
    /**
     * UPC Extenstion 2 Digits
     */
    const Upcext2 = "CINupcext2";
    /**
     * UPC Extenstion 5 Digits
     */
    const Upcext5 = "CINupcext5";
    /**
     * Postnet
     */
    const Postnet = "CINpostnet";
    /**
     * Intelligent Mail
     */
    const Intelligentmail = "CINintelligentmail";
}

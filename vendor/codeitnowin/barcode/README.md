# CodeItNow Barcode & QrCode Generator
Barcode and Qr Code generator library by [CodeItNow](http://www.codeitnow.in). You can use it with Custom PHP application or any PHP Framework such as Laravel, Symfony, Cakephp, Yii, Codeigneter etc.

## Requirements
You must have php >= 5.3.2 installed and GD extension enabled.

## Installation - 
CodeItNow Barcode & Qr Code Generator can install by composer.

```
composer require codeitnowin/barcode
``` 

## Uses -
Barcode and Qr Code Generator library give output as base64 encoded png image.

### Example - QrCode:
```php
use CodeItNow\BarcodeBundle\Utils\QrCode;

$qrCode = new QrCode();
$qrCode
    ->setText('QR code by codeitnow.in')
    ->setSize(300)
    ->setPadding(10)
    ->setErrorCorrection('high')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabel('Scan Qr Code')
    ->setLabelFontSize(16)
    ->setImageType(QrCode::IMAGE_TYPE_PNG)
;
echo '<img src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" />';
```
### Sample Image - QrCode:
![CodeItNow QrCode Generator](/CodeItNow/BarcodeBundle/Resources/image/sample_qrcode.png?raw=true)

### Example - Code128:
```php
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

$barcode = new BarcodeGenerator();
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code128);
$barcode->setScale(2);
$barcode->setThickness(25);
$barcode->setFontSize(10);
$code = $barcode->generate();

echo '<img src="data:image/png;base64,'.$code.'" />';
```

### Example - Codabar:
```php
$barcode->setText("A0123456789C");
$barcode->setType(BarcodeGenerator::Codabar);
```

### Example - Code11:
```php
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code11);
```

### Example - Code39:
```php
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code39);
```

### Example - Code39-Extended:
```php
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code39Extended);
```

### Example - Ean128:
```php
$barcode->setText("00123456789012345675");
$barcode->setType(BarcodeGenerator::Ean128);
```

### Example - Gs1128:
```php
$barcode->setText("00123456789012345675");
$barcode->setType(BarcodeGenerator::Gs1128);
```
### Example - Gs1128 (with no length limit and unknown identifier):
```php
$barcode->setText("4157707266014651802001012603068039000000006377069620171215");
$barcode->setType(BarcodeGenerator::Gs1128);
$barcode->setNoLengthLimit(true);
$barcode->setAllowsUnknownIdentifier(true);
```

### Example - I25:
```php
$barcode->setText("00123456789012345675");
$barcode->setType(BarcodeGenerator::I25);
```

### Example - Isbn:
```php
$barcode->setText("0012345678901");
$barcode->setType(BarcodeGenerator::Isbn);
```

### Example - Msi:
```php
$barcode->setText("0012345678901");
$barcode->setType(BarcodeGenerator::Msi);
```

### Example - Postnet:
```php
$barcode->setText("01234567890");
$barcode->setType(BarcodeGenerator::Postnet);
```

### Example - S25:
```php
$barcode->setText("012345678901");
$barcode->setType(BarcodeGenerator::S25);
```

### Example - Upca:
```php
$barcode->setText("012345678901");
$barcode->setType(BarcodeGenerator::Upca);
```

### Example - Upca:
```php
$barcode->setText("012345");
$barcode->setType(BarcodeGenerator::Upce);
```
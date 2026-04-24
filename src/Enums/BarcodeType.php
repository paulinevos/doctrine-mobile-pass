<?php

namespace Vos\DoctrineMobilePass\Enums;

enum BarcodeType: string
{
    case Qr = 'PKBarcodeFormatQR';
    case Pdf417 = 'PKBarcodeFormatPDF417';
    case Aztec = 'PKBarcodeFormatAztec';
    case Code128 = 'PKBarcodeFormatCode128';
}

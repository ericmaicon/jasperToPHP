<?php

class PixelUtils {

    const DPI = 72;

    public static function mmToPixel($pixels) {
//        return round(($pixels * 25.4) / self::DPI);
    }

    public static function pixeltoMm($pixels) {
        return round(($pixels * 25.4) / self::DPI);
    }

}
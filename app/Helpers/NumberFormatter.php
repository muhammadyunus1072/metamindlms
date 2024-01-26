<?php

namespace App\Helpers;

class NumberFormatter
{
    public const DECIMAL_POIN = 2;

    public static function format($number)
    {
        $decimalPoin = 0.00 !== fmod($number, 1) ? self::DECIMAL_POIN : 0;

        return number_format($number, $decimalPoin, ',', '.');
    }

    public static function denominator($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::denominator($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = self::denominator($nilai / 10) . " Puluh" . self::denominator($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . self::denominator($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::denominator($nilai / 100) . " Ratus" . self::denominator($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . self::denominator($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::denominator($nilai / 1000) . " Ribu" . self::denominator($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::denominator($nilai / 1000000) . " Juta" . self::denominator($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = self::denominator($nilai / 1000000000) . " Milyar" . self::denominator(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = self::denominator($nilai / 1000000000000) . " Trilyun" . self::denominator(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}

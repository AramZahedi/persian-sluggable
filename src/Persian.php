<?php

namespace AramZahedi\Sluggable;

class Persian
{
    /**
     * convert persian and arabic numbers to english number
     *
     * @param $string
     * @param bool $format_numeber
     * @return mixed
     */
    public static function convertNumbersToEnglish($string, $format_numeber = false)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        if ($format_numeber) {
            return number_format($englishNumbersOnly);
        }
        return $englishNumbersOnly;
    }

    /**
     * Convert arabic characters to persian
     *
     * @param string $value
     * @return string|string[]
     */
    public static function convertArabicCharacters($value)
    {
        $arabicChars = ["ي", "ك", "دِ", "بِ", "زِ", "ذِ", "ِشِ", "ِسِ", "ى", "ؤ"];
        $persianChars = ["ی", "ک", "د", "ب", "ز", "ذ", "ش", "س", "ی", "و"];

        return str_replace($arabicChars, $persianChars, $value);
    }
}

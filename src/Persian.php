<?php

namespace AramZahedi\Sluggable;

class Persian
{
    /**
     * convert persian and arabic numbers to english number
     *
     * @param $string
     * @return mixed
     */
    public static function convertNumbersToEnglish($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    /**
     * convert persian and arabic numbers to english number
     *
     * @param $string
     * @return mixed
     */
    public static function convertNumbersToPersian($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $result = self::convertNumbersToEnglish($string);

        foreach ($english as $index => $num) {
            $result = str_replace($num, $persian[$index], $result);
        }

        return $result;
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

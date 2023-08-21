<?php

if ( ! function_exists( 'normalize_phone_number' ) )
{
    function normalize_phone_number ( string $phone_number, string $country_code = "+98", string $starter = "9" ): string|null
    {
        switch ( strlen( $phone_number ) )
        {
            case 10:
                if ( $phone_number[ 0 ] == $starter && is_numeric( $phone_number ) )
                {
                    return $country_code . $phone_number;
                }
                break;
            case 11:
                if ( substr( $phone_number, 0, 2 ) == "0" . $starter && is_numeric( $phone_number ) )
                {
                    return $country_code . substr( $phone_number, 1 );
                }
                break;
            case 12:
                if ( '+' . substr( $phone_number, 0, 3 ) == $country_code . $starter && is_numeric( $phone_number ) )
                {
                    return $country_code . substr( $phone_number, 2 );
                }
                break;
            case 13:
                if ( substr( $phone_number, 0, 4 ) == $country_code . $starter && is_numeric( substr( $phone_number, 1 ) ) )
                {
                    return $phone_number;
                }
                break;
            case 14:
                if ( substr( $phone_number, 0, 5 ) == '00' . str_replace( '+', '', $country_code ) . $starter && is_numeric( $phone_number ) )
                {
                    return '+' . substr( $phone_number, 2 );
                }
                break;
        }

        return null;
    }
}

if ( ! function_exists( 'convert_int_to_english' ) )
{
    function convert_int_to_english ( string $string ): string
    {
        $newNumbers = range( 0, 9 );
        // 1. Persian HTML decimal
        $persianDecimal = array(
            '&#1776;',
            '&#1777;',
            '&#1778;',
            '&#1779;',
            '&#1780;',
            '&#1781;',
            '&#1782;',
            '&#1783;',
            '&#1784;',
            '&#1785;'
        );
        // 2. Arabic HTML decimal
        $arabicDecimal = array(
            '&#1632;',
            '&#1633;',
            '&#1634;',
            '&#1635;',
            '&#1636;',
            '&#1637;',
            '&#1638;',
            '&#1639;',
            '&#1640;',
            '&#1641;'
        );
        // 3. Arabic Numeric
        $arabic = array(
            '٠',
            '١',
            '٢',
            '٣',
            '٤',
            '٥',
            '٦',
            '٧',
            '٨',
            '٩'
        );
        // 4. Persian Numeric
        $persian = array(
            '۰',
            '۱',
            '۲',
            '۳',
            '۴',
            '۵',
            '۶',
            '۷',
            '۸',
            '۹'
        );

        $string = str_replace( $persianDecimal, $newNumbers, $string );
        $string = str_replace( $arabicDecimal, $newNumbers, $string );
        $string = str_replace( $arabic, $newNumbers, $string );

        return str_replace( $persian, $newNumbers, $string );
    }
}

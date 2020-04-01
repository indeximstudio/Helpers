<?php


namespace Indeximstudio\Helpers\String;


class Guard
{
    /**
     * Добавляет обратный слеш перед следующими символами:
     * одинарная кавычка (')
     * двойная кавычка (")
     * обратный слеш (\)
     * NUL (байт NULL)
     *
     * @link http://php.net/manual/ru/function.addslashes.php
     * @param $str
     * @return bool|string
     */
    public static function addSlashes($str)
    {
        $str = self::trim($str);
        if ($str === false) {
            return false;
        }
        return addslashes($str);
    }

    /**
     * Обрезает пробелы по краям
     *
     * @param string $value
     * @return bool|string
     */
    public static function trim($value)
    {
        if (!is_scalar($value)) {
            return false;
        }
        return trim($value);
    }

    /**
     * stripTags : Убирает опасные для Modx символы
     *
     * @param $text
     * @return string|string[]|null
     */
    public static function removeModxDangerTags($text)
    {
        $modRegExArray[] = '~\[\[(.*?)\]\]~s';
        $modRegExArray[] = '~\[\((.*?)\)\]~s';
        $modRegExArray[] = '~\[\!(.*?)\!\]~s';
        $modRegExArray[] = '#\[\~(.*?)\~\]#s';
        $modRegExArray[] = '~{{(.*?)}}~s';
        $modRegExArray[] = '~\[\*(.*?)\*\]~s';
        $modRegExArray[] = '~\[\+(.*?)\+\]~s';

        return str_replace($modRegExArray, '', $text);
    }

    /**
     * Убирает из строки все опасные символы
     *
     * @param $str
     * @return mixed|string
     */
    public static function removeDangerSymbol($str)
    {
        $str = htmlspecialchars($str);
        $quotes = ["\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!"];
        $goodQuotes = ["-", "+", "#"];
        $repQuotes = ["\-", "\+", "\#"];
        $str = trim(strip_tags($str));
        $str = str_replace($quotes, '', $str);
        $str = str_replace($goodQuotes, $repQuotes, $str);
        $str = str_replace("\r\n", ' ', $str);
        $str = str_replace(chr(9), ' ', $str);
        $str = str_replace('[+', '\[\+', $str);
        $str = str_replace('+]', '\+\]', $str);
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = str_replace("\\\\", '', $str);
        $str = str_replace("\\", '', $str);
        $str = str_replace('?', '\?', $str);
        $str = str_replace(";", "", $str);
        $str = str_replace("″", "", $str);
        $str = str_replace("@INHERIT", "", $str);
        $str = str_replace("@SELECT", "", $str);
        $str = str_replace("@EVAL", "", $str);
        $str = str_replace("INHERIT", "", $str);
        $str = str_replace("SELECT", "", $str);
        $str = str_replace("EVAL", "", $str);
        $str = str_replace(" @", "", $str);

        return str_replace("return", "", $str);
    }

    /**
     * stripHtml : Удаляет Html теги
     *
     * @param $text
     * @return string
     */
    public static function removeHtml($text)
    {
        return strip_tags($text);
    }

    /**
     * stripHtmlExceptImage : Удаляет HTML теги кромек тегов картинки image tag
     *
     * @param $text
     * @return string
     */
    public static function removeHtmlExceptImage($text)
    {
        return strip_tags($text, '<img>');
    }

    /**
     * stripJsScript : Удаляет JS
     *
     * @param $text
     * @return string|string[]|null
     */
    public static function removeJsScripts($text)
    {
        $text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text);

        return preg_replace('/{.+?}/', '', $text);
    }

    /**
     * stripLineBreaking : Удаляет теги окончания строки
     *
     * @param $text
     * @return string|string[]|null
     */
    public static function removeLineBreaking($text)
    {
        return preg_replace("'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text);
    }

    public static function guardStringFromUser($str): string
    {
        $word = self::removeModxDangerTags($str);
        $word = self::removeJsScripts($word);
        $word = self::removeLineBreaking($word);
        $word = self::removeDangerSymbol($word);
        $word = self::removeHtml($word);

        return trim(self::removeHtmlExceptImage($word));
    }
}
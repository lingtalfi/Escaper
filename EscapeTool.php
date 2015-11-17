<?php

namespace Escaper;

/*
 * LingTalfi 2015-11-13
 * 
 * Every method has a modeRecursive argument.
 *      If true (default), it uses the recursive escape mode.
 *      If false, it uses the simple escape mode.
 * 
 * All methods in this class use the php's mb_ functions internally.
 * 
 * 
 */

use Bat\StringTool;

class EscapeTool
{


    /**
     *
     * Returns the positions of the escaped symbols in a given string, or false if there is no escaped symbol
     * in the string or if there is an error.
     *
     * @return false|array
     */
    public static function getEscapedSymbolPositions($string, $symbol, $offset = 0, $modeRecursive = true, $escSymbol = '\\')
    {
        $ret = false;
        $pos = StringTool::strPosAll($string, $symbol, $offset);
        if ($pos) {
            foreach ($pos as $p) {
                if (true === self::isEscapedPos($string, $p, $modeRecursive, $escSymbol)) {
                    $ret[] = $p;
                }
            }
        }
        return $ret;
    }


    /**
     *
     * Returns the position of the next unescaped given symbol, or false.
     *
     *
     * @return false|int
     *                  false is returned if the given value does not contain the unescaped symbol.
     *                  Returns the mb position of the next unescaped symbol otherwise.
     */
    public static function getNextUnescapedSymbolPos($string, $symbol, $startPos = 0, $modeRecursive = true, $escSymbol = '\\')
    {
        $ret = false;
        $len = mb_strlen($symbol);
        while (false !== $pos = mb_strpos($string, $symbol, $startPos)) {
            if (false === self::isEscapedPos($string, $pos, $modeRecursive, $escSymbol)) {
                $ret = $pos;
                break;
            }
            $startPos = $pos + $len;
        }
        return $ret;
    }


    /**
     * Returns the positions of the unescaped symbols in a given string, or false if there is no unescaped symbol
     * in the string or if there is an error.
     *
     * @return false|array
     */
    public static function getUnescapedSymbolPositions($string, $symbol, $offset = 0, $modeRecursive = true, $escSymbol = '\\')
    {
        $ret = false;
        $pos = StringTool::strPosAll($string, $symbol, $offset);
        if ($pos) {
            foreach ($pos as $p) {
                if (false === self::isEscapedPos($string, $p, $modeRecursive, $escSymbol)) {
                    $ret[] = $p;
                }
            }
        }
        return $ret;
    }


    /**
     * Returns whether or not the given position of the haystack is escaped.
     */
    public static function isEscapedPos($haystack, $pos, $modeRecursive = true, $escSymbol = '\\')
    {
        $ret = false;
        if (is_string($haystack)) {
            if (true === $modeRecursive) {
                /**
                 * The first position can never be escaped
                 */
                if (0 !== $pos) {
                    // count the number of consecutive escSymbols directly preceding the position
                    $nbEscSym = 0;
                    $symLen = mb_strlen($escSymbol);
                    while (
                        (isset($haystack[$pos - $symLen])) &&
                        $escSymbol === mb_substr($haystack, $pos - $symLen, $symLen)
                    ) {
                        $nbEscSym++;
                        $pos -= $symLen;
                    }
                    $ret = (1 === $nbEscSym % 2);
                }
            }
            else {
                /**
                 * The first position can never be escaped
                 */
                if (0 !== $pos) {
                    $symLen = mb_strlen($escSymbol);
                    while ($escSymbol === mb_substr($haystack, $pos - $symLen, $symLen)) {
                        return true;
                    }
                }
            }
        }
        else {
            trigger_error(sprintf("isEscapedPos expects haystack argument to be string, %s given", gettype($haystack)), E_USER_WARNING);
        }
        return $ret;
    }

}

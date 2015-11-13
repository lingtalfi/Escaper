<?php

namespace Escaper;

/*
 * LingTalfi 2015-11-13
 * 
 * Every method has a modeRecursive argument.
 * If true (default), it uses the recursive escape mode.
 * If false, it uses the simple escape mode.
 * 
 */

class EscapeTool
{


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

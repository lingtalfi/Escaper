EscapeTool
=================
2015-11-13



A tool helping with string escaping.



It uses the [escape modes convention](https://github.com/lingtalfi/Escaper/blob/master/convention/convention.escapeModes.eng.md).


There is only one class: EscapeTool, which methods are explained in this document.
For all of the methods, there are two common arguments:

- modeRecursive: bool, whether to use the recursive mode (default) or the simple mode. See the escape mode convention document for more info
- escSymbol: the escape expression used. The default is the backslash (\\) character


Also, all methods use the **[mb_](http://php.net/manual/en/ref.mbstring.php)** php functions, which means that unless you've done something
special on your machine, the default encoding is utf-8.




getNextUnescapedSymbolPos
----------------------------
2015-11-14

Returns the position of the next unescaped given symbol, or false.


int|false       getNextUnescapedSymbolPos ( str:string, str:symbol, int:startPos=0, bool:modeRecursive=true, str:escSymbol='\\' )





isEscapedPos
---------------
2015-11-13


Returns whether or not the given position of the haystack is escaped.


```
bool        isEscapedPos ( str:haystack, int:pos, bool:modeRecursive, str:escSymbol=\ )
```









Dependencies
------------------

- [lingtalfi/Bat 1.14](https://github.com/lingtalfi/Bat)



History Log
------------------
    
- 1.1.0 -- 2015-11-14

    - add getNextUnescapedSymbolPos 


- 1.0.0 -- 2015-11-13

    - initial commit
    
    
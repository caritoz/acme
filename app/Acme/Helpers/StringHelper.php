<?php
namespace Acme\Helpers;
class StringHelper
{
    public static function CleanHTMLTextareaTidy($buffer)
    {
        $config = array(
            'clean' => true,
            'output-xhtml' => true,
            'show-body-only' => true,
            'wrap' => 0
        );
//        $tidy = new \tidy();
//        $str  = $tidy->repairString($buffer, $config, 'UTF8');
//
//        return $str;
        return $buffer;
    }
}
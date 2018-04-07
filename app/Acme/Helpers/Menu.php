<?php
namespace Acme\Helpers;
class Menu
{
    /**
     * @param $route
     * @param string $label
     * @param string $class
     * @param string $id
     * @return string
     */
    public static function Item($route, $label='', $class='', $subclass = '', $count = '')
    {
        $action = \Route::getCurrentRoute()->getAction();
        $class .= ($action['as']==$route) ? ' active' : '';
        $tag  = $class ? '<li class="'.trim($class).'"> ' : '<li>';
        $tag .= '<a href="'.\URL::route($route).'"><i class="fa '.$subclass.'"></i> <span>'.$label.'</span></a>';
        $tag .= '</li>';

        return $tag;
    }
//<li>
//<a href="pages/calendar.html">
//<i class="fa fa-calendar"></i> <span>Calendar</span>
//<small class="badge pull-right bg-red">3</small>
//</a>
//</li>
    /**
     * @param $route
     * @param string $label
     * @param string $class
     * @param string $id
     * @return string
     */
    public static function subItem($route, $label='', $class='', $id = '')
    {
        $action = \Route::getCurrentRoute()->getAction();
        $class .= ($action['as']==$route) ? ' active' : '';
        $id = ($id!='') ? ' id="'.$id.'" ' : '';
        $tag  = $class ? '<li'.$id.' class="'.trim($class).'"> ' : '<li>';
//        $tag .= '<i class="fa fa-angle-double-right"></i> ';
//        return $tag.HTML::link(URL::route($route),$label).'</li>';

        $tag .= '<a href="'.\URL::route($route).'"><i class="fa fa-angle-double-right"></i> '.$label.'</a>';
        $tag .= '</li>';

        return $tag;
    }
}
<?php

// $Id: legacy.php 915 2009-01-21 19:27:01Z Ruebenwurzel $

/*
    show_menu2: show_menu replacement for Website Baker 
    Copyright (C) 2006-2009, Brodie Thiesfield

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  
    02110-1301, USA.
*/

/*
    This file provides backward compatibility between show_menu2 and the
    old functions show_menu() and menu(). Note that it is highly recommended 
    for you to update your templates to use show_menu2 directly.
 */    

/* ----------------------------------------------------------------------------
   show_menu
   
 From: http://forum.websitebaker.org/index.php/topic,2251.msg13978.html#msg13978  
 
 * By calling it multiple times, you can have one menu just
 * showing the root level, one for the sub-pages, and so on
 * The order of the arguments has been changed compared
 * to the page_menu() function, so read carefully the list
 * of arguments!
 * To just display the standard menu, use
 * <?php show_menu(); ?> within your template's html code.
 * You don't normally need anymore than the first four arguments.
 * Usual calls would be (inside php code!)
 * show_menu(1,0,-1,false); - displays the complete page tree
 * show_menu(1,1,1); - show only first sub level
 * show_menu(1,1,-1); -    show an expanding/collapsing menu tree starting at level 1
 * Have fun experimenting!
 *
 * Full list of arguments:
 * 1. $menu_number:   With activitated "multiple menu" feature
 *                  you can choose which menu will be displayed
 *                  default: 1
 * 2. $start_level: The depth level of the root of the displayed
 *               menu tree. Defaults to '0', which is the top level.
 *                  '1' will show all pages starting from the first sub level.
 * 3. $recurse:     Gives the maximum number of levels to be displayed. Default
 *                  is '-1' which means 'all'.
 * 4. $collapse:    Specifies, whether the menu tree shall be
 *               expandable/collapsible (if set to 'true')
 *               or complete (all pages being displayed) if set to 'false'
 * 5. $item_template: Gives the possibility to specify the html code that is
 *                  displayed before displaying sub-pages
 * 6. $item_footer: The html code to appear after sub-pages were displayed.
 * 7. $menu_header: The html code to appear before the entire menu code and each
 *               sub tree.
 * 8. $menu_footer: The html code to appear after the entire menu code and each
 *               sub tree.
 * 9. $default_class: The (CSS) class of every menu item except the currently viewed page
 * 10. $current_class: The class of the currently viewed page
 * 11. $parent:    (used internally) The page_id of the menu's root node, defaults is '0' (root level)
 */
 
class SM2_ShowMenuFormatter
{
    var $output;
    var $itemTemplate;
    var $itemFooter;
    var $menuHeader;
    var $menuFooter;
    var $defaultClass;
    var $currentClass;
    
    function output($aString) {
        if ($this->flags & SM2_BUFFER) {
            $this->output .= $aString;
        }
        else {
            echo $aString;
        }
    }
    function initialize() { $this->output = ''; }
    function startList($aPage, $aUrl) { 
        echo $this->menuHeader;
    }
    function startItem($aPage, $aUrl, $aCurrSib, $aSibCount) { 
        // determine the class string to use
        $thisClass = $this->defaultClass;
        if ($aPage['page_id'] == PAGE_ID) {
            $thisClass = $this->currentClass;
        }
        
        // format and display this item
        $item = str_replace( 
                array(
                    '[a]','[/a]','[menu_title]','[page_title]','[url]',
                    '[target]','[class]'
                    ),
                array(
                    "<a href='$aUrl' target='".$aPage['target']."'>", '</a>',
                    $aPage['menu_title'], $aPage['page_title'], $aUrl, 
                    $aPage['target'], $thisClass
                    ),
                $this->itemTemplate);
        echo $item;
    }
    function finishItem() { 
        echo $this->itemFooter;
    }
    function finishList() { 
        echo $this->menuFooter;
    }
    function finalize() { }
    function getOutput() {
        return $this->output;
    }
}

function show_menu(
    $aMenu          = 1, 
    $aStartLevel    = 0, 
    $aRecurse       = -1, 
    $aCollapse      = true,
    $aItemTemplate  = '<li><span[class]>[a][menu_title][/a]</span>',
    $aItemFooter    = '</li>',
    $aMenuHeader    = '<ul>',
    $aMenuFooter    = '</ul>',
    $aDefaultClass  = ' class="menu_default"',
    $aCurrentClass  = ' class="menu_current"',
    $aParent        = 0
    )
{
    static $formatter;
    if (!isset($formatter)) {
        $formatter = new SM2_ShowMenuFormatter;
    }
    
    $formatter->itemTemplate  = $aItemTemplate;
    $formatter->itemFooter    = $aItemFooter;  
    $formatter->menuHeader    = $aMenuHeader;  
    $formatter->menuFooter    = $aMenuFooter;  
    $formatter->defaultClass  = $aDefaultClass;
    $formatter->currentClass  = $aCurrentClass;
    
    $start = SM2_ROOT + $aStartLevel;
    if ($aParent != 0) {
        $start = $aParent;
    }

    $maxLevel = 0;
    if ($aRecurse == 0) {
        return;
    }
    if ($aRecurse < 0) {
        $maxLevel = SM2_ALL;
    }
    else {
        $maxLevel = SM2_START + $aRecurse - 1;
    }
    
    $flags = $aCollapse ? SM2_TRIM : SM2_ALL;
    
    // special case for default case
    if ($aStartLevel == 0 && $aRecurse == -1 && $aCollapse) {
        $maxLevel = SM2_CURR + 1;
    }

    show_menu2($aMenu, $start, $maxLevel, $flags, $formatter);
}

function page_menu(
    $aParent = 0, 
    $menu_number = 1, 
    $item_template = '<li[class]>[a][menu_title][/a]</li>', 
    $menu_header = '<ul>', 
    $menu_footer = '</ul>', 
    $default_class = ' class="menu_default"', 
    $current_class = ' class="menu_current"', 
    $recurse = LEVEL    // page['level']
    ) 
{
    show_menu($menu_number, 0, $recurse+2, true, $item_template, '', 
        $menu_header, $menu_footer, $default_class, $current_class, $aParent);
}

?>
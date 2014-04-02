<?php
require_once('VarienObject.php');

class Menu extends Varien_Object {

    var $menus = array();
    var $ci;

    function _construct() {
        $this->ci = &get_instance();
        $this->menus = array();
        $this->setDepth(0);
        $this->menu_ids = array();
        $this->setRemoveMenus(array());
    }

    function addMenu($menu_id, $title, $path = '#', $position = 10, $parent = 0) {
        $menu = array('id' => $menu_id, 'title' => $title, 'url' => $path, 'parent' => $parent, 'position' => $position, 'active' => false);
        $this->menus[$menu_id] = (OBJECT) $menu;
    }

    function setActive($menu_id) {
        $this->active_menu = $menu_id;
    }

    function removeMenu($menu_id) {
        $remove_menus = $this->getRemoveMenus();
        if (!in_array($menu_id, $remove_menus)) {
            $remove_menus[] = $menu_id;
        }
        $this->setRemoveMenus($remove_menus);
    }

    function addSubmenu($parent_id, $menu_id, $title, $path, $position = 0) {
        $this->addMenu($menu_id, $title, $path, $position, $parent_id);
    }

    function processRemoveMenus() {
        $remove_menus = $this->getRemoveMenus();
        foreach ($remove_menus as $menu_id) {
            $this->processRemoveMenu($menu_id);
        }
    }

    function processRemoveMenu($menu_id) {

        foreach ($this->menus as $menu) {
            if ($menu->parent && $menu->parent == $menu_id) {
                $this->processRemoveMenu($menu->id);
            }
        }
        unset($this->menus[$menu_id]);
    }

    function processMenu() {
        $this->processRemoveMenus();
        $sorted_menu_items = array();
        foreach ($this->menus as $menu) {
            $classes[] = 'menu-item';
            if (0 === $menu->parent) {
                $classes[] = 'menu-parent';
            }
            if ($menu->id == $this->active_menu) {
                $classes[] = 'current-menu-item';
                if ($parentid = $menu->parent) {
                    while ($parentid && $parent_menu = &$this->menus[$parentid]) {
                        if ($parent_menu->class) {
                            $parent_menu->class.=' current-menu-parent';
                        } else {
                            $parent_menu->class = 'current-menu-parent';
                        }
                        $parentid = $parent_menu->parent;
                    }
                }
            }
            $menu->class = trim(implode(' ', $classes));
            unset($classes);
            if ($pos = $menu->position) {
                while (isset($sorted_menu_items[$pos]))
                    $pos++;
                $sorted_menu_items[$pos] = $menu;
            } else {
                $sorted_menu_items[] = $menu;
            }
        }
        ksort($sorted_menu_items);
        $this->setProcessedMenus($sorted_menu_items);
        return $sorted_menu_items;
    }

    function renderMenu() {
        $menus = $this->processMenu();
        return $menus;
    }

}
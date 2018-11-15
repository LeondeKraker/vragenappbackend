<?php

/**
 * This Admin controller file provide functionality for the Admin
 *
 * @author Leon de Kraker
 * @version 0.1
 *
 * Version history
 * 0.1 Leon de Kraker Initial version
 */
class VragenApp_AdminController
{

    //This function will prepare all Admin functionality for the plugin
    static function prepare()
    {
        // Check that we are in the admin area
        if (is_admin()) :
            // Add the sidebar Menu structure
        add_action('admin_menu', array('VragenApp_AdminController', 'addMenus'));
        endif;
    }

    // Add the Menu structure to the Admin sidebar
    static function addMenus()
    {
        add_menu_page(
                // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('Vragen app', 'Vragen app'),
                // string $menu_title The text to be used for the menu
            __('Vragen app', 'Vragen app'),
                // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
                // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'vragen-app',
                // callback $function The function to be called to output the content for this page.
            array('VragenApp_AdminController', 'adminMenuPage')
        );

        //vragen pagina submenu
        add_submenu_page(
            // string $parent_slug The slug name for the parent menu
            // (or the file name of a standard WordPress admin page)
            'vragen-app',
            // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('Vragen pagina', 'vragen pagina'),
            // string $menu_title The text to be used for the menu
            __('Vragen pagina', 'vragen pagina'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'vragen-pagina',
            // callback $function The function to be called to output the content for this page.
            array('VragenApp_AdminController', 'adminSubMenuVragenPagina')
        );

        //Cluster en opleidingen pagina submenu
        add_submenu_page(
        // string $parent_slug The slug name for the parent menu
            // (or the file name of a standard WordPress admin page)
            'vragen-app',
            // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('Cluster en opleiding', 'Cluster en opleiding'),
            // string $menu_title The text to be used for the menu
            __('Cluster en opleiding', 'Cluster en opleiding'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'cluster-en-opleiding',
            // callback $function The function to be called to output the content for this page.
            array('VragenApp_AdminController', 'adminSubMenuClusterEnOpleidingenPagina')
        );

        //Cluster en opleidingen pagina submenu
        add_submenu_page(
            // string $parent_slug The slug name for the parent menu
            // (or the file name of a standard WordPress admin page)
            'vragen-app',
            // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('Resultatenpagina', 'Resultatenpagina'),
            // string $menu_title The text to be used for the menu
            __('Resultatenpagina', 'Resultatenpagina'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'resultaten-pagina',
            // callback $function The function to be called to output the content for this page.
            array('VragenApp_AdminController', 'adminSubMenuResultatenPagina')
        );
    }

    // The main menu page
    static function adminMenuPage()
    {
        // Include the view for this menu page.
        include VRAGEN_PLUGIN_ADMIN_VIEWS_DIR . '/admin_main.php';
    }

    // The question page
    static function adminSubMenuVragenPagina()
    {
        // Include the view for this menu page.
        include VRAGEN_PLUGIN_ADMIN_VIEWS_DIR . '/vragenpagina.php';
    }

    // The cluster and education page
    static function adminSubMenuClusterEnOpleidingenPagina()
    {
        // Include the view for this menu page.
        include VRAGEN_PLUGIN_ADMIN_VIEWS_DIR . '/cluster_en_opleidingen_pagina.php';
    }

    // The cresults page
    static function adminSubMenuResultatenPagina()
    {
        // Include the view for this menu page.
        include VRAGEN_PLUGIN_ADMIN_VIEWS_DIR . '/resultatenpagina.php';
    }

}
?>
<?php

namespace App\Core\Bootstraps;

use App\Core\Adapters\Menu;
use App\Core\Adapters\Theme;

class BootstrapSkin
{
    // Private Properties
    private static $menu;

    private static $horizontalMenu;

    // Private Methods
    private static function initLayout()
    {
        Theme::addHtmlAttribute('body', 'id', 'kt_body');

        if (Theme::getOption('skin', 'main/body/background-image')) {
            Theme::addHtmlAttribute('body', 'style', 'background-image: url('.asset(theme()->getMediaUrlPath().Theme::getOption('skin', 'main/body/background-image')).')');
        }

        if (Theme::getOption('skin', 'main/body/class')) {
            Theme::addHtmlClass('body', Theme::getOption('skin', 'main/body/class'));
        }

        if (Theme::getOption('skin', 'main/body/attributes')) {
            Theme::addHtmlAttributes('body', Theme::getOption('skin', 'main/body/attributes'));
        }

        if (Theme::getOption('skin', 'loader/display') === true) {
            Theme::addHtmlClass('body', 'page-loading-enabled');
            Theme::addHtmlClass('body', 'page-loading');
        }

        //Theme::addHtmlClass('body', 'modal-open');
        if (Theme::getOption('layout', 'main/type') === 'default') {
            Theme::addPageJs('js/custom/widgets.js');
            Theme::addPageJs('js/custom/apps/chat/chat.js');
            Theme::addPageJs('js/custom/modals/create-app.js');
            Theme::addPageJs('js/custom/modals/upgrade-plan.js');

            if (Theme::getViewMode() !== 'release') {
                Theme::addPageJs('js/custom/intro.js');
            }
        }
    }

    private static function initHeader()
    {
        if (Theme::getOption('skin', 'header/width') == 'fluid') {
            Theme::addHtmlClass('header-container', 'container-fluid');
        } else {
            Theme::addHtmlClass('header-container', 'container');
        }

        if (Theme::getOption('skin', 'header/fixed/desktop') === true) {
            Theme::addHtmlClass('body', 'header-fixed');
        }

        if (Theme::getOption('skin', 'header/fixed/tablet-and-mobile') === true) {
            Theme::addHtmlClass('body', 'header-tablet-and-mobile-fixed');
        }
    }

    private static function initToolbar()
    {
        if (Theme::getOption('skin', 'toolbar/display') === false) {
            return;
        }

        Theme::addHtmlClass('body', 'toolbar-enabled');

        if (Theme::getOption('skin', 'toolbar/width') == 'fluid') {
            Theme::addHtmlClass('toolbar-container', 'container-fluid');
        } else {
            Theme::addHtmlClass('toolbar-container', 'container');
        }

        if (Theme::getOption('skin', 'toolbar/fixed/desktop') === true) {
            Theme::addHtmlClass('body', 'toolbar-fixed');
        }

        if (Theme::getOption('skin', 'toolbar/fixed/tablet-and-mobile') === true) {
            Theme::addHtmlClass('body', 'toolbar-tablet-and-mobile-fixed');
        }

        // Height setup
        $type = Theme::getOption('skin', 'toolbar/layout');
        $typeOptions = Theme::getOption('skin', 'toolbar/layouts/'.$type);

        if ($typeOptions) {
            if (isset($typeOptions['height'])) {
                Theme::addCssVariable('body', '--kt-toolbar-height', $typeOptions['height']);
            }

            if (isset($typeOptions['height-tablet-and-mobile'])) {
                Theme::addCssVariable('body', '--kt-toolbar-height-tablet-and-mobile', $typeOptions['height-tablet-and-mobile']);
            }
        }
    }

    private static function initPageTitle()
    {
        if (Theme::getOption('skin', 'page-title/display') === false) {
            return;
        }

        if (Theme::getOption('skin', 'page-title/direction') == 'column') {
            Theme::addHtmlClass('page-title', 'flex-column align-items-start me-3');
        } else {
            Theme::addHtmlClass('page-title', 'align-items-center flex-wrap me-3');
        }

        if (Theme::getOption('skin', 'header/left') === 'page-title') {
            Theme::setOption('skin', 'page-title/responsive-target', '#kt_header_nav');
        }

        if (Theme::getOption('skin', 'page-title/responsive') === true) {
            Theme::addHtmlClass('page-title', 'mb-5 mb-lg-0');

            $attr = [];
            $attr['data-kt-swapper'] = 'true';
            $attr['data-kt-swapper-mode'] = 'prepend';
            $attr['data-kt-swapper-parent'] = "{default: '#kt_content_container', '".Theme::getOption('skin', 'page-title/responsive-breakpoint')."': '".Theme::getOption('skin', 'page-title/responsive-target')."'}";

            Theme::addHtmlAttributes('page-title', $attr);
        }
    }

    private static function initContent()
    {
        if (Theme::getOption('skin', 'content/width') == 'fluid') {
            Theme::addHtmlClass('content-container', 'container-fluid');
        } elseif (Theme::getOption('skin', 'content/width') == 'fixed') {
            Theme::addHtmlClass('content-container', 'container');
        }

        if (Theme::getOption('skin', 'content/class')) {
            Theme::addHtmlClass('content', Theme::getOption('skin', 'content/class'));
        }

        if (Theme::getOption('skin', 'content/container-class')) {
            Theme::addHtmlClass('content-container', Theme::getOption('skin', 'content/container-class'));
        }
    }

    private static function initAside()
    {
        // Check if aside is displayed
        if (Theme::getOption('skin', 'aside/display') != true) {
            return;
        }

        Theme::addHtmlClass('body', 'aside-enabled');
        Theme::addHtmlClass('aside', 'aside-'.Theme::getOption('skin', 'aside/theme'));

        // Fixed aside
        if (Theme::getOption('skin', 'aside/fixed')) {
            Theme::addHtmlClass('body', 'aside-fixed');
        }

        // Default minimized
        if (Theme::getOption('skin', 'aside/minimized')) {
            Theme::addHtmlAttribute('body', 'data-kt-aside-minimize', 'on');
        }

        // Hoverable on minimize
        if (Theme::getOption('skin', 'aside/hoverable')) {
            Theme::addHtmlClass('aside', 'aside-hoverable');
        }
    }

    private static function initAsideMenu()
    {
        self::$menu = new Menu(Theme::getOption('menu', 'main'), Theme::getPagePath());

        if (Theme::getOption('skin', 'aside/menu-icons-display') === false) {
            self::$menu->displayIcons(false);
        }

        self::$menu->setIconType(Theme::getOption('skin', 'aside/menu-icon'));
    }

    private static function initHorizontalMenu()
    {
        self::$horizontalMenu = new Menu(Theme::getOption('menu', 'horizontal'), Theme::getPagePath());
        self::$horizontalMenu->setItemLinkClass('py-3');
        self::$horizontalMenu->setIconType(Theme::getOption('skin', 'header/menu-icon', 'svg'));
    }

    private static function initFooter()
    {
        if (Theme::getOption('skin', 'footer/width') == 'fluid') {
            Theme::addHtmlClass('footer-container', 'container-fluid');
        } else {
            Theme::addHtmlClass('footer-container', 'container');
        }
    }

    // Public Methods
    public static function run()
    {
        if (Theme::isDarkModeEnabled() && Theme::getCurrentMode() === 'dark') {
            Theme::addHtmlClass('body', 'dark-mode');
        }

        if (Theme::getOption('skin', 'base') === 'docs') {
            return;
        }

        // Init layout
        self::initLayout();

        // Init Partials
        if (Theme::getOption('skin', 'main/type') === 'default') {
            self::initHeader();
            self::initPageTitle();
            self::initToolbar();
            self::initContent();
            self::initAside();
            self::initFooter();
            self::initAsideMenu();
            self::initHorizontalMenu();
        }
    }

    public static function getAsideMenu()
    {
        return self::$menu;
    }

    public static function getHorizontalMenu()
    {
        return self::$horizontalMenu;
    }

    public static function getBreadcrumb()
    {
        $options = [
            'skip-active' => false,
        ];

        return self::getAsideMenu()->getBreadcrumb($options);
    }
}

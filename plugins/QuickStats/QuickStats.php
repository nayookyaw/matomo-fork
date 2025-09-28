<?php
namespace Piwik\Plugins\QuickStats;

use Piwik\Plugin;

class QuickStats extends Plugin
{
    public function registerEvents() : array
    {
        return [
            // mentioned in take-home: inject via Template.pageFooter
            'Template.pageFooter' => 'renderFooterMount',

            // load built Vue bundle + CSS on all pages
            'AssetManager.getJavaScriptFiles' => 'addJs',
            'AssetManager.getStylesheetFiles' => 'addCss',
        ];
    }

    // NOTE the "&$out" — param by reference!
    public function renderFooterMount(&$out): void
    {
        if (strpos((string)$out, 'quick-stats-root') === false) {
            $out .= '<div id="quick-stats-root" data-quick-stats></div>';
        }
    }

    public function addJs(array &$jsFiles) : void
    {
        $jsFiles[] = 'plugins/QuickStats/dist/quickstats.js';
    }

    public function addCss(array &$cssFiles) : void
    {
        $cssFiles[] = 'plugins/QuickStats/dist/quickstats.main.css';
    }
}
?>
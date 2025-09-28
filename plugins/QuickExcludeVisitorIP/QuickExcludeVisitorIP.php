<?php 
/**
 * Plugin Name: Quick Exclude Visitor IP (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/QuickExcludeVisitorIP
 * Description: Adds a button to Visitor Profile to quickly add them to the list of ignored IPs
 * Author: Lukas Winkler
 * Author URI: https://lw1.at
 * Version: 0.2.0
 */
?><?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\QuickExcludeVisitorIP;

use Piwik\Access;
use Piwik\DataTable\Row;
use Piwik\Plugin;

 
if (defined( 'ABSPATH')
&& function_exists('add_action')) {
    $path = '/matomo/app/core/Plugin.php';
    if (defined('WP_PLUGIN_DIR') && WP_PLUGIN_DIR && file_exists(WP_PLUGIN_DIR . $path)) {
        require_once WP_PLUGIN_DIR . $path;
    } elseif (defined('WPMU_PLUGIN_DIR') && WPMU_PLUGIN_DIR && file_exists(WPMU_PLUGIN_DIR . $path)) {
        require_once WPMU_PLUGIN_DIR . $path;
    } else {
        return;
    }
    add_action('plugins_loaded', function () {
        if (function_exists('matomo_add_plugin')) {
            matomo_add_plugin(__DIR__, __FILE__, true);
        }
    });
}

class QuickExcludeVisitorIP extends Plugin
{
    public function registerEvents()
    {
        return array(
            'Live.renderVisitorIcons' => 'addLinkToTemplate',
            'AssetManager.getJavaScriptFiles' => 'getJavaScriptFiles',
        );
    }

    public function addLinkToTemplate(&$outString, Row $visit)
    {
        if (Access::getInstance()->hasSuperUserAccess()) {
            $ip = $visit->getColumn("visitIp");
            $outString .= "<a class='quickExcludeButton' data-ip='$ip'>ignore</a>";
        }
    }

    public function getJavaScriptFiles(&$files)
    {
        $files[] = "plugins/QuickExcludeVisitorIP/javascripts/main.js";
    }
}

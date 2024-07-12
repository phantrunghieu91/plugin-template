<?php
/**
 * @package JinsPlugin
 */
namespace jinsPlugin\inc\base;

class Deactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
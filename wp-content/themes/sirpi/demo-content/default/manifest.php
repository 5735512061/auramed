<?php if (!defined('FW')) die('Forbidden');
/**
 * @var string $uri Demo directory url
 */

$manifest = array();
$manifest['title'] = esc_html__('Default Demo', 'sirpi');
$manifest['screenshot'] = $uri . '/screenshot.png';
$manifest['preview_link'] = 'https://sirpi.wpengine.com/';
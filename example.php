<?php

/**
 * Language Tags based on Internet Assigned Numbers Authority (IANA)'s Registry
 * @author  goldsky <goldsky@fastmail.fm>
 * @date    Dec 25, 2010
 * @access  public
 * @link    http://www.iana.org/assignments/language-subtag-registry
 * @package LanguageSubtagRegistry
 */
// for security only, comment this to run the script
die();

include_once './language-subtag-registry.php';
// or with Composer, after composer install, require 'vendor/autoload.php'
$ianaLstr = new LanguageSubtagRegistry();
$ianaLstr->readSource('language-subtag-registry');

$languagesArray = $ianaLstr->languagesArray();
echo __LINE__ . ' : $languagesArray = ' . $languagesArray . '<br />';
echo '<pre>';
print_r($languagesArray);
echo '</pre>';

$languagesAssocArray = $ianaLstr->languagesAssocArray('Subtag');
echo __LINE__ . ' : $languagesAssocArray = ' . $languagesAssocArray . '<br />';
echo '<pre>';
print_r($languagesAssocArray);
echo '</pre>';

$languagesAssoc = $ianaLstr->languagesAssoc(array('Subtag' => 'cu') , 'Description');
echo __LINE__ . ' : $languagesAssoc = ' . $languagesAssoc . '<br />';
echo '<pre>';
print_r($languagesAssoc);
echo '</pre>';
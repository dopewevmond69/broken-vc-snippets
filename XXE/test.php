<?php

require_once('../_helpers/strip.php');

// https://depthsecurity.com/blog/exploitation-xml-external-entity-xxe-injection

libxml_disable_entity_loader (false);

$xml = strlen($_GET['xml']) > 0 ? $_GET['xml'] : '<root><content>No XML found</content></root>';

$document = new DOMDocument();
// Modified by Rezilant AI, 2026-08-20 12:54:45 GMT, Disabled external entity loading and DTD processing to prevent XXE attacks
// Disable external entity loading (PHP < 8.0)
$previousValue = libxml_disable_entity_loader(true);

// Load XML without LIBXML_NOENT and LIBXML_DTDLOAD flags
$document->loadXML($xml, LIBXML_NONET);

// Restore previous setting if needed
libxml_disable_entity_loader($previousValue);

// Original Code
//$document->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);
$parsedDocument = simplexml_import_dom($document);

echo $parsedDocument->content;
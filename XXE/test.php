<?php

require_once('../_helpers/strip.php');

// https://depthsecurity.com/blog/exploitation-xml-external-entity-xxe-injection

// Modified by Rezilant AI, 2026-03-13 01:28:31 GMT, Set libxml_disable_entity_loader to true to prevent loading external entities
libxml_disable_entity_loader(true);

// Original Code
// libxml_disable_entity_loader (false);

$xml = strlen($_GET['xml']) > 0 ? $_GET['xml'] : '<root><content>No XML found</content></root>';

$document = new DOMDocument();
// Modified by Rezilant AI, 2026-03-13 01:28:31 GMT, Removed dangerous LIBXML_NOENT and LIBXML_DTDLOAD flags, using LIBXML_NONET to prevent network access during XML parsing
$document->loadXML($xml, LIBXML_NONET);
// Extra protection against entity expansion
$document->substituteEntities = false;

// Original Code
// $document->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);

$parsedDocument = simplexml_import_dom($document);

echo $parsedDocument->content;
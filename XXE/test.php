<?php

require_once('../_helpers/strip.php');

// https://depthsecurity.com/blog/exploitation-xml-external-entity-xxe-injection

// Modified by Rezilant AI, 2026-03-10 12:28:09 GMT, Enable protection against XXE by disabling external entity loading
libxml_disable_entity_loader(true);
// Original Code
// libxml_disable_entity_loader (false);

$xml = strlen($_GET['xml']) > 0 ? $_GET['xml'] : '<root><content>No XML found</content></root>';

$document = new DOMDocument();
// Modified by Rezilant AI, 2026-03-10 12:28:09 GMT, Remove dangerous LIBXML_NOENT and LIBXML_DTDLOAD flags to prevent XXE attacks
$document->loadXML($xml);
// Original Code
// $document->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);
$parsedDocument = simplexml_import_dom($document);

// Modified by Rezilant AI, 2026-03-10 12:28:09 GMT, Add htmlentities() to prevent XSS vulnerability when echoing user input
echo htmlentities($parsedDocument->content);
// Original Code
// echo $parsedDocument->content;
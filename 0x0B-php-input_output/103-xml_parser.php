<?php
/**
 * Parses an XML file and displays its contents.
 *
 * Usage: php 103-xml_parser.php
 */

$xmlStr = <<<XML
<students>
    <student name="Anna" grade="A"/>
    <student name="Mark" grade="B"/>
</students>
XML;

$xml = simplexml_load_string($xmlStr);
if ($xml === false) {
    echo "XML parsing failed.\n";
} else {
    foreach ($xml->student as $student) {
        echo "Name: " . $student['name'] . ", Grade: " . $student['grade'] . "\n";
    }
}

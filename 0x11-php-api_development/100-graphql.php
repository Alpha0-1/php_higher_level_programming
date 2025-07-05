<?php
/**
 * 100-graphql.php
 *
 * Basic GraphQL server using Webonyx GraphQL library (mocked).
 */

require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

// Define types
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'hello' => [
            'type' => Type::string(),
            'resolve' => fn() => 'Hello World'
        ]
    ]
]);

$schema = new Schema(['query' => $queryType]);

$input = json_decode(file_get_contents('php://input'), true);
$query = $input['query'] ?? '{ hello }';

try {
    $result = GraphQL::executeQuery($schema, $query);
    $output = $result->toArray();
} catch (\Exception $e) {
    $output = ['error' => $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($output);
?>
/** 
 * Note: Requires webonyx/graphql-php. 
 * Install via: composer require webonyx/graphql-php
 */

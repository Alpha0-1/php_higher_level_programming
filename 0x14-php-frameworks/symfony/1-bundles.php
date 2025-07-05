<?php
/**
 * Symfony Bundles Example
 * 
 * Demonstrates creating and using bundles in Symfony.
 */

namespace App\CustomBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CustomBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        // Add compiler passes or extensions here
    }
}

// To register the bundle, add to config/bundles.php:
/*
return [
    // ...
    App\CustomBundle\CustomBundle::class => ['all' => true],
];
*/

// Installing third-party bundles example:
/*
$ composer require doctrine/doctrine-bundle
$ composer require twig/twig-bundle
*/

echo "Bundle examples. Key points:\n";
echo "- Bundles are like plugins/packages in Symfony\n";
echo "- Can contain controllers, services, config, etc.\n";
echo "- Modern Symfony versions typically use one App bundle\n";
echo "- Third-party bundles extend functionality\n";
?>

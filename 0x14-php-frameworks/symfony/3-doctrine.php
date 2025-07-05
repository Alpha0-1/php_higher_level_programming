<?php
/**
 * Symfony Doctrine ORM Example
 * 
 * Demonstrates Doctrine entities, repositories, and queries.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    // Getters and setters...
}

// Repository example:
namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    
    public function findCheaperThan(float $price): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.price < :price')
            ->setParameter('price', $price)
            ->getQuery()
            ->getResult();
    }
}

// Controller usage:
/*
public function index(ProductRepository $repo)
{
    $products = $repo->findCheaperThan(100);
    // ...
}
*/

echo "Doctrine ORM examples. Key features:\n";
echo "- Database abstraction layer\n";
echo "- Entity classes represent database tables\n";
echo "- Repositories for custom queries\n";
echo "- Migrations support\n";
?>

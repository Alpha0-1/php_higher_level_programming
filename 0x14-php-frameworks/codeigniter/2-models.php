<?php
/**
 * CodeIgniter Models Example
 * 
 * Demonstrates database interaction with models.
 */

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'stock'];
    protected $returnType = 'object';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'price' => 'required|numeric',
        'stock' => 'permit_empty|integer'
    ];
    
    protected $beforeInsert = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'], PASSWORD_DEFAULT
            );
        }
        
        return $data;
    }
    
    public function getAffordableProducts(float $maxPrice)
    {
        return $this->where('price <=', $maxPrice)
                   ->orderBy('price', 'ASC')
                   ->findAll();
    }
}

// Controller usage example:
/*
$model = new \App\Models\ProductModel();
$products = $model->where('price <', 100)->findAll();
$cheapProducts = $model->getAffordableProducts(50);
*/

echo "Model examples. Key features:\n";
echo "- Built-in query builder\n";
echo "- Automatic validation\n";
echo "- Events (beforeInsert, afterUpdate, etc.)\n";
echo "- Easy pagination and caching\n";
?>

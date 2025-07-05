<?php
/**
 * CodeIgniter Views Example
 * 
 * Demonstrates view rendering and templating.
 */

// app/Views/welcome_message.php
/*
<!DOCTYPE html>
<html>
<head>
    <title><?= esc($title) ?></title>
</head>
<body>
    <h1><?= esc($heading) ?></h1>
    
    <?php foreach ($news as $item): ?>
        <h2><?= esc($item['title']) ?></h2>
        <p><?= esc($item['body']) ?></p>
    <?php endforeach ?>
</body>
</html>
*/

// Controller example:
/*
public function index()
{
    $data = [
        'title' => 'My Home Page',
        'heading' => 'Welcome to our Site',
        'news' => $newsModel->findAll(),
    ];
    
    return view('welcome_message', $data);
}
*/

// View cells (reusable components):
/*
// Create app/ViewCells/RecentPostsCell.php
namespace App\ViewCells;

use CodeIgniter\View\Cells\Cell;

class RecentPostsCell extends Cell
{
    protected $posts;
    
    public function mount(int $limit = 5)
    {
        $this->posts = model('PostModel')->orderBy('created_at', 'DESC')
                                        ->findAll($limit);
    }
    
    public function render(): string
    {
        return $this->view('cells/recent_posts', [
            'posts' => $this->posts
        ]);
    }
}

// In view file:
<?= view_cell('App\ViewCells\RecentPostsCell::class, ['limit' => 3]) ?>
*/

echo "View examples. Key features:\n";
echo "- Simple PHP-based templates\n";
echo "- Automatic output escaping with esc()\n";
echo "- View cells for reusable components\n";
echo "- Layouts can be created by combining views\n";
?>

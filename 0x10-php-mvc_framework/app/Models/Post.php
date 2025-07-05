<?php
/**
 * Post Model
 * Handles post data and operations
 */
class Post extends BaseModel
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'content', 'user_id', 'status', 'slug'];
    
    /**
     * Get all posts with author information
     * @return array
     */
    public function getAllWithAuthor()
    {
        $sql = "SELECT p.*, u.name as author_name, u.email as author_email 
                FROM {$this->table} p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get post with author information
     * @param int $id - Post ID
     * @return array|null
     */
    public function getWithAuthor($id)
    {
        $sql = "SELECT p.*, u.name as author_name, u.email as author_email 
                FROM {$this->table} p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get posts by status
     * @param string $status - Post status
     * @return array
     */
    public function getByStatus($status)
    {
        $sql = "SELECT p.*, u.name as author_name 
                FROM {$this->table} p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = :status 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get published posts
     * @return array
     */
    public function getPublished()
    {
        return $this->getByStatus('published');
    }
    
    /**
     * Get draft posts
     * @return array
     */
    public function getDrafts()
    {
        return $this->getByStatus('draft');
    }
    
    /**
     * Generate slug from title
     * @param string $title - Post title
     * @return string
     */
    public function generateSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return rtrim($slug, '-');
    }
    
    /**
     * Get post excerpt
     * @param array $post - Post record
     * @param int $length - Excerpt length
     * @return string
     */
    public function getExcerpt($post, $length = 150)
    {
        if (!isset($post['content'])) {
            return '';
        }
        
        $content = strip_tags($post['content']);
        if (strlen($content) <= $length) {
            return $content;
        }
        
        return substr($content, 0, $length) . '...';
    }
    
    /**
     * Get post word count
     * @param array $post - Post record
     * @return int
     */
    public function getWordCount($post)
    {
        if (!isset($post['content'])) {
            return 0;
        }
        
        return str_word_count(strip_tags($post['content']));
    }
    
    /**
     * Get estimated reading time
     * @param array $post - Post record
     * @param int $wordsPerMinute - Average reading speed
     * @return int
     */
    public function getReadingTime($post, $wordsPerMinute = 200)
    {
        $wordCount = $this->getWordCount($post);
        $minutes = ceil($wordCount / $wordsPerMinute);
        return max(1, $minutes);
    }
}

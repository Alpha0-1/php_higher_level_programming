<?php
/**
 * User Model
 * Handles user data and operations
 */
class User extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password', 'avatar'];
    
    /**
     * Find user by email
     * @param string $email - User email
     * @return array|null
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's posts
     * @param int $userId - User ID
     * @return array
     */
    public function getPosts($userId)
    {
        $sql = "SELECT p.*, u.name as author_name 
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.user_id = :user_id 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Hash password
     * @param string $password - Plain text password
     * @return string
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify password
     * @param string $password - Plain text password
     * @param string $hash - Hashed password
     * @return bool
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
    
    /**
     * Get user's full name
     * @param array $user - User record
     * @return string
     */
    public function getFullName($user)
    {
        return isset($user['name']) ? $user['name'] : 'Unknown User';
    }
    
    /**
     * Get user's avatar URL
     * @param array $user - User record
     * @return string
     */
    public function getAvatarUrl($user)
    {
        if (isset($user['avatar']) && !empty($user['avatar'])) {
            return '/images/avatars/' . $user['avatar'];
        }
        
        // Default avatar using Gravatar
        $email = isset($user['email']) ? $user['email'] : '';
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=150";
    }
}

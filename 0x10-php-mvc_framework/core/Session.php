<?php
/**
 * Session Class
 * Handles session management and flash messages
 */
class Session
{
    /**
     * Set session data
     * @param string $key - Session key
     * @param mixed $value - Session value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session data
     * @param string $key - Session key
     * @param mixed $default - Default value if key doesn't exist
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    /**
     * Check if session key exists
     * @param string $key - Session key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session data
     * @param string $key - Session key
     */
    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Clear all session data
     */
    public function clear()
    {
        $_SESSION = [];
    }
    
    /**
     * Set flash message
     * @param string $key - Flash message key
     * @param string $message - Flash message
     */
    public function flash($key, $message)
    {
        $_SESSION['flash'][$key] = $message;
    }
    
    /**
     * Get flash message
     * @param string $key - Flash message key
     * @return string|null
     */
    public function getFlash($key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        
        return null;
    }
    
    /**
     * Check if flash message exists
     * @param string $key - Flash message key
     * @return bool
     */
    public function hasFlash($key)
    {
        return isset($_SESSION['flash'][$key]);
    }
}


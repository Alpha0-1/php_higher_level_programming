<?php
/**
 * BaseModel Class
 * Extended base model with additional functionality
 */
class BaseModel extends Model
{
    protected $timestamps = true;
    
    /**
     * Get formatted created_at timestamp
     * @param array $record - Database record
     * @return string
     */
    public function getCreatedAt($record)
    {
        return isset($record['created_at']) ? 
            date('Y-m-d H:i:s', strtotime($record['created_at'])) : null;
    }
    
    /**
     * Get formatted updated_at timestamp
     * @param array $record - Database record
     * @return string
     */
    public function getUpdatedAt($record)
    {
        return isset($record['updated_at']) ? 
            date('Y-m-d H:i:s', strtotime($record['updated_at'])) : null;
    }
    
    /**
     * Add timestamps to data before saving
     * @param array $data - Data to save
     * @param bool $isUpdate - Whether this is an update operation
     * @return array
     */
    protected function addTimestamps($data, $isUpdate = false)
    {
        if (!$this->timestamps) {
            return $data;
        }
        
        $now = date('Y-m-d H:i:s');
        
        if (!$isUpdate) {
            $data['created_at'] = $now;
        }
        
        $data['updated_at'] = $now;
        
        return $data;
    }
    
    /**
     * Override create method to add timestamps
     * @param array $data - Data to insert
     * @return bool
     */
    public function create($data)
    {
        $data = $this->addTimestamps($data, false);
        return parent::create($data);
    }
    
    /**
     * Override update method to add timestamps
     * @param int $id - Record ID
     * @param array $data - Data to update
     * @return bool
     */
    public function update($id, $data)
    {
        $data = $this->addTimestamps($data, true);
        return parent::update($id, $data);
    }
    
    /**
     * Get paginated results
     * @param int $page - Page number
     * @param int $perPage - Records per page
     * @return array
     */
    public function paginate($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Get records
        $sql = "SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'data' => $records,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total)
        ];
    }
}

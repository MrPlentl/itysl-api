<?php

class Tag {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Get all tags
     */
    public function getAll() {
        $query = "SELECT t.*, COUNT(qt.quote_id) as quote_count
                  FROM tags t
                  LEFT JOIN quote_tags qt ON t.id = qt.tag_id
                  GROUP BY t.id
                  ORDER BY t.name ASC";
        
        $result = $this->conn->query($query);
        
        if (!$result) {
            throw new Exception('Query failed: ' . $this->conn->error);
        }
        
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'quote_count' => (int)$row['quote_count']
            ];
        }
        
        return $tags;
    }
    
    /**
     * Get tag by ID
     */
    public function getById($id) {
        $stmt = $this->conn->prepare(
            "SELECT t.*, COUNT(qt.quote_id) as quote_count
             FROM tags t
             LEFT JOIN quote_tags qt ON t.id = qt.tag_id
             WHERE t.id = ?
             GROUP BY t.id"
        );
        
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'quote_count' => (int)$row['quote_count']
            ];
        }
        
        return null;
    }
    
    /**
     * Create new tag
     */
    public function create($name) {
        // Check if tag already exists
        $stmt = $this->conn->prepare("SELECT id FROM tags WHERE name = ?");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception('Tag already exists');
        }
        
        $stmt = $this->conn->prepare("INSERT INTO tags (name) VALUES (?)");
        $stmt->bind_param('s', $name);
        
        if ($stmt->execute()) {
            return $this->getById($this->conn->insert_id);
        }
        
        throw new Exception('Failed to create tag: ' . $this->conn->error);
    }
    
    /**
     * Update tag
     */
    public function update($id, $name) {
        // Check if new name already exists
        $stmt = $this->conn->prepare("SELECT id FROM tags WHERE name = ? AND id != ?");
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception('Tag name already exists');
        }
        
        $stmt = $this->conn->prepare("UPDATE tags SET name = ? WHERE id = ?");
        $stmt->bind_param('si', $name, $id);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return $this->getById($id);
        }
        
        return null;
    }
    
    /**
     * Delete tag
     */
    public function delete($id) {
        // Delete tag associations first
        $stmt = $this->conn->prepare("DELETE FROM quote_tags WHERE tag_id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        // Delete tag
        $stmt = $this->conn->prepare("DELETE FROM tags WHERE id = ?");
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return true;
        }
        
        return false;
    }
}

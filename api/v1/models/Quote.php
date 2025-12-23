<?php

/**
 * Quote Model
 * 
 * Handles all database operations for quotes including:
 * - CRUD operations
 * - Relationships (tags, characters, images, sketch info, videos)
 * - Filtering and searching
 */
class Quote {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Get all quotes with optional filters
     * 
     * @param array $filters Optional filters (status_id, sketch_info_id, tag, character, limit, offset)
     * @return array Array of quotes
     */
    public function getAll($filters = []) {
        $query = "SELECT q.* 
                  FROM quotes q
                  WHERE 1=1";
        
        $params = [];
        $types = '';
        
        // Apply filters
        if (!empty($filters['status_id'])) {
            $query .= " AND q.status_id = ?";
            $params[] = $filters['status_id'];
            $types .= 'i';
        }
        
        if (!empty($filters['sketch_info_id'])) {
            $query .= " AND q.sketch_info_id = ?";
            $params[] = $filters['sketch_info_id'];
            $types .= 'i';
        }
        
        if (!empty($filters['tag'])) {
            $query .= " AND q.id IN (
                SELECT qt.quote_id FROM quote_tags qt
                INNER JOIN tags t ON qt.tag_id = t.id
                WHERE t.slug = ?
            )";
            $params[] = $filters['tag'];
            $types .= 's';
        }
        
        if (!empty($filters['character'])) {
            $query .= " AND q.id IN (
                SELECT qc.quote_id FROM quote_characters qc
                INNER JOIN characters c ON qc.character_id = c.id
                WHERE c.id = ?
            )";
            $params[] = $filters['character'];
            $types .= 'i';
        }
        
        if (!empty($filters['search'])) {
            $query .= " AND q.quote LIKE ?";
            $params[] = '%' . $filters['search'] . '%';
            $types .= 's';
        }
        
        // Order by
        $query .= " ORDER BY q.created_at DESC";
        
        // Limit and offset
        if (!empty($filters['limit'])) {
            $query .= " LIMIT ?";
            $params[] = (int)$filters['limit'];
            $types .= 'i';
            
            if (!empty($filters['offset'])) {
                $query .= " OFFSET ?";
                $params[] = (int)$filters['offset'];
                $types .= 'i';
            }
        }
        
        // Prepare and execute
        if (!empty($params)) {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->conn->query($query);
        }
        
        if (!$result) {
            throw new Exception('Query failed: ' . $this->conn->error);
        }
        
        $quotes = [];
        while ($row = $result->fetch_assoc()) {
            $quotes[] = $this->formatQuote($row);
        }
        
        return $quotes;
    }
    
    /**
     * Get quote by ID
     * 
     * @param int $id Quote ID
     * @return array|null Quote data or null if not found
     */
    public function getById($id) {
        $stmt = $this->conn->prepare(
            "SELECT q.* FROM quotes q WHERE q.id = ?"
        );
        
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $this->formatQuote($row);
        }
        
        return null;
    }
    
    /**
     * Get quote by slug
     * 
     * @param string $slug Quote slug
     * @return array|null Quote data or null if not found
     */
    public function getBySlug($slug) {
        $stmt = $this->conn->prepare(
            "SELECT q.* FROM quotes q WHERE q.slug = ?"
        );
        
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $this->formatQuote($row);
        }
        
        return null;
    }
    
    /**
     * Get today's quote (based on date_posted)
     * 
     * @return array|null Quote data or null if not found
     */
    public function getToday() {
        $today = date('Y-m-d');
        
        $stmt = $this->conn->prepare(
            "SELECT q.* 
             FROM quotes q
             WHERE q.date_posted = ? 
             AND q.status_id = 1
             LIMIT 1"
        );
        
        $stmt->bind_param('s', $today);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $this->formatQuote($row);
        }
        
        return null;
    }
    
    /**
     * Get random quote
     * 
     * @return array|null Quote data or null if not found
     */
    public function getRandom() {
        $query = "SELECT q.* 
                  FROM quotes q
                  WHERE q.status_id = 1
                  ORDER BY RAND()
                  LIMIT 1";
        
        $result = $this->conn->query($query);
        
        if ($row = $result->fetch_assoc()) {
            return $this->formatQuote($row);
        }
        
        return null;
    }
    
    /**
     * Create new quote
     * 
     * @param array $data Quote data
     * @return array Created quote
     */
    public function create($data) {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['quote']);
        }
        
        $stmt = $this->conn->prepare(
            "INSERT INTO quotes 
            (slug, quote, status_id, static_image_id, gif_image_id, sketch_info_id, 
             video_id, date_posted, created_by) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        $statusId = $data['status_id'] ?? 1;
        $staticImageId = $data['static_image_id'] ?? null;
        $gifImageId = $data['gif_image_id'] ?? null;
        $sketchInfoId = $data['sketch_info_id'] ?? null;
        $videoId = $data['video_id'] ?? null;
        $datePosted = $data['date_posted'] ?? null;
        $createdBy = $data['created_by'] ?? null;
        
        $stmt->bind_param(
            'ssiiiissi',
            $data['slug'],
            $data['quote'],
            $statusId,
            $staticImageId,
            $gifImageId,
            $sketchInfoId,
            $videoId,
            $datePosted,
            $createdBy
        );
        
        if ($stmt->execute()) {
            $id = $this->conn->insert_id;
            
            // Add tags if provided
            if (!empty($data['tags'])) {
                $this->syncTags($id, $data['tags']);
            }
            
            // Add characters if provided
            if (!empty($data['characters'])) {
                $this->syncCharacters($id, $data['characters']);
            }
            
            return $this->getById($id);
        }
        
        throw new Exception('Failed to create quote: ' . $this->conn->error);
    }
    
    /**
     * Update quote
     * 
     * @param int $id Quote ID
     * @param array $data Quote data
     * @param bool $partial Whether this is a partial update (PATCH)
     * @return array Updated quote
     */
    public function update($id, $data, $partial = false) {
        if ($partial) {
            // PATCH - only update provided fields
            $fields = [];
            $types = '';
            $values = [];
            
            $allowedFields = [
                'slug' => 's',
                'quote' => 's',
                'status_id' => 'i',
                'static_image_id' => 'i',
                'gif_image_id' => 'i',
                'sketch_info_id' => 'i',
                'video_id' => 'i',
                'date_posted' => 's',
                'updated_by' => 'i'
            ];
            
            foreach ($allowedFields as $field => $type) {
                if (array_key_exists($field, $data)) {
                    $fields[] = "$field = ?";
                    $types .= $type;
                    $values[] = $data[$field];
                }
            }
            
            if (empty($fields)) {
                throw new Exception('No valid fields to update');
            }
            
            $query = "UPDATE quotes SET " . implode(', ', $fields) . " WHERE id = ?";
            $types .= 'i';
            $values[] = $id;
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$values);
        } else {
            // PUT - update all fields
            $stmt = $this->conn->prepare(
                "UPDATE quotes 
                 SET slug = ?, quote = ?, status_id = ?, static_image_id = ?, 
                     gif_image_id = ?, sketch_info_id = ?, video_id = ?, 
                     date_posted = ?, updated_by = ?
                 WHERE id = ?"
            );
            
            $statusId = $data['status_id'] ?? 1;
            $staticImageId = $data['static_image_id'] ?? null;
            $gifImageId = $data['gif_image_id'] ?? null;
            $sketchInfoId = $data['sketch_info_id'] ?? null;
            $videoId = $data['video_id'] ?? null;
            $datePosted = $data['date_posted'] ?? null;
            $updatedBy = $data['updated_by'] ?? null;
            
            $stmt->bind_param(
                'ssiiiissii',
                $data['slug'],
                $data['quote'],
                $statusId,
                $staticImageId,
                $gifImageId,
                $sketchInfoId,
                $videoId,
                $datePosted,
                $updatedBy,
                $id
            );
        }
        
        if ($stmt->execute()) {
            // Update tags if provided
            if (isset($data['tags'])) {
                $this->syncTags($id, $data['tags']);
            }
            
            // Update characters if provided
            if (isset($data['characters'])) {
                $this->syncCharacters($id, $data['characters']);
            }
            
            return $this->getById($id);
        }
        
        throw new Exception('Failed to update quote: ' . $this->conn->error);
    }
    
    /**
     * Delete quote
     * 
     * @param int $id Quote ID
     * @return bool True if deleted
     */
    public function delete($id) {
        // Tags and characters will be deleted automatically (CASCADE)
        $stmt = $this->conn->prepare("DELETE FROM quotes WHERE id = ?");
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Sync tags for a quote
     * 
     * @param int $quoteId Quote ID
     * @param array|string $tags Array of tag IDs or comma-separated tag names
     */
    private function syncTags($quoteId, $tags) {
        // Delete existing tags
        $stmt = $this->conn->prepare("DELETE FROM quote_tags WHERE quote_id = ?");
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        
        // Add new tags
        if (!empty($tags)) {
            // Handle both array and comma-separated string
            if (is_string($tags)) {
                $tags = explode(',', $tags);
            }
            
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (empty($tag)) continue;
                
                // Check if it's a tag ID (numeric) or tag name
                if (is_numeric($tag)) {
                    $tagId = (int)$tag;
                } else {
                    // Get or create tag by name
                    $tagId = $this->getOrCreateTag($tag);
                }
                
                // Associate tag with quote
                $stmt = $this->conn->prepare(
                    "INSERT IGNORE INTO quote_tags (quote_id, tag_id) VALUES (?, ?)"
                );
                $stmt->bind_param('ii', $quoteId, $tagId);
                $stmt->execute();
            }
        }
    }
    
    /**
     * Sync characters for a quote
     * 
     * @param int $quoteId Quote ID
     * @param array $characters Array of character IDs
     */
    private function syncCharacters($quoteId, $characters) {
        // Delete existing characters
        $stmt = $this->conn->prepare("DELETE FROM quote_characters WHERE quote_id = ?");
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        
        // Add new characters
        if (!empty($characters)) {
            foreach ($characters as $characterId) {
                if (is_array($characterId)) {
                    $characterId = $characterId['id'] ?? $characterId['character_id'];
                }
                
                $stmt = $this->conn->prepare(
                    "INSERT IGNORE INTO quote_characters (quote_id, character_id) 
                     VALUES (?, ?)"
                );
                $stmt->bind_param('ii', $quoteId, $characterId);
                $stmt->execute();
            }
        }
    }
    
    /**
     * Get or create tag by name
     * 
     * @param string $name Tag name
     * @return int Tag ID
     */
    private function getOrCreateTag($name) {
        $slug = $this->slugify($name);
        
        // Check if tag exists
        $stmt = $this->conn->prepare("SELECT id FROM tags WHERE slug = ?");
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        
        // Create new tag
        $stmt = $this->conn->prepare("INSERT INTO tags (name, slug) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $slug);
        $stmt->execute();
        
        return $this->conn->insert_id;
    }
    
    /**
     * Format quote with all relationships
     * 
     * @param array $row Raw database row
     * @return array Formatted quote
     */
    private function formatQuote($row) {
        $quoteId = (int)$row['id'];
        
        // Get tags
        $tags = $this->getQuoteTags($quoteId);
        
        // Get characters
        $characters = $this->getQuoteCharacters($quoteId);
        
        // Get related entities
        $status = $this->getStatus($row['status_id']);
        $staticImage = $row['static_image_id'] ? $this->getImage($row['static_image_id']) : null;
        $gifImage = $row['gif_image_id'] ? $this->getImage($row['gif_image_id']) : null;
        $sketchInfo = $row['sketch_info_id'] ? $this->getSketchInfo($row['sketch_info_id']) : null;
        $video = $row['video_id'] ? $this->getVideo($row['video_id']) : null;
        
        return [
            'id' => $quoteId,
            'slug' => $row['slug'],
            'quote' => $row['quote'],
            'status' => $status,
            'static_image' => $staticImage,
            'gif_image' => $gifImage,
            'sketch_info' => $sketchInfo,
            'video' => $video,
            'date_posted' => $row['date_posted'],
            'tags' => $tags,
            'characters' => $characters,
            'created_at' => $row['created_at'],
            'created_by' => $row['created_by'],
            'updated_at' => $row['updated_at'],
            'updated_by' => $row['updated_by']
        ];
    }
    
    /**
     * Get tags for a quote
     * 
     * @param int $quoteId Quote ID
     * @return array Array of tags
     */
    private function getQuoteTags($quoteId) {
        $stmt = $this->conn->prepare(
            "SELECT t.id, t.name, t.slug 
             FROM tags t
             INNER JOIN quote_tags qt ON t.id = qt.tag_id
             WHERE qt.quote_id = ?
             ORDER BY t.name"
        );
        
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'slug' => $row['slug']
            ];
        }
        
        return $tags;
    }
    
    /**
     * Get characters for a quote
     * 
     * @param int $quoteId Quote ID
     * @return array Array of characters
     */
    private function getQuoteCharacters($quoteId) {
        $stmt = $this->conn->prepare(
            "SELECT c.id, c.name, c.actor
             FROM characters c
             INNER JOIN quote_characters qc ON c.id = qc.character_id
             WHERE qc.quote_id = ?
             ORDER BY c.name"
        );
        
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $characters = [];
        while ($row = $result->fetch_assoc()) {
            $characters[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'actor' => $row['actor']
            ];
        }
        
        return $characters;
    }
    
    /**
     * Get status information
     * 
     * @param int $statusId Status ID
     * @return array|null Status data
     */
    private function getStatus($statusId) {
        if (!$statusId) return null;
        
        $stmt = $this->conn->prepare("SELECT id, name FROM statuses WHERE id = ?");
        $stmt->bind_param('i', $statusId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return [
                'id' => (int)$row['id'],
                'name' => $row['name']
            ];
        }
        
        return null;
    }
    
    /**
     * Get image information
     * 
     * @param int $imageId Image ID
     * @return array|null Image data with full URL
     */
    private function getImage($imageId) {
        if (!$imageId) return null;
        
        $stmt = $this->conn->prepare(
            "SELECT id, filename, alt_text, type FROM images WHERE id = ?"
        );
        $stmt->bind_param('i', $imageId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $subdir = $row['type'] === 'gif' ? 'gifs' : 'images';
            return [
                'id' => (int)$row['id'],
                'filename' => $row['filename'],
                'url' => ASSETS_BASE_URL . $subdir . '/' . $row['filename'],
                'alt_text' => $row['alt_text'],
                'type' => $row['type']
            ];
        }
        
        return null;
    }
    
    /**
     * Get sketch information
     * 
     * @param int $sketchId Sketch ID
     * @return array|null Sketch data
     */
    private function getSketchInfo($sketchId) {
        if (!$sketchId) return null;
        
        $stmt = $this->conn->prepare(
            "SELECT id, sketch_name, episode, season, episode_number, description, link 
             FROM sketch_info WHERE id = ?"
        );
        $stmt->bind_param('i', $sketchId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return [
                'id' => (int)$row['id'],
                'sketch_name' => $row['sketch_name'],
                'episode' => $row['episode'],
                'season' => $row['season'] ? (int)$row['season'] : null,
                'episode_number' => $row['episode_number'] ? (int)$row['episode_number'] : null,
                'description' => $row['description'],
                'link' => $row['link']
            ];
        }
        
        return null;
    }
    
    /**
     * Get video information
     * 
     * @param int $videoId Video ID
     * @return array|null Video data
     */
    private function getVideo($videoId) {
        if (!$videoId) return null;
        
        $stmt = $this->conn->prepare(
            "SELECT id, title, url, platform FROM videos WHERE id = ?"
        );
        $stmt->bind_param('i', $videoId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'url' => $row['url'],
                'platform' => $row['platform']
            ];
        }
        
        return null;
    }
    
    /**
     * Generate slug from text
     * 
     * @param string $text Text to slugify
     * @return string Slug
     */
    private function generateSlug($text) {
        $slug = $this->slugify($text);
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Convert text to slug format
     * 
     * @param string $text Text to slugify
     * @return string Slug
     */
    private function slugify($text) {
        // Convert to lowercase
        $slug = strtolower($text);
        
        // Remove special characters
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        
        // Replace spaces and multiple dashes with single dash
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        
        // Trim dashes from ends
        $slug = trim($slug, '-');
        
        // Limit length
        $slug = substr($slug, 0, 150);
        
        return $slug;
    }
    
    /**
     * Check if slug exists
     * 
     * @param string $slug Slug to check
     * @param int|null $excludeId Quote ID to exclude from check
     * @return bool True if exists
     */
    private function slugExists($slug, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->conn->prepare(
                "SELECT id FROM quotes WHERE slug = ? AND id != ?"
            );
            $stmt->bind_param('si', $slug, $excludeId);
        } else {
            $stmt = $this->conn->prepare(
                "SELECT id FROM quotes WHERE slug = ?"
            );
            $stmt->bind_param('s', $slug);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
}

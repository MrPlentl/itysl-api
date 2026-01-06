<?php

/**
 * Authentication Middleware
 * 
 * Verifies that requests contain the required authentication header
 * to currently block bots and unauthorized access
 */
class AuthMiddleware {
    private $enabled;
    private $requiredHeader;
    private $requiredValue;
    private $whitelist;
    
    public function __construct() {
        $this->enabled = getenv('AUTH_ENABLED') === 'true';
        $this->requiredHeader = getenv('AUTH_HEADER_NAME') ?: 'X-ITYSL-API-Secret';
        $this->requiredValue = getenv('AUTH_HEADER_VALUE') ?: '';
        $this->whitelist = explode(',', getenv('AUTH_WHITELIST_IPS') ?: '');
    }
    
    /**
     * Verify authentication
     * 
     * @return bool True if authenticated
     */
    public function verify() {
        // If auth is disabled, allow all
        if (!$this->enabled) {
            return true;
        }
        
        // Check IP whitelist
        if ($this->isWhitelisted()) {
            return true;
        }
        
        // Check for required header
        $headerKey = $this->getServerHeaderKey($this->requiredHeader);
        $headerValue = $_SERVER[$headerKey] ?? null;
        
        // Header not present
        if ($headerValue === null) {
            $this->unauthorized('Missing authentication header');
            return false;
        }
        
        // Header value doesn't match
        if ($headerValue !== $this->requiredValue) {
            $this->unauthorized('Invalid authentication credentials');
            return false;
        }
        
        return true;
    }
    
    /**
     * Check if request is from whitelisted IP
     * 
     * @return bool
     */
    private function isWhitelisted() {
        if (empty($this->whitelist[0])) {
            return false;
        }
        
        $ip = $this->getClientIP();
        return in_array($ip, $this->whitelist);
    }
    
    /**
     * Get client IP address
     * 
     * @return string
     */
    private function getClientIP() {
        $headers = [
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_FORWARDED_FOR',  // Proxy
            'HTTP_X_REAL_IP',        // Nginx
            'REMOTE_ADDR'            // Direct connection
        ];
        
        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                // Handle comma-separated IPs (take first one)
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                return $ip;
            }
        }
        
        return 'unknown';
    }
    
    /**
     * Convert header name to $_SERVER key format
     * 
     * @param string $header Header name (e.g., X-API-Secret)
     * @return string Server key (e.g., HTTP_X_API_SECRET)
     */
    private function getServerHeaderKey($header) {
        // Convert X-API-Secret to HTTP_X_API_SECRET
        $key = strtoupper(str_replace('-', '_', $header));
        return 'HTTP_' . $key;
    }
    
    /**
     * Send unauthorized response
     * 
     * @param string $message Error message
     */
    private function unauthorized($message = 'Unauthorized') {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $message,
            'error' => 'unauthorized'
        ], JSON_PRETTY_PRINT);
        exit();
    }
}

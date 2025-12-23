<?php

class Response {
    
    /**
     * Send JSON response
     */
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit();
    }
    
    /**
     * Send plain text response
     */
    public static function text($text, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: text/plain');
        echo $text;
        exit();
    }
    
    /**
     * Send success response
     */
    public static function success($data, $message = 'Success', $statusCode = 200) {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
    
    /**
     * Send error response
     */
    public static function error($message, $statusCode = 400, $errors = null) {
        $response = [
            'success' => false,
            'message' => $message
        ];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        self::json($response, $statusCode);
    }
    
    /**
     * Check Accept header and respond accordingly
     */
    public static function respond($data, $plainTextField = 'quote') {
        $acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';
        
        if (strpos($acceptHeader, 'text/plain') !== false) {
            // Return plain text
            $text = is_array($data) && isset($data[$plainTextField]) 
                ? $data[$plainTextField] 
                : (is_string($data) ? $data : 'No text available');
            self::text($text);
        } else {
            // Return JSON
            self::success($data);
        }
    }
}

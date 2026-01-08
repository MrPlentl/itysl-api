<?php

/**
 * Simple Router Class
 * 
 * Handles routing of HTTP requests to appropriate handlers
 */
class Router {
    private $routes = [];
    private $basePath = '/api/v1';
    
    /**
     * Add a GET route
     */
    public function get($pattern, $handler) {
        $this->addRoute('GET', $pattern, $handler);
    }
    
    /**
     * Add a POST route
     */
    public function post($pattern, $handler) {
        $this->addRoute('POST', $pattern, $handler);
    }
    
    /**
     * Add a PUT route
     */
    public function put($pattern, $handler) {
        $this->addRoute('PUT', $pattern, $handler);
    }
    
    /**
     * Add a PATCH route
     */
    public function patch($pattern, $handler) {
        $this->addRoute('PATCH', $pattern, $handler);
    }
    
    /**
     * Add a DELETE route
     */
    public function delete($pattern, $handler) {
        $this->addRoute('DELETE', $pattern, $handler);
    }
    
    /**
     * Add a route for any method
     */
    public function any($pattern, $handler) {
        $this->addRoute('ANY', $pattern, $handler);
    }
    
    /**
     * Add a route
     */
    private function addRoute($method, $pattern, $handler) {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }
    
    /**
     * Dispatch the request
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path
        $uri = str_replace($this->basePath, '', $uri);
        $uri = '/' . trim($uri, '/');
        
        // Find matching route
        foreach ($this->routes as $route) {
            // Check method
            if ($route['method'] !== 'ANY' && $route['method'] !== $method) {
                continue;
            }
            
            // Check pattern
            $params = $this->matchPattern($route['pattern'], $uri);
            if ($params !== false) {
                // Execute handler
                $handler = $route['handler'];
                
                if (is_callable($handler)) {
                    // Closure
                    call_user_func_array($handler, $params);
                } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                    // Controller@method format
                    list($controller, $method) = explode('@', $handler);
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $method], $params);
                } elseif (is_array($handler)) {
                    // [Controller::class, 'method'] format
                    list($controller, $method) = $handler;
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $method], $params);
                }
                
                return;
            }
        }
        
        // No route found
        Response::error('Resource not found', 404);
    }
    
    /**
     * Match pattern against URI
     */
    private function matchPattern($pattern, $uri) {
        // Convert pattern to regex
        // /quotes/{id} becomes /^\/quotes\/([^\/]+)$/
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        
        if (preg_match($regex, $uri, $matches)) {
            array_shift($matches); // Remove full match
            return $matches;
        }
        
        return false;
    }
    
    /**
     * Set base path
     */
    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }
}

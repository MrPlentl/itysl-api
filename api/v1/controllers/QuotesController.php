<?php

class QuotesController {
    private $model;
    
    public function __construct() {
        $this->model = new Quote();
    }
    
    /**
     * GET /api/v1/quotes
     */
    public function getAll() {
        try {
            $quotes = $this->model->getAll();
            Response::success($quotes, 'Quotes retrieved successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api/v1/quotes/{id}
     */
    public function getById($id) {
        try {
            $quote = $this->model->getById($id);
            
            if (!$quote) {
                Response::error('Quote not found', 404);
            }
            
            Response::respond($quote);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api/v1/quotes/today
     */
    public function getToday() {
        try {
            $quote = $this->model->getToday();
            
            if (!$quote) {
                Response::error('No quote found for today', 404);
            }
            
            Response::respond($quote);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api/v1/quotes/random
     */
    public function getRandom() {
        try {
            $quote = $this->model->getRandom();
            
            if (!$quote) {
                Response::error('No quotes available', 404);
            }
            
            Response::respond($quote);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * POST /api/v1/quotes
     */
    public function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validate required fields
            if (empty($data['quote'])) {
                Response::error('Quote text is required', 400);
            }
            
            // Set defaults
            $data['static_img'] = $data['static_img'] ?? null;
            $data['animated_gif'] = $data['animated_gif'] ?? null;
            $data['netflix_link'] = $data['netflix_link'] ?? null;
            $data['episode'] = $data['episode'] ?? null;
            $data['sketch_name'] = $data['sketch_name'] ?? null;
            $data['date_posted'] = $data['date_posted'] ?? date('Y-m-d');
            
            $quote = $this->model->create($data);
            Response::success($quote, 'Quote created successfully', 201);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * PUT /api/v1/quotes/{id}
     * PATCH /api/v1/quotes/{id}
     */
    public function update($id, $partial = false) {
        try {
            if (!$id) {
                Response::error('Quote ID is required', 400);
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            // For PUT, validate all required fields
            if (!$partial && empty($data['quote'])) {
                Response::error('Quote text is required', 400);
            }
            
            $quote = $this->model->update($id, $data, $partial);
            
            if (!$quote) {
                Response::error('Quote not found', 404);
            }
            
            Response::success($quote, 'Quote updated successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * DELETE /api/v1/quotes/{id}
     */
    public function delete($id) {
        try {
            if (!$id) {
                Response::error('Quote ID is required', 400);
            }
            
            $deleted = $this->model->delete($id);
            
            if (!$deleted) {
                Response::error('Quote not found', 404);
            }
            
            Response::success(null, 'Quote deleted successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
}

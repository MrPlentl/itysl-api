<?php

class TagsController {
    private $model;
    
    public function __construct() {
        $this->model = new Tag();
    }
    
    /**
     * GET /api/v1/tags
     */
    public function getAll() {
        try {
            $tags = $this->model->getAll();
            Response::success($tags, 'Tags retrieved successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * GET /api/v1/tags/{id}
     */
    public function getById($id) {
        try {
            $tag = $this->model->getById($id);
            
            if (!$tag) {
                Response::error('Tag not found', 404);
            }
            
            Response::success($tag, 'Tag retrieved successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * POST /api/v1/tags
     */
    public function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['name'])) {
                Response::error('Tag name is required', 400);
            }
            
            $tag = $this->model->create($data['name']);
            Response::success($tag, 'Tag created successfully', 201);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * PUT /api/v1/tags/{id}
     */
    public function update($id) {
        try {
            if (!$id) {
                Response::error('Tag ID is required', 400);
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['name'])) {
                Response::error('Tag name is required', 400);
            }
            
            $tag = $this->model->update($id, $data['name']);
            
            if (!$tag) {
                Response::error('Tag not found', 404);
            }
            
            Response::success($tag, 'Tag updated successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
    
    /**
     * DELETE /api/v1/tags/{id}
     */
    public function delete($id) {
        try {
            if (!$id) {
                Response::error('Tag ID is required', 400);
            }
            
            $deleted = $this->model->delete($id);
            
            if (!$deleted) {
                Response::error('Tag not found', 404);
            }
            
            Response::success(null, 'Tag deleted successfully');
        } catch (Exception $e) {
            Response::error($e->getMessage(), 500);
        }
    }
}

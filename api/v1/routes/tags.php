<?php

/**
 * Tags Routes
 * 
 * All routes related to tags resource
 */

// GET /tags - Get all tags
$router->get('/tags', function() {
    $controller = new TagsController();
    $controller->getAll();
});

// GET /tags/{id} - Get tag by ID
$router->get('/tags/{id}', function($id) {
    $controller = new TagsController();
    $controller->getById($id);
});

// // POST /tags - Create new tag
// $router->post('/tags', function() {
//     $controller = new TagsController();
//     $controller->create();
// });

// // PUT /tags/{id} - Update tag
// $router->put('/tags/{id}', function($id) {
//     $controller = new TagsController();
//     $controller->update($id);
// });

// // DELETE /tags/{id} - Delete tag
// $router->delete('/tags/{id}', function($id) {
//     $controller = new TagsController();
//     $controller->delete($id);
// });

<?php

/**
 * Sketch Info Routes
 * 
 * All routes related to sketch_info resource
 */

// GET /sketches - Get all sketches
$router->get('/sketches', function() {
    $controller = new SketchesController();
    $controller->getAll();
});

// GET /sketches/{id} - Get sketch by ID
$router->get('/sketches/{id}', function($id) {
    $controller = new SketchesController();
    $controller->getById($id);
});

// GET /sketches/{id}/quotes - Get all quotes for a sketch
$router->get('/sketches/{id}/quotes', function($id) {
    $controller = new SketchesController();
    $controller->getQuotes($id);
});

// // POST /sketches - Create new sketch
// $router->post('/sketches', function() {
//     $controller = new SketchesController();
//     $controller->create();
// });

// // PUT /sketches/{id} - Update sketch
// $router->put('/sketches/{id}', function($id) {
//     $controller = new SketchesController();
//     $controller->update($id);
// });

// // DELETE /sketches/{id} - Delete sketch
// $router->delete('/sketches/{id}', function($id) {
//     $controller = new SketchesController();
//     $controller->delete($id);
// });

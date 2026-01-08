<?php

/**
 * Characters Routes
 * 
 * All routes related to characters resource
 */

// GET /characters - Get all characters
$router->get('/characters', function() {
    $controller = new CharactersController();
    $controller->getAll();
});

// GET /characters/{id} - Get character by ID
$router->get('/characters/{id}', function($id) {
    $controller = new CharactersController();
    $controller->getById($id);
});

// // POST /characters - Create new character
// $router->post('/characters', function() {
//     $controller = new CharactersController();
//     $controller->create();
// });

// // PUT /characters/{id} - Update character
// $router->put('/characters/{id}', function($id) {
//     $controller = new CharactersController();
//     $controller->update($id);
// });

// // DELETE /characters/{id} - Delete character
// $router->delete('/characters/{id}', function($id) {
//     $controller = new CharactersController();
//     $controller->delete($id);
// });

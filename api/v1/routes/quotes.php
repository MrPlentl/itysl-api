<?php

/**
 * Quotes Routes
 * 
 * All routes related to quotes resource
 */

// GET /quotes - Get all quotes
$router->get('/quotes', function() {
    $controller = new QuotesController();
    $controller->getAll();
});

// GET /quotes/today - Get today's quote (must be before /{id})
$router->get('/quotes/today', function() {
    $controller = new QuotesController();
    $controller->getToday();
});

// GET /quotes/random - Get random quote
$router->get('/quotes/random', function() {
    $controller = new QuotesController();
    $controller->getRandom();
});

// GET /quotes/{id} - Get quote by ID
$router->get('/quotes/{id}', function($id) {
    $controller = new QuotesController();
    $controller->getById($id);
});

// POST /quotes - Create new quote
$router->post('/quotes', function() {
    $controller = new QuotesController();
    $controller->create();
});

// PUT /quotes/{id} - Update quote (full)
$router->put('/quotes/{id}', function($id) {
    $controller = new QuotesController();
    $controller->update($id, false);
});

// PATCH /quotes/{id} - Update quote (partial)
$router->patch('/quotes/{id}', function($id) {
    $controller = new QuotesController();
    $controller->update($id, true);
});

// DELETE /quotes/{id} - Delete quote
$router->delete('/quotes/{id}', function($id) {
    $controller = new QuotesController();
    $controller->delete($id);
});

// Alternative syntax using Controller@method format:
// $router->get('/quotes', 'QuotesController@getAll');
// $router->get('/quotes/{id}', 'QuotesController@getById');

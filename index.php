<?php
/**
 * Punto de entrada de la aplicación
 */

// Cargar configuración
require_once __DIR__ . '/config/app.php';

// Cargar clases core
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';

// Inicializar router
$router = new Router();

// Rutas públicas
$router->get('/', 'PublicController@index');
$router->get('/convocatoria/{id}', 'PublicController@show');
$router->get('/perfil/{id}/aplicar', 'PublicController@aplicar');
$router->post('/postular', 'PublicController@postular');

// Rutas de autenticación
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Rutas de administración - Dashboard
$router->get('/admin/dashboard', 'DashboardController@index');

// Rutas de administración - Convocatorias
$router->get('/admin/convocatorias', 'ConvocatoriaController@index');
$router->get('/admin/convocatorias/create', 'ConvocatoriaController@create');
$router->post('/admin/convocatorias/store', 'ConvocatoriaController@store');
$router->get('/admin/convocatorias/{id}/edit', 'ConvocatoriaController@edit');
$router->post('/admin/convocatorias/{id}/update', 'ConvocatoriaController@update');
$router->get('/admin/convocatorias/{id}/delete', 'ConvocatoriaController@delete');
$router->get('/admin/convocatorias/{id}/postulaciones', 'ConvocatoriaController@postulaciones');
$router->post('/admin/convocatorias/postulacion/update', 'ConvocatoriaController@updatePostulacion');

// Rutas de administración - Áreas
$router->get('/admin/areas', 'AreaController@index');
$router->post('/admin/areas/store', 'AreaController@store');
$router->post('/admin/areas/{id}/update', 'AreaController@update');
$router->get('/admin/areas/{id}/delete', 'AreaController@delete');

// Rutas de administración - Carreras
$router->get('/admin/carreras', 'CarreraController@index');
$router->post('/admin/carreras/store', 'CarreraController@store');
$router->post('/admin/carreras/{id}/update', 'CarreraController@update');
$router->get('/admin/carreras/{id}/delete', 'CarreraController@delete');

// Rutas de administración - Perfiles
$router->get('/admin/convocatorias/{id}/perfiles', 'PerfilController@list');
$router->get('/admin/convocatorias/{id}/perfiles/create', 'PerfilController@create');
$router->post('/admin/convocatorias/{id}/perfiles/store', 'PerfilController@store');
$router->get('/admin/perfiles/{id}/edit', 'PerfilController@edit');
$router->post('/admin/perfiles/{id}/update', 'PerfilController@update');
$router->get('/admin/perfiles/{id}/delete', 'PerfilController@delete');
$router->get('/admin/perfiles/{id}/postulaciones', 'PerfilController@postulaciones');

// Manejar ruta no encontrada
$router->notFound(function() {
    http_response_code(404);
    echo '<h1>404 - Página no encontrada</h1>';
    echo '<p><a href="' . APP_URL . '/">Volver al inicio</a></p>';
});

// Ejecutar router
$router->dispatch();

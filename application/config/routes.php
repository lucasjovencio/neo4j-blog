<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/* Rotas de Categoria no Painel ADMIN */

$route['admin/categoria/(:num)'] = 'admin/categoria/$1'; //rota para inserção de categoria
$route['admin/categoria/alterar/(:any)'] = 'admin/alterar_categoria/$1';

/* FIM */

/* PUblicacao ADM */
$route['admin/publicacao/(:num)/(:any)'] = 'admin/publicacao/$1/$2';
$route['admin/publicar/(:any)'] = 'admin/publicar/$1';
/* FIM */

/* PUblicacao Geral */

$route['publicacao/(:num)/(:any)'] = 'home/publicacao/$1/$2';

/* FIM */

/* Categoria Geral */

$route['categoria/(:any)/(:num)'] = 'home/categoria/$1/$2';

$route['categoria/(:any)/(:num)/(:num)'] = 'home/categoria/$1/$2/$3';

/* FIM */

$route['sobrenos'] = 'home/sobrenos';
$route['autor/(:num)/(:any)'] = 'home/autor/$1/$2';


/* Rotas para Usuarios ADM */

$route['admin/perfil'] = 'admin/perfil';
$route['admin/usuarios/alterar_usuario'] 		= 'admin/salvar_alteracoes_usuario';
$route['admin/desativar_usuario/(:any)'] 		= 'admin/desativar_usuario/$1';
$route['admin/ativar_usuario/(:any)'] 			= 'admin/ativar_usuario/$1';
$route['admin/perfil/salvar_alteracoes_perfil'] = 'admin/salvar_alteracoes_perfil';



$route['admin/login'] = 'admin/pag_login';



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
$route['default_controller'] = 'main';
$route['404_override'] = 'errors/e404';
$route['translate_uri_dashes'] = FALSE;

/* Anúncios */
$route['anuncios'] = 'ads';
$route['anuncios/categoria/(:num)'] = 'ads/category/$1';
$route['anuncios/estado/(:any)'] = 'ads/state/$1';
$route['anuncio/(:any)'] = 'ads/route/$1';
$route['anunciar'] = 'announce';

/* Lojas */
$route['lojas'] = 'shops';
$route['loja/(:any)'] = 'shops/route/$1';
$route['loja/categoria/(:num)'] = 'shops/category/$1';

/* Area do Cliente */
$route['cliente'] = 'profile';
$route['cliente/painel'] = 'profile/dashboard';
$route['cliente/detalhes'] = 'profile/details';
$route['cliente/loja'] = 'profile/shop/edit';
$route['cliente/favoritos'] = 'profile/favorites';
$route['cliente/sair'] = 'login/out';
$route['cliente/depoimento'] = 'profile/testimony';
$route['cliente/chat'] = 'profile/chat/0';

/* Outros */
$route['ajuda/(:any)'] = 'pages/route/$1';
$route['contato'] = 'pages/contact';
$route['depoimentos'] = 'testimonials';
$route['depoimentos/page'] = 'testimonials';
$route['depoimentos/page/(:num)'] = 'testimonials';
$route['manutencao'] = 'maintenance';

/** Chat */
$route['chat'] = 'profile/chat/0';
$route['chat/getChatsByAd/(:num)*'] = 'profile/chat/$1';
$route['chat/listMessages/(:num)'] = 'chat/listMessages/$1';
$route['chat/listChatsByAd/(:num)'] = 'chat/listChatsByAd/$1';
$route['chat/sendMessage'] = 'chat/sendMessage';

/** Endereço */
$route['address/getByCep/(:num){8}'] = 'address/getAddressByCep/$1';
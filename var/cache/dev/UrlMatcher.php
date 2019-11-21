<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/client' => [[['_route' => 'client_index', '_controller' => 'App\\Controller\\ClientController::index'], null, ['GET' => 0], null, true, false, null]],
        '/client/new' => [[['_route' => 'client_new', '_controller' => 'App\\Controller\\ClientController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/regions' => [[['_route' => 'regions', '_controller' => 'App\\Controller\\GetRegionsController::index'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'home', '_controller' => 'App\\Controller\\IndexPageController::index'], null, null, null, false, false, null]],
        '/region' => [[['_route' => 'region_index', '_controller' => 'App\\Controller\\RegionController::index'], null, ['GET' => 0], null, true, false, null]],
        '/region/new' => [[['_route' => 'region_new', '_controller' => 'App\\Controller\\RegionController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, null, null, false, false, null]],
        '/reservation' => [[['_route' => 'reservation_index', '_controller' => 'App\\Controller\\ReservationController::index'], null, ['GET' => 0], null, true, false, null]],
        '/reservation/new' => [[['_route' => 'reservation_new', '_controller' => 'App\\Controller\\ReservationController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/room' => [[['_route' => 'room_index', '_controller' => 'App\\Controller\\RoomController::index'], null, ['GET' => 0], null, true, false, null]],
        '/room/new' => [[['_route' => 'room_new', '_controller' => 'App\\Controller\\RoomController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/unavaibility' => [[['_route' => 'unavaibility_index', '_controller' => 'App\\Controller\\UnavaibilityController::index'], null, ['GET' => 0], null, true, false, null]],
        '/unavaibility/new' => [[['_route' => 'unavaibility_new', '_controller' => 'App\\Controller\\UnavaibilityController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/client/([^/]++)(?'
                    .'|(*:188)'
                    .'|/edit(*:201)'
                    .'|(*:209)'
                .')'
                .'|/r(?'
                    .'|e(?'
                        .'|gion(?'
                            .'|s/([^/]++)(*:244)'
                            .'|/([^/]++)(?'
                                .'|(*:264)'
                                .'|/edit(*:277)'
                                .'|(*:285)'
                            .')'
                        .')'
                        .'|servation/([^/]++)(?'
                            .'|(*:316)'
                            .'|/edit(*:329)'
                            .'|(*:337)'
                        .')'
                    .')'
                    .'|oom/([^/]++)(?'
                        .'|(*:362)'
                        .'|/(?'
                            .'|edit(*:378)'
                            .'|([^/]++)/likes(*:400)'
                        .')'
                        .'|(*:409)'
                    .')'
                .')'
                .'|/unavaibility/([^/]++)(?'
                    .'|(*:444)'
                    .'|/edit(*:457)'
                    .'|(*:465)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_twig_error_test', '_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception::showAction'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception::cssAction'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        188 => [[['_route' => 'client_show', '_controller' => 'App\\Controller\\ClientController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        201 => [[['_route' => 'client_edit', '_controller' => 'App\\Controller\\ClientController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        209 => [[['_route' => 'client_delete', '_controller' => 'App\\Controller\\ClientController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        244 => [[['_route' => 'region_announces', '_controller' => 'App\\Controller\\RegionAnnouncesController::index'], ['id_region'], null, null, false, true, null]],
        264 => [[['_route' => 'region_show', '_controller' => 'App\\Controller\\RegionController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        277 => [[['_route' => 'region_edit', '_controller' => 'App\\Controller\\RegionController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        285 => [[['_route' => 'region_delete', '_controller' => 'App\\Controller\\RegionController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        316 => [[['_route' => 'reservation_show', '_controller' => 'App\\Controller\\ReservationController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        329 => [[['_route' => 'reservation_edit', '_controller' => 'App\\Controller\\ReservationController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        337 => [[['_route' => 'reservation_delete', '_controller' => 'App\\Controller\\ReservationController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        362 => [[['_route' => 'room_show', '_controller' => 'App\\Controller\\RoomController::show'], ['id'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        378 => [[['_route' => 'room_edit', '_controller' => 'App\\Controller\\RoomController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        400 => [[['_route' => 'likes', '_controller' => 'App\\Controller\\RoomController::addLike'], ['id_room', 'id_region'], null, null, false, false, null]],
        409 => [[['_route' => 'room_delete', '_controller' => 'App\\Controller\\RoomController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        444 => [[['_route' => 'unavaibility_show', '_controller' => 'App\\Controller\\UnavaibilityController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        457 => [[['_route' => 'unavaibility_edit', '_controller' => 'App\\Controller\\UnavaibilityController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        465 => [
            [['_route' => 'unavaibility_delete', '_controller' => 'App\\Controller\\UnavaibilityController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

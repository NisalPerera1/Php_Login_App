$routes = [
    '/login' => 'AuthController@login',
    '/register' => 'AuthController@register',
    '/logout' => 'AuthController@logout',

];
function route($url, $routes) {
    foreach ($routes as $route => $controller) {
        // Replace {param} placeholders with a regex pattern
        $route = preg_replace('/\{([\w-]+)\}/', '([^\/]+)', $route);
        
        // Match the URL to the route pattern
        if (preg_match("#^$route$#", $url, $matches)) {
            // Extract the controller and method name
            list($controllerName, $methodName) = explode('@', $controller);
            
            // Call the controller method with any parameters
            array_shift($matches); // Remove the full URL match
            call_user_func_array([new $controllerName, $methodName], $matches);
            
            return;
        }
    }
    
    // No route matched
    echo "404 Not Found";
}

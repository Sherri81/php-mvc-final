<?php

namespace Framework;

class Router
{
    // create array to hold routes from route table
    private array $routes = [];

    // create method to add routes from the route table to the routes array
    public function add(string $path, array $params): void
    {
        $this->routes[] = [
            "path" => $path,
            "params" => $params
        ];
    }
    public function matchRoute(string $path): array|bool
    {
        foreach ($this->routes as $route) {
    
            $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";
    
            // add this echo for debugging
            echo $pattern, "\n", $route["path"], "\n";
    
            $this->getURLData($route["path"]);
    
            if (preg_match($pattern, $path, $matches)) {
    
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
    
                return $matches;
            }
        }
    
        return false;
    }
    
private function getURLData(string $route_path)
{
        // separate URL path into segments
    $segments = explode("/", $route_path);

    print_r($segments);

}
}
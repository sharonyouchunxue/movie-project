<?php

class App {
    protected $controller = 'main'; // Default controller
    protected $method = 'index'; // Default method
    protected $special_url = ['apply', 'review']; // Special URLs that default to 'index' method
    protected $params = []; // Parameters for the controller method

    public function __construct() {
        session_start(); 

        // Parse the URL to get controller, method, and parameters
        $url = $this->parseUrl();

        // Check if the controller file exists in the correct directory
        if (isset($url[1]) && file_exists('app/controllers/' . $url[1] . '.php')) {
            $this->controller = $url[1]; // Set the controller
            $_SESSION['controller'] = $this->controller; // Store controller in session

            // If the controller is a special URL, default to 'index' method
            if (in_array($this->controller, $this->special_url)) {
                $this->method = 'index';
            }

            unset($url[1]); // Unset the controller part of the URL
        } 
        // Check if a view file exists directly for the URL
        else if (isset($url[1]) && file_exists('app/views/' . $url[1] . '.php')) {
            require_once 'app/views/' . $url[1] . '.php'; 
            exit; 
        } 
        // If the URL is empty, default to the 'main' controller
        else if (empty($url[1])) {
            $this->controller = 'main';
        } 
        // If none of the above conditions are met, redirect to 'main' controller
        else {
            header('Location: /main');
            die;
        }

        // Require the controller file
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Check if the method exists in the controller
        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2]; // Set the method
                $_SESSION['method'] = $this->method; 
                unset($url[2]); 
            }
        }

        // Get the parameters from the URL
        $this->params = $url ? array_values($url) : [];
        // Call the controller method with the parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Parse the URL to get controller, method, and parameters
    public function parseUrl() {
        // Get the URL without the query string
        $u = strtok($_SERVER['REQUEST_URI'], '?');
        // Split the URL by '/' and filter it
        $url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
        // Remove the first element (empty due to leading '/')
        unset($url[0]);
        return $url;
    }
}
?>

<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: Router.php
*/
class Router
{

    protected $route = [];

    protected $checktipe = [
        'i'  => '[0-9]++',
        'a'  => '[0-9A-Za-z]++',
        'h'  => '[0-9A-Fa-f]++',
        '*'  => '.+?',
        '**' => '.++',
        ''   => '[^/\.]++'
    ];

    public function __construct(array $route = [], array $checktipe = [])
    {
        $this->CallbackRouters($route);
    }

    protected function compiliranput($put)
    {
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $put, $suvpadenia, PREG_SET_ORDER)) {
            $checktipe = $this->checktipe;
            foreach ($suvpadenia as $maching) {
                list($block, $pre, $tip, $param, $optional) = $maching;

                if (isset($checktipe[$tip])) {
                    $tip = $checktipe[$tip];
                }
                if ($pre === '.') {
                    $pre = '\.';
                }

                $optional = $optional !== '' ? '?' : null;
                $paterns = '(?:'
                    . ($pre !== '' ? $pre : null)
                    . '('
                    . $tip
                    . ')'
                    . ')'
                    . $optional;

                $put = str_replace($block, $paterns, $put);
            }
        }
        return "`^$put$`u";
    }

    public function match($url_request = null, $method_request = null)
    {

        $params = [];

        if ($url_request === null) {
            $url_request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        }

        $url_request = $url_request;

        if (($strpos = strpos($url_request, '?')) !== false) {
            $url_request = substr($url_request, 0, $strpos);
        }

        $lastRequestUrlChar = $url_request ? $url_request[strlen($url_request) - 1] : '';

        if ($method_request === null) {
            $method_request = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        }

        foreach ($this->routes as $handler) {
            list($metodi, $put, $object, $names) = $handler;

            $maching_method = (stripos($metodi, $method_request) !== false);

            if (!$maching_method) {
                continue;
            }

            if (($position = strpos($put, '[')) === false) {
                $maching = strcmp($url_request, $put) === 0;
            } else {
                if (strncmp($url_request, $put, $position) !== 0 && ($lastRequestUrlChar === '/' || $put[$position - 1] !== '/')) {
                    continue;
                }

                $regex = $this->compiliranput($put);
                $maching = preg_match($regex, $url_request, $params) === 1;
            }

            if ($maching) {
                if ($params) {
                    foreach ($params as $key => $value) {
                        if (is_numeric($key)) {
                            unset($params[$key]);
                        }
                    }
                }

                return [
                    'object' => $object,
                    'param' => $params,
                    'title' => $names
                ];
            }
        }

        return false;
    }

    public function CallbackRouters($route)
    {
        if (!is_array($route) && !$route instanceof Traversable) {
            throw new RuntimeException('Routes should be an array or an instance of Traversable');
        }
        foreach ($route as $put) {
            call_user_func_array([$this, 'map'], $put);
        }
    }

    public function map($metod, $put, $object, $names = null)
    {

        $this->routes[] = [$metod, $put, $object, $names];

        if ($names) {
            if (isset($this->matchedRouters[$names])) {
                throw new RuntimeException("Not REdeclarated '{$names}'");
            }
            $this->matchedRouters[$names] = $put;
        }

        return;
    }
}

<?php

/**
 * @author Julien Maulny
 * @license MIT
 * @link https://github.com/alcalyn/twig-extension-onpath
 */
namespace Alcalyn\Extension\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Twig extension to print a string depending on current route
 *
 * @author Julien Maulny
 * @license MIT
 * @link https://github.com/alcalyn/twig-extension-onpath
 */
class OnPath extends Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'onpath' => new Twig_Filter_Method($this, 'onpath'),
        );
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
        );
    }

    /**
     * Output the string if we are in one of route of arguments.
     *
     * Example:
     *      onpath('string', 'route_name', 'another_route_name', ...);
     *
     * output 'string' if we are in route_name or another_route_name, or ...
     * else return empty string.
     *
     * @return string
     */
    public function onpath()
    {
        $current_route = $this->requestStack->getMasterRequest()->get('_route');

        $routes = func_get_args();
        $string = array_shift($routes);

        foreach ($routes as $route) {
            if ($route == $current_route) {
                return $string;
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'twig_onpath';
    }
}

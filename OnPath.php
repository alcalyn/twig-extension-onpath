<?php

/**
 * @author Julien Maulny
 * @license MIT
 * @link https://github.com/alcalyn/twig-extension-onpath
 */
namespace Alcalyn\Extension\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Symfony\Component\HttpFoundation\Request;
use Alcalyn\Extension\Twig\Exception\OnPathException;

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
     * @var Request
     */
    private $request;
    
    /**
     * Inject RequestStack service here.
     * For Symfony < 2.4, use setRequest() method instead.
     * 
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $requestStackClass = 'Symfony\\Component\\HttpFoundation\\RequestStack';
        
        if (!class_exists($requestStackClass)) {
            throw new OnPathException(
                'Class '.$requestStackClass.' not found. '
                . 'If you are using Symfony <2.4, use OnPath::setRequest.'
            );
        }
        
        if (!is_object($requestStack) || (get_class($requestStack) !== $requestStackClass)) {
            throw new OnPathException(
                'OnPath::setRequestStack, first argument '
                . 'must be an instance of '.$requestStackClass.', '
                . (is_object($requestStack) ? get_class($requestStack) : gettype($requestStack)).' given.'
            );
        }
        
        $this->request = $requestStack->getMasterRequest();
    }
    
    /**
     * Inject current Request here.
     * 
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
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
        if (null === $this->request) {
            throw new OnPathException(
                'Request is null. '
                . 'You must provide current request to OnPath twig extension '
                . 'by calling setRequestStack, or setRequest for symfony <2.4'
            );
        }
        
        $current_route = $this->request->get('_route');

        $routes = func_get_args();
        $string = array_shift($routes);

        foreach ($routes as $route) {
            if ($route === $current_route) {
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

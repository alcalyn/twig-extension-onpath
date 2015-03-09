<?php

/**
 * @author Julien Maulny
 * @license MIT
 * @link https://github.com/alcalyn/twig-extension-onpath
 */
namespace Alcalyn\Extension\Twig\Exception;

use Exception;

/**
 * Twig extension to print a string depending on current route
 *
 * @author Julien Maulny
 * @license MIT
 * @link https://github.com/alcalyn/twig-extension-onpath
 */
class OnPathException extends Exception
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, 0, null);
    }
}

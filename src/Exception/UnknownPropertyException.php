<?php

namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;

/**
 * Class UnknownPropertyException
 *
 * Represents an exception caused by accessing unknown object properties.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Exception
 */
class UnknownPropertyException extends \Exception  implements ExceptionInterface
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Unknown Property';
    }
}

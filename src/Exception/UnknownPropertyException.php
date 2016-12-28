<?php

namespace SideKit\Ui\Exception;

use SideKit\Ui\Contract\ExceptionInterface;

/**
 * Class UnknownPropertyException
 *
 * Represents an exception caused by accessing unknown object properties.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Exception
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

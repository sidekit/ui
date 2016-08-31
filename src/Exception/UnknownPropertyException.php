<?php

namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;

/**
 * UnknownPropertyException represents an exception caused by accessing unknown object properties.
 *
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

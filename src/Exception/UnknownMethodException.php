<?php

namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;

/**
 * UnknownMethodException represents an exception caused by accessing an unknown object method.
 *
 */
class UnknownMethodException extends \BadMethodCallException implements ExceptionInterface
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Unknown Method';
    }
}

<?php

namespace SideKit\Ui\Exception;

use SideKit\Ui\Contract\ExceptionInterface;

/**
 * Class UnknownMethodException
 *
 * Represents an exception caused by accessing an unknown object method.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Exception
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

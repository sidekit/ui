<?php
namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;


/**
 * Class InvalidArgumentException
 *
 * Represents an exception caused by invalid parameters passed to a method.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Exception
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Invalid Argument Exception';
    }
}

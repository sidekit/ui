<?php
namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;

/**
 * Class InvalidCallException
 *
 * Represents an exception caused by calling a method in a wrong way.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Exception
 */
class InvalidCallException extends \BadMethodCallException implements ExceptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Invalid Call';
    }

}

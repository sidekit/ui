<?php
namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;


/**
 *
 * InvalidArgumentException.php
 *
 * Date: 26/8/16
 * Time: 17:25
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
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

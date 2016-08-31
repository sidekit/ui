<?php
namespace SideKit\Exception;

use SideKit\Contract\ExceptionInterface;

/**
 *
 * InvalidCallException.php
 *
 * Date: 26/8/16
 * Time: 17:44
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
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

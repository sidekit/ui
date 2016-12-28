<?php
namespace SideKit\Ui\Encoder;

use League\Container\Container;
use SideKit\Ui\Exception\InvalidCallException;

/**
 * Class EncodersContainer
 *
 *
 * @method static HtmlEncoder html()
 * @method static JsonEncoder json()
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Encoder
 */
class EncodersContainer
{
    public static function __get($name)
    {
        static $e;
        if ($e === null) {
            $e = self::init();
        }
        if ($name === 'di') {
            return $e;
        } elseif (!$e->has($name)) {
            throw new InvalidCallException("Unrecognized encoder: UiKit::encoders::{$name}.");
        }

        return $e->get($name);
    }

    /**
     * @return Container
     */
    private static function init()
    {
        $container = new Container();

        $container->add('html', 'SideKit\Ui\Encoder\HtmlEncoder');
        $container->add('json', 'SideKit\Ui\Encoder\JsonEncoder');

        return $container;
    }
}

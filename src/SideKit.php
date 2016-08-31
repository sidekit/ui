<?php
namespace SideKit;

use League\Container\Container;
use BadFunctionCallException;
use SideKit\Util\AttributeSorter;
use SideKit\Util\CssHelper;

/**
 * Class SideKit
 *
 * It encapsulates the initialization of SideKit core classes and exposes its functionality through static methods.
 *
 * @method static Container di()
 * @method static Util\Html html()
 * @method static Encoder\EncodersContainer encoders()
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit
 */
class SideKit
{
    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        static $e;
        if ($e === null) {
            $e = self::init();
        }
        if ($name === 'di') {
            return $e;
        } elseif (!$e->has($name)) {
            throw new BadFunctionCallException("Unrecognized function name: SideKit::{$name}.");
        }

        return $e->get($name);
    }

    /**
     * @return Container
     */
    private static function init()
    {
        $container = new Container();

        $container
            ->add('html', 'SideKit\Util\Html')
            ->withArgument(new AttributeSorter())
            ->withArgument(new CssHelper());

        $container->add('json', 'SideKit\Encoder\Json');

        return $container;
    }
}

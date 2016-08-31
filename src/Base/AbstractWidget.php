<?php
namespace SideKit\Base;

use SideKit\Contract\ConfigurableInterface;

/**
 * Class AbstractWidget
 *
 * This the base class for all widgets
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Base
 */
abstract class AbstractWidget implements ConfigurableInterface
{
    use MagicMethodsTrait;

    /**
     * Constructor.
     * The default implementation does two things:
     *
     * - Initializes the object with the given configuration `$config`.
     * - Call [[init()]].
     *
     * If this method is overridden in a child class, it is recommended that
     *
     * - the last parameter of the constructor is a configuration array, like `$config` here.
     * - call the parent implementation at the end of the constructor.
     *
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            foreach ($config as $property => $value) {
                $this->$property = $value;
            }
        }
        $this->init();
    }

    /**
     * Initializes the widget.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
    }

    /**
     * All widgets are required t load
     * @return mixed
     */
    abstract public function render();
}

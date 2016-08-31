<?php
namespace SideKit\Util;

/**
 * Class JsHelper
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Util
 */
class JsHelper
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * JsHelper constructor.
     *
     * @param Uuid $uuid
     */
    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public function generateUniqueVariableName($prefix = '')
    {
        return $prefix . str_replace('-', '', $this->uuid->generate());
    }
}

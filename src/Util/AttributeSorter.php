<?php
namespace SideKit\Util;

/**
 * Class AttributeSorter
 *
 * Sorts the attributes that need to be rendered on a tag
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Util
 */
class AttributeSorter
{
    /**
     * @var array the preferred order of attributes in a tag.
     */
    private $attributeOrder = [
        'type',
        'id',
        'class',
        'name',
        'value',

        'href',
        'src',
        'action',
        'method',

        'selected',
        'checked',
        'readonly',
        'disabled',
        'multiple',

        'size',
        'maxlength',
        'width',
        'height',
        'rows',
        'cols',

        'alt',
        'title',
        'rel',
        'media',
    ];

    /**
     * Sorts the attributes according the specified order [[$attributeOrder]]
     *
     * @param array $attributes
     *
     * @return array
     */
    public function sort(array $attributes)
    {
        if (count($attributes) > 1) {
            $sorted = [];
            foreach ($this->attributeOrder as $name) {
                if (isset($attributes[$name])) {
                    $sorted[$name] = $attributes[$name];
                }
            }
            $attributes = array_merge($sorted, $attributes);
        }

        return $attributes;
    }
}

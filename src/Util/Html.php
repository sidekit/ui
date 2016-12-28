<?php
namespace SideKit\Ui\Util;

/**
 *
 * Class Html
 *
 * Provides concrete implementation for [[Html]].
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Util
 */
class Html
{
    private $attributeSorter;
    private $cssHelper;
    private $jsHelper;

    /**
     * Html constructor.
     *
     * @param AttributeSorter $attributeSorter
     * @param CssHelper $cssHelper
     * @param JsHelper $jsHelper
     */
    public function __construct(AttributeSorter $attributeSorter, CssHelper $cssHelper, JsHelper $jsHelper)
    {
        $this->attributeSorter = $attributeSorter;
        $this->cssHelper = $cssHelper;
        $this->jsHelper = $jsHelper;
    }

    /**
     * Sorts the attributes of a tag element.
     *
     * @param array $attributes
     *
     * @return array
     */
    public function sortTagAttributes(array $attributes)
    {
        return $this->attributeSorter->sort($attributes);
    }

    /**
     * @return CssHelper
     */
    public function css()
    {
        return $this->cssHelper;
    }

    /**
     * @return JsHelper
     */
    public function js()
    {
        return $this->jsHelper;
    }

    /**
     * Generates a complete HTML tag.
     *
     * @param string|boolean|null $name the tag name. If $name is `null` or `false`, the corresponding content will be rendered without any tag.
     * @param string $content the content to be enclosed between the start and end tags. It will not be HTML-encoded.
     * If this is coming from end users, you should consider [[encode()]] it to prevent XSS attacks.
     * @param array $attributes the HTML tag attributes (HTML options) in terms of name-value pairs.
     * These will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     *
     * For example when using `['class' => 'my-class', 'target' => '_blank', 'value' => null]` it will result in the
     * html attributes rendered like this: `class="my-class" target="_blank"`.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated HTML tag
     */
    public function tag($name, $content = '', $attributes = [])
    {
        return (string)(new Tag($name, $content, $attributes));
    }

    /**
     * Generates a style tag.
     *
     * @param string $content the style content
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[HtmlEncoder::encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[Tag::renderAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated style tag
     */
    public static function style($content, $options = [])
    {
        return static::tag('style', $content, $options);
    }

    /**
     * Generates a script tag.
     *
     * @param string $content the script content
     * @param array $attributes the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[HtmlEncoder::encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[Tag::renderAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated script tag
     */
    public function script($content, $attributes = [])
    {
        return $this->tag('script', $content, $attributes);
    }
}

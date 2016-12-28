<?php
namespace SideKit\Ui\Util;

/**
 * Class CssHelper
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Util
 */
class CssHelper
{
    /**
     * Adds a CSS class (or several classes) to the specified options.
     * If the CSS class is already in the options, it will not be added again.
     * If class specification at given options is an array, and some class placed there with the named (string) key,
     * overriding of such key will have no effect. For example:
     *
     * ```php
     * $options = ['class' => ['persistent' => 'initial']];
     * UiKit::html()->css()->addCssClass($options, ['persistent' => 'override']);
     * var_dump($options['class']); // outputs: array('persistent' => 'initial');
     * ```
     *
     * @param array $options the options to be modified.
     * @param string|array $class the CSS class(es) to be added
     */
    public function addCssClass(&$options, $class)
    {
        if (isset($options['class'])) {
            if (is_array($options['class'])) {
                $options['class'] = $this->mergeCssClasses($options['class'], (array)$class);
            } else {
                $classes = preg_split('/\s+/', $options['class'], -1, PREG_SPLIT_NO_EMPTY);
                $options['class'] = implode(' ', $this->mergeCssClasses($classes, (array)$class));
            }
        } else {
            $options['class'] = $class;
        }
    }

    /**
     * Merges already existing CSS classes with new one.
     * This method provides the priority for named existing classes over additional.
     *
     * @param array $existingClasses already existing CSS classes.
     * @param array $additionalClasses CSS classes to be added.
     *
     * @return array merge result.
     */
    private static function mergeCssClasses(array $existingClasses, array $additionalClasses)
    {
        foreach ($additionalClasses as $key => $class) {
            if (is_int($key) && !in_array($class, $existingClasses)) {
                $existingClasses[] = $class;
            } elseif (!isset($existingClasses[$key])) {
                $existingClasses[$key] = $class;
            }
        }

        return array_unique($existingClasses);
    }

    /**
     * Removes a CSS class from the specified options.
     *
     * @param array $options the options to be modified.
     * @param string|array $class the CSS class(es) to be removed
     */
    public static function removeCssClass(&$options, $class)
    {
        if (isset($options['class'])) {
            if (is_array($options['class'])) {
                $classes = array_diff($options['class'], (array)$class);
                if (empty($classes)) {
                    unset($options['class']);
                } else {
                    $options['class'] = $classes;
                }
            } else {
                $classes = preg_split('/\s+/', $options['class'], -1, PREG_SPLIT_NO_EMPTY);
                $classes = array_diff($classes, (array)$class);
                if (empty($classes)) {
                    unset($options['class']);
                } else {
                    $options['class'] = implode(' ', $classes);
                }
            }
        }
    }

    /**
     * Adds the specified CSS style to the HTML options.
     *
     * If the options already contain a `style` element, the new style will be merged
     * with the existing one. If a CSS property exists in both the new and the old styles,
     * the old one may be overwritten if `$overwrite` is true.
     *
     * For example,
     *
     * ```php
     * UiKit::html()->css()->addCssStyle($options, 'width: 100px; height: 200px');
     * ```
     *
     * @param array $options the HTML options to be modified.
     * @param string|array $style the new style string (e.g. `'width: 100px; height: 200px'`) or
     * array (e.g. `['width' => '100px', 'height' => '200px']`).
     * @param boolean $overwrite whether to overwrite existing CSS properties if the new style
     * contain them too.
     *
     * @see removeCssStyle()
     * @see cssStyleFromArray()
     * @see cssStyleToArray()
     */
    public function addCssStyle(&$options, $style, $overwrite = true)
    {
        if (!empty($options['style'])) {
            $oldStyle = is_array($options['style']) ? $options['style'] : $this->cssStyleToArray($options['style']);
            $newStyle = is_array($style) ? $style : $this->cssStyleToArray($style);
            if (!$overwrite) {
                foreach ($newStyle as $property => $value) {
                    if (isset($oldStyle[$property])) {
                        unset($newStyle[$property]);
                    }
                }
            }
            $style = array_merge($oldStyle, $newStyle);
        }
        $options['style'] = is_array($style) ? $this->cssStyleFromArray($style) : $style;
    }

    /**
     * Removes the specified CSS style from the HTML options.
     *
     * For example,
     *
     * ```php
     * UiKit::html()->css()->removeCssStyle($options, ['width', 'height']);
     * ```
     *
     * @param array $options the HTML options to be modified.
     * @param string|array $properties the CSS properties to be removed. You may use a string
     * if you are removing a single property.
     *
     * @see addCssStyle()
     */
    public function removeCssStyle(&$options, $properties)
    {
        if (!empty($options['style'])) {
            $style = is_array($options['style']) ? $options['style'] : $this->cssStyleToArray($options['style']);
            foreach ((array)$properties as $property) {
                unset($style[$property]);
            }
            $options['style'] = $this->cssStyleFromArray($style);
        }
    }

    /**
     * Converts a CSS style array into a string representation.
     *
     * For example,
     *
     * ```php
     * print_r(UiKit::html()->css()->cssStyleFromArray(['width' => '100px', 'height' => '200px']));
     * // will display: 'width: 100px; height: 200px;'
     * ```
     *
     * @param array $style the CSS style array. The array keys are the CSS property names,
     * and the array values are the corresponding CSS property values.
     *
     * @return string the CSS style string. If the CSS style is empty, a null will be returned.
     */
    public function cssStyleFromArray(array $style)
    {
        $result = '';
        foreach ($style as $name => $value) {
            $result .= "$name: $value; ";
        }

        // return null if empty to avoid rendering the "style" attribute
        return $result === '' ? null : rtrim($result);
    }

    /**
     * Converts a CSS style string into an array representation.
     *
     * The array keys are the CSS property names, and the array values
     * are the corresponding CSS property values.
     *
     * For example,
     *
     * ```php
     * print_r(UiKit::html()->css()->cssStyleToArray('width: 100px; height: 200px;'));
     * // will display: ['width' => '100px', 'height' => '200px']
     * ```
     *
     * @param string $style the CSS style string
     *
     * @return array the array representation of the CSS style
     */
    public function cssStyleToArray($style)
    {
        $result = [];
        foreach (explode(';', $style) as $property) {
            $property = explode(':', $property);
            if (count($property) > 1) {
                $result[trim($property[0])] = trim($property[1]);
            }
        }

        return $result;
    }
}

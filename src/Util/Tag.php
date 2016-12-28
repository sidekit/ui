<?php
namespace SideKit\Ui\Util;

use SideKit\Ui\UiKit;

/**
 * Class Tag
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Util
 */
class Tag
{
    /**
     * @var
     */
    private $name;
    /**
     * @var array
     */
    private $attributes = [];
    /**
     * @var
     */
    private $content;
    /**
     * @var array
     */
    private $voidElements = [
        'area' => 1,
        'base' => 1,
        'br' => 1,
        'col' => 1,
        'command' => 1,
        'embed' => 1,
        'hr' => 1,
        'img' => 1,
        'input' => 1,
        'keygen' => 1,
        'link' => 1,
        'meta' => 1,
        'param' => 1,
        'source' => 1,
        'track' => 1,
        'wbr' => 1,
    ];

    /**
     * Tag constructor.
     *
     * @param $name
     * @param $attributes
     * @param $content
     */
    public function __construct($name, $content, $attributes)
    {
        $this->name = $name;
        $this->content = $content;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->name === null || $this->name === false) {
            return $this->content;
        }
        $html = "<{$this->name}" . $this->renderAttributes() . '>';

        return isset($this->voidElements[strtolower($this->name)]) ? $html : "{$html}{$this->content}</{$this->name}>";
    }

    /**
     * @return string
     */
    public function renderAttributes()
    {
        $attributes = UiKit::html()->sortTagAttributes($this->attributes);
        $html = '';
        foreach ($attributes as $name => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html .= " $name";
                }
            } elseif (is_array($value)) {
                if ($name === 'data') {
                    foreach ($value as $n => $v) {
                        if (is_array($v)) {
                            $html .= " $name-$n='" . UiKit::encoders()->json()->htmlEncode($v) . "'";
                        } else {
                            $html .= " $name-$n=\"" . UiKit::encoders()->html()->encode($v) . '"';
                        }
                    }
                } elseif ($name === 'class') {
                    if (empty($value)) {
                        continue;
                    }
                    $html .= " $name=\"" . UiKit::encoders()->html()->encode(implode(' ', $value)) . '"';
                } elseif ($name === 'style') {
                    if (empty($value)) {
                        continue;
                    }
                    $html .= " $name=\"" .
                        UiKit::encoders()->html()->encode(UiKit::html()->css()->cssStyleFromArray($value)) . '"';
                } else {
                    $html .= " $name='" . UiKit::encoders()->json()->htmlEncode($value) . "'";
                }
            } elseif ($value !== null) {
                $html .= " $name=\"" . UiKit::encoders()->html()->encode($value) . '"';
            }
        }

        return $html;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try{
            return $this->render();
        }catch (\Exception $e) {
            var_dump($e); die();
        }

    }
}

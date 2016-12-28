<?php
namespace SideKit\Ui\Encoder;

/**
 * Class HtmlEncoder
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * @package SideKit\Ui\Encoder
 */
class HtmlEncoder
{
    /**
     * Encodes special characters into HTML entities.
     *
     * @param string $content the content to be encoded
     * @param boolean $doubleEncode whether to encode HTML entities in `$content`. If false,
     * HTML entities in `$content` will not be further encoded.
     *
     * @return string the encoded content
     * @see decode()
     * @see http://www.php.net/manual/en/function.htmlspecialchars.php
     */
    public function encode($content, $doubleEncode = true)
    {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }

    /**
     * Decodes special HTML entities back to the corresponding characters.
     * This is the opposite of [[encode()]].
     *
     * @param string $content the content to be decoded
     *
     * @return string the decoded content
     * @see encode()
     * @see http://www.php.net/manual/en/function.htmlspecialchars-decode.php
     */
    public static function decode($content)
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }
}

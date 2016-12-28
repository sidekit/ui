<?php
namespace SideKit\Ui\Contract;

/**
 * Interface ExceptionInterface
 * @package SideKit\Ui\Contract
 */
interface ExceptionInterface
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName();
}

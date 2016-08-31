<?php
namespace SideKit\Contract;

/**
 * Interface ExceptionInterface
 * @package SideKit\Contract
 */
interface ExceptionInterface
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName();
}

<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/24/18
 * Time: 6:22 AM
 */

namespace App\Exception;


class NotABuffetException extends \Exception
{
    protected $message = 'Please do not mix the carnivorous and non-carnivorous dinosaurs. It will be a massacre!';
}
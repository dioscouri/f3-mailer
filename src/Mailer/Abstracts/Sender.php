<?php 
namespace Mailers\Abstracts;

abstract class Sender extends PHPMailer
{
    use \Mailer\Traits\Cleaner;
}
<?php
class MailerBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Mailer';
}
$app = new MailerBootstrap();
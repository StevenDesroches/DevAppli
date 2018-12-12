<?php

namespace Application\Adapter;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;



class EmailAdapter 
{
    public static $instance;
    public $transport;
    
    private function __construct()
    {
        require constant('ROOT') . '/fuck_whodong.php';
        $smtpOptions = new SmtpOptions($options);
        $this->transport = new SmtpTransport($smtpOptions);
    }

    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
        self::$instance = new self();
        }
        return self::$instance;
    }

    public function sendMail(Message $mail) {
        $mail->getHeaders()->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');
        $this->transport->send($mail);
    }
}
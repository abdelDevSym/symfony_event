<?php


namespace App\Subscribers;


use App\Events\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class CommentSubscriber implements EventSubscriberInterface{


    private $_mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->_mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::NAME => 'onProfilePublished'
        ];
    }


    public function onProfilePublished(Events  $event)
    {

        $profile = $event->getProfile();

        $subject = "Bienvenue";
        $body = "Bienvenue mon ami.e sur ce tutorial";

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($profile->getUsername())
            ->setFrom('abdelaziz.aitidir11@gmail.com')
            ->setBody($body, 'text/html')
        ;

        $this->_mailer->send($message);

    }


}
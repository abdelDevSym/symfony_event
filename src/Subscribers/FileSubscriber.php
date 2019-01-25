<?php


namespace App\Subscribers;

use App\Mng\FileManager;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;

class FileSubscriber implements EventSubscriberInterface{


    private $_filManager;

    public function __construct(FileManager $fileManager)
    {
        $this->_filManager = $fileManager;

    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA =>'onPreSetData',
        ];
    }

    public function onPreSetData(FormEvent $event){

      $entity = $event->getData();



      if(empty($entity->getAvatar())){

          return ;
      }

     $path = $this->_filManager->getTargetDirectory().'/'.$entity->getAvatar();

      $file = new File(
          $path
      );

      $entity->setAvatar($file);


;
    }
}
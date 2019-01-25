<?php


namespace App\Subscribers;

use App\Entity\Profile;
use App\Mng\FileManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;


class AvatarSubscriber implements EventSubscriber {


    private $_filManager;

    public function __construct(FileManager $fileManager)
    {
        $this->_filManager = $fileManager;

    }


    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postRemove,
        ];
    }


    public function prePersist(LifecycleEventArgs $args)
    {

        $entiy = $args->getEntity();

        if ($entiy instanceof Profile) {

            $file = $entiy->getAvatar();

            $fileName = $this->_filManager->uploadFile($file);

            $entiy->setAvatar($fileName);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {

        if ($args->hasChangedField('avatar')){

            $file = $args->getEntity()->getAvatar();
            $fileName = $this->_filManager->uploadFile($file);
            $args->SetNewValue('avatar',$fileName);

           $this->_filManager->removeFile($args->getOldValue('avatar'));

        }
    }

    public function postRemove(LifecycleEventArgs $args){

        if ($args->getEntity() instanceof Profile) {

            $this->_filManager->removeFile($args->getEntity()->getAvatar());
        }

    }



}
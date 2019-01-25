<?php

namespace App\Mng;


use Psr\Container\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileManager{


    private $container;

    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;
    }

    public function uploadFile(UploadedFile $uploadedFile){


        if($uploadedFile instanceof UploadedFile){

           $filename = $this->generateUniqueName().'.'.$uploadedFile->guessExtension();

           $uploadedFile->move(
               $this->getTargetDirectory(),
               $filename
           );

           return $filename;
        }

    }

    public function removeFile($filename){

        $fileSystem = new Filesystem();

        $path = $this->getTargetDirectory().'/'.$filename;

        $fileSystem->remove(
            $path
        );
    }


    public function getTargetDirectory(){

        return $this->container->getParameter('uploads_directory');
    }

    private function generateUniqueName(){

        return md5(uniqid());
    }

}
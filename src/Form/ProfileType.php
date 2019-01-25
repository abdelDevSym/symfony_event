<?php

namespace App\Form;

use App\Entity\Profile;
use App\Mng\FileManager;
use App\Subscribers\FileSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{

    private $_filManager;

    public function __construct(FileManager $fileManager)
    {
        $this->_filManager = $fileManager;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('fullname')
            ->add('about')
            ->add('avatar', FileType::class,[
                'label'=> 'Profile picture'
            ])
          ->addEventSubscriber(new FileSubscriber($this->_filManager))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}

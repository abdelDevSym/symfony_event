<?php


namespace App\Events;

use App\Entity\Profile;
use Symfony\Component\EventDispatcher\Event;

class Events extends Event {


    private $_profile;

    const NAME = 'profile.published';


    public function __construct(Profile $profile)
    {
        $this->_profile = $profile;
    }

    public function getProfile(){

        return $this->_profile;
    }


}
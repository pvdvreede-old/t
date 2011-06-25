<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller {

    protected function getCurrentUser() {
        return $this->get('security.context')->getToken()->getUser();
    }

}

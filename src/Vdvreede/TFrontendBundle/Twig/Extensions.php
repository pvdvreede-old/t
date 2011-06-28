<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vdvreede\TFrontendBundle\Twig;

/**
 * Description of Call
 *
 * @author paul
 */
class Extensions extends \Twig_Extension {

    public function getFilters() {
        return array('call_method' => new \Twig_Filter_Method($this, 'call_method'));
    }

    public function getName() {
        return 'Vdvreede.Extensions';
    }

    public function call_method($entity, $method) {
        $fullMethod = 'get' . $method;

        return call_user_func(array($entity, $fullMethod));
    }

}


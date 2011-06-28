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
    
    public function getFilters() 
    {
        return array('vdvreede_call_method' => new Twig_Filter_Function('vdvreede_call_method'));
    }
    
}

function vdvreede_call_method($entity, $method) {
    $fullMethod = 'get'.$method;
    
    return $entity->$fullMethod;
}

<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Education controller.
 */
class BaseController extends Controller
{
    /**
     * @return EntityManager
     */
    public function getEntityManager() {
        return $this->getDoctrine()->getManager();

    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends BaseController
{
    /**
     * @Route("/{name}", name="resume")
     * @Template()
     */
    public function indexAction($name)
    {
        $resume = $this->getEntityManager()->getRepository('AppBundle:Resume')->findOneBy(['shortName'=>$name]);
        if(!$resume) {

        }
        return [];
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Resume;
use AppBundle\Form\ResumeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DisplayController extends BaseController
{
    /**
     * @Route("/{name}", name="resume")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($name)
    {
        $resume = $this->getEntityManager()->getRepository('AppBundle:Resume')->findOneBy(['shortName'=>$name]);
        if(!$resume) {
            $resume = new Resume();
            $resume->setShortName($name);
            $form = $this->createForm(new ResumeType(), $resume);
            return $this->render('AppBundle:Display:signup.html.twig',['form'=>$form->createView() ,'shortName'=>$name]);
        }
        return [];
    }
}

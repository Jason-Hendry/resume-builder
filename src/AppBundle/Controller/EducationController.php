<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Education;
use AppBundle\Form\EducationType;

/**
 * Education controller.
 *
 * @Route("/education")
 */
class EducationController extends Controller
{

    /**
     * Lists all Education entities.
     *
     * @Route("/", name="education")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Education')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Education entity.
     *
     * @Route("/", name="education_create")
     * @Method("POST")
     * @Template("AppBundle:Education:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Education();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('education_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Education entity.
     *
     * @param Education $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Education $entity)
    {
        $form = $this->createForm(new EducationType(), $entity, array(
            'action' => $this->generateUrl('education_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Education entity.
     *
     * @Route("/new", name="education_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Education();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Education entity.
     *
     * @Route("/{id}", name="education_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Education')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Education entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Education entity.
     *
     * @Route("/{id}/edit", name="education_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Education')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Education entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Education entity.
    *
    * @param Education $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Education $entity)
    {
        $form = $this->createForm(new EducationType(), $entity, array(
            'action' => $this->generateUrl('education_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Education entity.
     *
     * @Route("/{id}", name="education_update")
     * @Method("PUT")
     * @Template("AppBundle:Education:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Education')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Education entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('education_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Education entity.
     *
     * @Route("/{id}", name="education_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Education')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Education entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('education'));
    }

    /**
     * Creates a form to delete a Education entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('education_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

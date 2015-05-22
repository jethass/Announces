<?php

namespace Annonces\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Annonces\SiteBundle\Entity\Annonces;
use Annonces\SiteBundle\Form\AnnoncesType;

/**
 * Annonces controller.
 *
 * @Route("/annonces")
 */
class AnnoncesController extends Controller
{

    /**
     * Lists all Annonces entities.
     *
     * @Route("/", name="annonces")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AnnoncesSiteBundle:Annonces')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Annonces entity.
     *
     * @Route("/", name="annonces_create")
     * @Method("POST")
     * @Template("AnnoncesSiteBundle:Annonces:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Annonces();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('annonces_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Annonces entity.
     *
     * @param Annonces $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Annonces $entity)
    {
        $form = $this->createForm(new AnnoncesType(), $entity, array(
            'action' => $this->generateUrl('annonces_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Annonces entity.
     *
     * @Route("/new", name="annonces_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Annonces();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Annonces entity.
     *
     * @Route("/{id}", name="annonces_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnoncesSiteBundle:Annonces')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Annonces entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Annonces entity.
     *
     * @Route("/{id}/edit", name="annonces_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnoncesSiteBundle:Annonces')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Annonces entity.');
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
    * Creates a form to edit a Annonces entity.
    *
    * @param Annonces $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Annonces $entity)
    {
        $form = $this->createForm(new AnnoncesType(), $entity, array(
            'action' => $this->generateUrl('annonces_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Annonces entity.
     *
     * @Route("/{id}", name="annonces_update")
     * @Method("PUT")
     * @Template("AnnoncesSiteBundle:Annonces:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnoncesSiteBundle:Annonces')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Annonces entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('annonces_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Annonces entity.
     *
     * @Route("/{id}", name="annonces_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AnnoncesSiteBundle:Annonces')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Annonces entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('annonces'));
    }

    /**
     * Creates a form to delete a Annonces entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonces_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

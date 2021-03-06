<?php

namespace Annonces\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Annonces\SiteBundle\Entity\Annonce;
use Annonces\SiteBundle\Form\AnnonceType;
use Annonces\SiteBundle\Form\EditAnnonceType;
use Annonces\SiteBundle\Filter\AnnonceFilterType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * Annonce controller.
 *
 * @Route("/annonce")
 */
class AnnonceController extends Controller
{

    
   
   
  /*  public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AnnoncesSiteBundle:Annonce')->findAll();

        $form = $this->get('form.factory')->create(new AnnonceFilterType());

        if ($this->get('request')->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($this->get('request')->query->get($form->getName()));

            // initialize a query builder
            $filterBuilder = $em->getRepository('AnnoncesSiteBundle:Annonce')->createQueryBuilder('e');
            

            // build the query from the given form object
            $qb=$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
            // now look at the DQL =)
            //var_dump($qb->getQuery());die;
            // var_dump($filterBuilder->getDql());die;
            
            $entities = $qb->getQuery()->getResult();

            return array(
                        'entities' => $entities,
                        'form' => $form->createView()
             );

        }else{
             
             return array(
                        'entities' => $entities,
                        'form' => $form->createView()
             );

        }
      
    }*/

    /**
     * Lists all Annonce entities.
     *
     * @Route("/", name="annonce")
     * @Method("GET")
     * @Template()
     */
    
    public function indexAction(Request $request)
    {
                    $em = $this->getDoctrine()->getManager();

                    $filterForm = $this->get('form.factory')->create(new AnnonceFilterType());
                   
                    $queryBuilder = $em->getRepository('AnnoncesSiteBundle:Annonce')->getAnnonces();
                    $count = $em->getRepository('AnnoncesSiteBundle:Annonce')->getCount();

                    if ($this->get('form_filter.manager')->hasFilterData($filterForm->getName())) {
                        $this->get('form_filter.manager')->submit($filterForm, true);

                        $queryBuilder = $em
                                ->getRepository('AnnoncesSiteBundle:Annonce')
                                ->createQueryBuilder('e')
                        ;

                        $this
                                ->get('lexik_form_filter.query_builder_updater')
                                ->addFilterConditions($filterForm, $queryBuilder)
                        ;
                    }

                    $pager = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
                    $pager->setMaxPerPage($this
                                    ->container
                                    ->getParameter('annonces_site.pagination_max_per_page')
                    );
                   
                    $page = $request->query->get('page', 1);
                    $pager->setCurrentPage($page);

                    return array(
                        'filterForm' => $filterForm->createView(),
                        'pager'      => $pager,
                        'count'      => $count,
                        'entities'   => $pager->getCurrentPageResults()
                    );
    }


    /**
     * Creates a new Annonce entity.
     *
     * @Route("/", name="annonce_create")
     * @Method("POST")
     * @Template("AnnoncesSiteBundle:Annonce:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Annonce();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('annonce_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Annonce entity.
     *
     * @param Annonce $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Annonce $entity)
    {
        $form = $this->createForm(new AnnonceType(), $entity, array(
            'action' => $this->generateUrl('annonce_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Annonce entity.
     *
     * @Route("/new", name="annonce_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Annonce();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Annonce entity.
     *
     * @Route("/{id}", name="annonce_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnoncesSiteBundle:Annonce')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Annonce entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Annonce entity.
     *
     * @Route("/{id}/edit", name="annonce_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnoncesSiteBundle:Annonce')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Annonce entity.');
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
    * Creates a form to edit a Annonce entity.
    *
    * @param Annonce $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Annonce $entity)
    {
        $form = $this->createForm(new EditAnnonceType(), $entity, array(
            'action' => $this->generateUrl('annonce_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Annonce entity.
     *
     * @Route("/{id}", name="annonce_update")
     * @Method("PUT")
     * @Template("AnnoncesSiteBundle:Annonce:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnoncesSiteBundle:Annonce')->find($id);
        $originalImages = $em->getRepository('AnnoncesSiteBundle:Media')->findBy(array('annonce' => $entity));

        //var_dump($media);die('yoo');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Annonce entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $images = $entity->getImages();
              
           /* foreach ($entity->getImages() as $img) {

                foreach ($originalImages as $key => $toDel) {
                    if ($toDel === $img) {
                        unset($originalImages[$key]);
                    }
                }
            }

            foreach ($originalImages as $image) {

                 $em->remove($image);
            }*/

           foreach ($originalImages as $key => $origImg) {
                foreach ($entity->getImages() as $img) {
                      if($origImg->getId()==$img->getId()){
                         unset($originalImages[$key]);
                      }
                }
           }

           foreach ($originalImages as $image) {

                 $em->remove($image);
            }


            $em->persist($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('annonce_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Annonce entity.
     *
     * @Route("/{id}", name="annonce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AnnoncesSiteBundle:Annonce')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Annonce entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('annonce'));
    }

    /**
     * Creates a form to delete a Annonce entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonce_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

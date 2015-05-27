<?php

namespace Annonces\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Annonces\SiteBundle\Form\MediaType;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         /*   ->add('titre')
            ->add('date')
            ->add('description')
            ->add('prix')
            ->add('active')
            ->add('telephone')
            ->add('afficheTelephone')
            ->add('email')
            ->add('utilisateur')
            ->add('categorie');*/

           ->add('titre',null, array(
                    'label' => '* Titre de l\'annonce',
                    'attr' => array(
                        'placeholder' => 'Titre',
                        'data-title' => 'Saisissez le titre de l\'annonce',
                    ),
 
                )
            )
            ->add('description','textarea', array(
                  'label' => '* Description',
                  'attr' => array(
                        'data-title' => 'Saisissez le titre de l\'annonce',
 
                    ),
                )
            )
            ->add('prix')
            ->add('active', 'checkbox', array('required' => false))
           
            ->add('telephone', null, array(
                    'label' => 'Numéro de téléphone',
                    'attr' => array(
                        'placeholder' => '0123456789',
                        'data-title' => 'Par défaut, votre téléphone ne sera pas visible dans l\'annonce',
                    )
                )
            )
            ->add('afficheTelephone', null, array(
                    'label' => 'Afficher le téléphone dans l\'annonce ?',
                    'label_attr' => array(
                        'class' => 'db-option',
                    ),
                    'attr' => array(
                        'class' => 'db-option'
                    )
 
                )
            )
            ->add('email', null, array(
                    'label' => '* E-Mail',
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'E-Mail',
                        'data-title' => 'Cet E-Mail ne sera pas visible dans l\'annonce afin d\'éviter le spam. Les utilisateurs pourront vous contacter grâce à un formulaire ',
                         
                    )
                )
            )

            ->add('images', 'collection', array(
                'type'         => new MediaType(),
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype' => true,
                'label'=>"Images de l'annonce",
                'by_reference' => false
              ))

            
            
            ->add('categorie')
            ->add('utilisateur');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Annonces\SiteBundle\Entity\Annonce'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'annonces_sitebundle_annonce';
    }
}

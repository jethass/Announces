<?php

namespace Annonces\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Annonces\SiteBundle\Form\MediaType;

class AnnoncesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('date')
            ->add('description')
            ->add('prix')
            ->add('active')
            ->add('telephone')
            ->add('afficheTelephone')
            ->add('email')
            ->add('image',new Mediatype())
            ->add('utilisateur')
            ->add('categorie')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Annonces\SiteBundle\Entity\Annonces'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'annonces_sitebundle_annonces';
    }
}

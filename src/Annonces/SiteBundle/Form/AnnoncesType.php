<?php

namespace Annonces\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            //->add('createdAt')
            //->add('modifiedAt')
            ->add('description')
            ->add('prix')
            ->add('active')
            ->add('image','file')
            ->add('utilisateur')
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

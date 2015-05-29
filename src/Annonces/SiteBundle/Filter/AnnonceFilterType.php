<?php
namespace Annonces\SiteBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class AnnonceFilterType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('titre', 'filter_text');
       /*
        //for many to many
        $builder->add('tags', 'filter_entity', array(
                    'class'        => 'CMFProductBundle:Tag',
                    'expanded'     => false,
                    'multiple'     => false,
                    'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                        $query = $filterQuery->getQueryBuilder();
                        $query->leftJoin($field, 't');
                        $value = $values['value'];
                        if (isset($value)) {
                            $query->andWhere($query->expr()->in('t.id', $value->getId()));
                        }
                    }
                ));
        //for one to many
        ->add('product', 'filter_entity', array(
                    'class' => 'CMFProductBundle: Product',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('o')
                                ->orderBy('o.name', 'ASC')
                        ;
                    },
                ))
        */

          $builder->add('titre', 'filter_text', array(
            'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                if (empty($values['value'])) {
                    return null;
                }
                return $filterQuery->createCondition( $field ." Like ". " '%".$values["value"]."%' " );
            },
        ));

       $builder
            ->add('categorie', 'filter_entity', array(
                'class' => 'AnnoncesSiteBundle:Categorie',
                'property' => 'nom',
                'label' => 'Categorie',
                'placeholder' => '',
                'required' => false,
            ));
        ;

        $builder->add('cp', 'filter_text', array(
            'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                if (empty($values['value'])) {
                    return null;
                }
                return $filterQuery->createCondition( $field ." = ". "'".$values["value"]."'" );
            },
        ));
        
    }

    public function getName()
    {
        return 'annonce_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') 
        ));
    }
}
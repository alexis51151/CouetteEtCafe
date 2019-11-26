<?php

namespace App\Form;

use App\Entity\UnavaibilityCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Unavaibility;

class UnavaibilityCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unavaibilities', UnavaibilityCollection::class, array('entry_type' => Unavaibility::class, 'entry_options' => array('label' => false), ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UnavaibilityCollection::class,
        ]);
    }
}

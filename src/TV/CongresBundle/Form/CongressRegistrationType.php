<?php

namespace TV\CongresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CongressRegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('chosenDay', ChoiceType::class, array(
                    'choices'  => array(
                        'Inscription aux deux jours = ' => 'Inscription au deux jours',
                        'Inscription au premier jour uniquement = ' => 'Inscription au jour 1',
                        'Inscription au deuxième jour uniquement = ' => 'Inscription au jour 2',
                        'Au moins 5 inscrits de la même institution = ' => 'Inscription au deux jours en groupe',
                    ),
                    'expanded' => true
                ))
                ->add('event', ChoiceType::class, array(
                    'choices'  => array(
                        'inscription' => true,
                        'pas d inscription' => false,
                    ),
                    'expanded' => true
                ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\CongresBundle\Entity\CongressRegistration'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tv_congresbundle_congressregistration';
    }


}

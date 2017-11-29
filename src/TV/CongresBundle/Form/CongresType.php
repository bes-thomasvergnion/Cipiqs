<?php

namespace TV\CongresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CongresType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array('placeholder' =>'Saisisser votre titre ici')
            ))
            ->add('dates', CollectionType::class, array(
                'entry_type'   => DateOfCongresType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label' => FALSE,
                'required' => false,
            ))
            ->add('localisation', TextType::class, array(
                'attr' => array('placeholder' =>'Ex: Luxembourg')
            ))
            ->add('content', TextareaType::class)
            ->add('state', EntityType::class, array(
                'class' => 'TVCongresBundle:State',
                'expanded' => false,
                'required' => true,
                'query_builder' => function (EntityRepository $er){
                return $er->createQueryBuilder('u')
                          ->orderby('u.id', 'ASC');
                },
                'choice_label' => 'name'
            ))
            ->add('preProgram', PdfType::class, array(
                'required' => false,
                'label' => false,
            ))
            ->add('summary', PdfType::class, array(
                'required' => false,
                'label' => false,
            ))
            ->add('priceDay1', TextType::class, array(
                'required' => false
            ))
            ->add('priceDay2', TextType::class, array(
                'required' => false
            ))
            ->add('priceBoth', TextType::class, array(
                'required' => false
            ))
            ->add('groupPrice', TextType::class, array(
                'required' => false
            ))
            ->add('eventPrice', TextType::class, array(
                'required' => false
            ))
            ->add('event', TextType::class, array(
                'required' => false
            ))
            ->add('image', ImageType::class, array(
                'label' => false,
                'required' => false
            ))
        ;        
  
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\CongresBundle\Entity\Congres'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tv_congresbundle_congres';
    }


}

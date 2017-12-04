<?php

namespace TV\CongresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CongresType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array('placeholder' =>'Saisisser votre titre ici'),
                'label' => 'Titre:'
            ))
            ->add('dateDay1', DateType::class, array(
                'widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'dd/MM/yyyy',
                'label' => FALSE,
                'attr' => array('placeholder' =>'jj/mm/aaaa')
            ))
            ->add('dateDay2', DateType::class, array(
                'widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'dd/MM/yyyy',
                'label' => FALSE,
                'attr' => array('placeholder' =>'jj/mm/aaaa')
            ))
            ->add('localisation', TextType::class, array(
                'attr' => array('placeholder' =>'Saisisser un pays'),
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
            ->add('priceDay1', IntegerType::class, array(
                'required' => false
            ))
            ->add('priceDay2', IntegerType::class, array(
                'required' => false
            ))
            ->add('priceBoth', IntegerType::class, array(
                'required' => false
            ))
            ->add('groupPrice', IntegerType::class, array(
                'required' => false
            ))
            ->add('eventPrice', IntegerType::class, array(
                'required' => false
            ))
            ->add('event', TextType::class, array(
                'required' => false,
                'attr' => array('placeholder' =>'Saisisser le nom de l\'événement'),
            ))
            ->add('image', ImageType::class, array(
                'label' => false,
                'required' => false
            ))
            ->add('congresForm', CheckboxType::class, array(
                'label'    => 'Activer formulaire',
                'required' => false,
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

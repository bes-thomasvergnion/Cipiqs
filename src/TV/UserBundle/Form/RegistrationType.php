<?php
 
namespace TV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class RegistrationType extends AbstractType{
     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('profession')
            ->add('institution')
        ;
    }
 
    public function getParent(){
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
 
    public function getBlockPrefix()
    {
        return 'tv_user_registration';
    }
    
    public function getName(){
        return $this->getBlockPrefix();
    }
 
}
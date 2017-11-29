<?php

namespace TV\CipiqsBundle\Form;;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'Votre Nom'),
                'constraints' => array(
                    new NotBlank(array("message" => "Insrcivez votre nom ici")),
                    new Length(array('min' => 3, 'max' => 40, "minMessage" => "Votre nom doit faire au moins 3 caractères", "maxMessage" => "Votre nom doit faire moins de 40 caractères")),
                )
            ))
            ->add('subject', TextType::class, array('attr' => array('placeholder' => 'Sujet'),
                'constraints' => array(
                    new NotBlank(array("message" => "Insrcivez votre sujet ici")),
                    new Length(array('min' => 3, 'max' => 60, "minMessage" => "Votre sujet doit faire au moins 3 caractères", "maxMessage" => "Votre sujet doit faire moins de 60 caractères")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Votre E-mail'),
                'constraints' => array(
                    new NotBlank(array("message" => "Insrcivez votre e-mail ici")),
                    new Email(array("message" => "Votre adresse e-mail ne semble pas valide")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Message'),
                'constraints' => array(
                    new NotBlank(array("message" => "Insrcivez votre message ici")),
                    new Length(array('min' => 30, "minMessage" => "Votre message doit faire au moins 30 caractères")),
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}
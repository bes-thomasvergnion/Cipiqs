<?php

namespace TV\CongresBundle\Form\IconCheckType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;


class IconCheckType extends AbstractType
{
   /**
     * {@inheritdoc}
     */
  public function buildForm(FormBuilder $builder, array $options) {

    $builder -> setAttribute('dataType', $options['dataType']);
  }

   /**
     * {@inheritdoc}
     */
  public function buildView(FormView $view, FormInterface $form) {
    $view -> set('dataType', $form -> getAttribute('dataType'));
  }

   /**
     * {@inheritdoc}
     */
  public function getDefaultOptions(array $options) {
    return array('required' => false,'dataType'=>'entity');
  }


  /**
     * Returns the allowed option values for each option (if any).
     *
     * @param array $options
     *
     * @return array The allowed option values
     */
    public function getAllowedOptionValues(array $options)
    {
        return array('required' => array(false));
    }

   /**
     * {@inheritdoc}
     */
  public function getParent(array $options) {
    return 'entity';
  }

   /**
     * {@inheritdoc}
     */
  public function getName() {
    return 'iconcheck';
  }

}
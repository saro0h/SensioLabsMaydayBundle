<?php

namespace SensioLabs\Bundle\MaydayBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProblemType extends AbstractType
{
    /**
     * @var string[]
     */
    private $priorities;

    /**
     * @param string[] $priorities
     */
    public function __construct(array $priorities)
    {
        $this->priorities = $priorities;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea')
            ->add('priority', 'choice', array('expanded' => true, 'choices' => $this->priorities))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'SensioLabs\\Bundle\\MaydayBundle\\Form\\ProblemDTO'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sensiolabs_mayday_problem';
    }
}

<?php

namespace SensioLabs\Bundle\MaydayBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ProblemType extends AbstractType
{
    private $context;
    private $priorities;

    /**
     * @param SecurityContext $context
     * @param array           $priorities
     */
    public function __construct(SecurityContext $context, array $priorities)
    {
        $this->context = $context;
        $this->priorities = $priorities;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea')
            ->add('priority', 'choice', array('choices' => $this->priorities))
            ->addEventSubscriber(new ProblemSubscriber($this->context))
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

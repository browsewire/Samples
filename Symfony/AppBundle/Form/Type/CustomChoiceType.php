<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomChoiceType extends ChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'lb_first' => true,
                'break_line' => false,
            ));
        parent::setDefaultOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('lb_first', $options['lb_first']);
        $builder->setAttribute('break_line', $options['break_line']);
        //ld($builder);
        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $config = $form->getConfig();
        $view->vars['lb_first'] = $config->getAttribute('lb_first');
        $view->vars['break_line'] = $config->getAttribute('break_line');

        parent::buildView($view, $form, $options);
    }

    public function getName()
    {
        return 'customchoice';
    }
}
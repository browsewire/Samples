<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CkeditorType extends TextareaType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['class'] = 'ckeditor';
        parent::buildView($view, $form, $options);
    }

    public function getName()
    {
        return 'ckeditor';
    }
}
<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Yaw\AppBundle\Core\Form\BaseFormType;

class CmsPageType extends BaseFormType
{
    protected $name = 'cms_page';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->trans_base = 'cms.page.form.';
        $this->structure  = array(
            'id' => array('hidden'),
            'name' => array('text'),
            'title' => array('text'),
            'description' => array('textarea', array(
                'required' => FALSE
            )),
            'keywords' => array('textarea', array(
                'required' => FALSE
            )),
            'draft' => array('checkbox', array(
                'required' => FALSE
            )),
            'content' => array(new CkeditorType(), array(
                'required' => FALSE
            ))
        );

        $this->generateForm($builder);
    }
}
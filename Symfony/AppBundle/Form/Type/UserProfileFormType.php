<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class UserFormType extends BaseFormType
{
    protected $name = 'user_profile_form';

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $vgroup = isset($this->data['vgroup']) ? (array)$this->data['vgroup'] : array();

        $resolver->setDefaults(array(
            'data_class' => 'Yaw\AppBundle\Entity\User',
            'validation_groups' => array('user_profile'),
        ));

        parent::setDefaultOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->structure = array(
            'first_name'    => array('text', array(
                'label' => 'entity.User.first_name',
                'attr'  => array(
                    'placeholder' => 'entity.User.first_name',
                )
            )),
            'last_name'     => array('text', array(
                'label' => 'entity.User.last_name',
                'attr'  => array(
                    'placeholder' => 'entity.User.last_name',
                )
            )),
            'facebookid'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Facebook Id',
                )
            )),
            'email'         => array('email', array(
                'label' => 'entity.User.email_short',
                'attr'  => array(
                    'placeholder' => 'entity.User.email_short',
                )
            )),
            'address_1'     => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.addr_1'
                )
            )),
            'address_2'     => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.addr_2'
                )
            )),
            'zip'           => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.zip',
                    'class'       => 'input-zip',
                )
            )),
            'ssn'           => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.ssn',
                )
            )),
	    'cell_phone'           => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.cell_phone',
                )
            )),
            'plainPassword' => array('repeated', array(
                'label'          => FALSE,
                'type'           => 'password',
                'first_name'     => 'password',
                'first_options'  => array(
                    'label' => FALSE,
                    'attr'  => array(
                        'placeholder' => 'entity.User.password'
                    )
                ),
                'second_name'    => 'conf_password',
                'second_options' => array(
                    'label' => FALSE,
                    'attr'  => array(
                        'placeholder' => 'entity.User.conf_password'
                    )
                )
            )),
            'avatar'        => array('hidden'),
        );

        $this->generateForm($builder);
    }
}
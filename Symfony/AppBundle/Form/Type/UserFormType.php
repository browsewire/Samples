<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class UserFormType extends BaseFormType
{
    protected $name = 'user_form';
    public $profile_type = 1;

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $vgroup = isset($this->data['vgroup']) ? (array)$this->data['vgroup'] : array();

        $resolver->setDefaults(array(
            'data_class'        => 'Yaw\AppBundle\Entity\User',
            'validation_groups' => $vgroup,
        ));

        parent::setDefaultOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = $this->repo('Settings')->getFees(TRUE);

        $this->structure = array(
            'email'         => array('email', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.email',
                )
            )),
            'profile_type'  => array(new CustomChoiceType(), array(
                'label'      => FALSE,
                'choices'    => array(
                    1 => 'entity.User.profile_type.1',
                    2 => $options[2],
                    3 => $this->container->get('translator')->trans(
                        'entity.User.profile_type.3',
                        array('%value%' => $options[3])
                    ),
                ),
                'expanded'   => TRUE,
                'multiple'   => FALSE,
                'lb_first'   => TRUE,
                'break_line' => TRUE,
            )),
            'first_name'    => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.first_name',
                )
            )),
            'last_name'     => array('text', array(
                'label' => FALSE,
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
            
            'fb_friends'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Facebook Friends Count',
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
            'password'      => array('hidden'),
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
            'zip'           => array('hidden', array(
                'attr' => array(
                    'class'            => 'input-zip',
                    'required'         => 'required',
                    'data-placeholder' => $this->container->get('translator')->trans('entity.User.zip') . ' *'
                )
            )),
            'state'         => array('text', array(
                'label'    => FALSE,
                'required' => TRUE,
                'attr'     => array(
                    'placeholder' => 'entity.User.state',
                )
            )),
            'city'          => array('text', array(
                'label'    => FALSE,
                'required' => TRUE,
                'attr'     => array(
                    'placeholder' => 'entity.User.city',
                )
            )),
            'address_1'     => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.addr_1',
                    'data-container-class' => 'container-address-1'
                )
            )),
            'address_2'     => array('text', array(
                'label'    => FALSE,
                'required' => FALSE,
                'attr'     => array(
                    'placeholder' => 'entity.User.addr_2',
                    'data-container-class' => 'container-address-2'
                )
            )),
            'avatar'        => array('hidden'),
        );

        $this->generateForm($builder);
    }
}
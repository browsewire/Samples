<?php
namespace Yaw\AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class AccountFormType extends BaseFormType
{
    protected $name = 'user_form';

   public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
        $resolver->setDefaults(array(
            'data_class' => 'Yaw\AppBundle\Entity\User',
            'validation_groups' => array('user_profile'),
        ));

        parent::setDefaultOptions($resolver);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->structure = array(
        
            'first_name'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'First name',
                )
            )),
            'last_name'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'First name',
                )
            )),
            'email'         => array('email', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Enter your email address',
                )
            )),
            'plainpassword'      => array('repeated', array(
                'label'          => FALSE,
                'type'           => 'password',
                'first_name'     => 'password1',
                'first_options'  => array(
                    'label' => FALSE,
                    'attr'  => array(
                        'placeholder' => 'Password'
                    )
                ),
                'second_name'    => 'conf_password1',
                'second_options' => array(
                    'label' => FALSE,
                    'attr'  => array(
                        'placeholder' => 'Confirm password'
                    )
                )
            )),
            'password' => array('hidden'),
           'zip'           => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'entity.User.zip',
                    'class'       => 'input-zip',
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
       
        );
        $this->generateForm($builder);
    }
}

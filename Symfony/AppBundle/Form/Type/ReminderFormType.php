<?php
namespace Yaw\AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class ReminderFormType extends BaseFormType
{
    protected $name = 'reminder_form';

  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->structure = array(
        
         'remail'         => array('email', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Enter your email address',
                )
            )),
         'date'          => array('text', array(
                'label' => 'Remind me on ',
                'attr'  => array(
                    'class'                => 'datepicker f-right',
                    'data-number-of-month' => '2',
                    'data-min-date'        => '+1d'
                )
            )),
        
        'periods'     => array(new CustomChoiceType(), array(
                'label'      => FALSE,
                'data' => 'monthly',
                'choices'    => array(
                    'monthly'    => 'Every month',
                    'once'       => 'Just once',
                ),
                'expanded'   => TRUE,
                'multiple'   => FALSE,
                'lb_first'   => FALSE,
                'break_line' => FALSE
            )),
        'remtype'     => array(new CustomChoiceType(), array(
                'label'      => FALSE,
                'data' => 0,
                'choices'    => array(
                    '0'    => 'Just sent me reminder and nothing else',
                    '1'    => "I don't mind getting other stuff sent to me",
                ),
                'expanded'   => TRUE,
                'multiple'   => FALSE,
                'lb_first'   => FALSE,
                'break_line' => FALSE
            )),
        'uid'         => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'user id',
                )
            )),
       
        );
        $this->generateForm($builder);
    }
}

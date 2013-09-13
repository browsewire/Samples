<?php
namespace Yaw\AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class SearchType extends BaseFormType
{
    protected $name = 'loan_form';

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $vgroup = isset($this->data['vgroup']) ? (array)$this->data['vgroup'] : array();
        //ldd($this->data);
        if (isset($this->data['post'][$this->name]['frequency']) && $this->data['post'][$this->name]['frequency'] == 'once') {
            $vgroup[] = 'freq_once';
        }
        //ldd($vgroup);

        $resolver->setDefaults(array(
            'data_class' => 'Yaw\AppBundle\Entity\Loan',
            'validation_groups' => $vgroup,
        ));

        parent::setDefaultOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $loan = $this->repo('Settings')->getLoanAmounts();
        $reason = $this->repo('Reason')->getList();
		//echo "<PRE>";print_r($reason);
        //$zip = $this->repo('ZipCode')->getChoicesList();
         //ld($reasons);
        $interests = $this->repo('Interest')->getChoicesList();
        $user_data = $this->container->get('request')->getSession()->get('user_form');
        if (isset($user_data['profile_type'])) {
            $loan_type = 'loan_' . $user_data['profile_type'];
        } else {
            $loan_type = 'loan_1';
        }
        
        
        
        $this->structure = array(
            'amount' => array('text', array(
                'label' => 'entity.Loan.amount',
                'attr'  => array(
                    'readonly'      => 'readonly',
                    'data-min'      => $loan[$loan_type]['min'],
                    'data-max'      => $loan[$loan_type]['max'],
                    'data-maxmonth' => isset($loan[$loan_type]['maxmonth']) ? $loan[$loan_type]['maxmonth'] : 0,
                    'data-step'     => $loan[$loan_type]['step'],
                )
            )),
            'frequency'     => array(new CustomChoiceType(), array(
                'label'      => FALSE,
                'data' => 1,
                'choices'    => array(
                    'once'    => 'entity.Loan.frequency.once',
                    'monthly' => 'entity.Loan.frequency.monthly',
                ),
                'expanded'   => TRUE,
                'multiple'   => FALSE,
                'lb_first'   => FALSE,
                'break_line' => FALSE
            )),
            'date'          => array('text', array(
                'label' => 'entity.Loan.date',
                'attr'  => array(
                    'class'                => 'datepicker f-right',
                    'data-number-of-month' => '2',
                    'data-min-date'        => '+10d'
                )
            )),
            'statement'     => array('textarea', array(
                'label' => FALSE,
                'attr'  => array(
                    'class'       => 'msg-counter',
                    'maxlength'   => "160",
                    'placeholder' => 'entity.Loan.statement'
                )
            )),
            'reason'        => array('entity', array(
                'label'      => FALSE,
                'class'      => 'YawAppBundle:Reason',
                'property' => 'name',
                'choices' => $reason,
                'expanded'   => FALSE,
                'multiple'   => FALSE,
                'attr'       => array(
                    'class'            => 'singleselect',
                    'data-placeholder' => $this->container->get('translator')->trans('entity.Loan.reason')
                ),
            )),
            'interests'     => array('entity', array(
                'label'      => FALSE,
                'class'      => 'YawAppBundle:Interest',
                'property' => 'value',
                'choices' => $interests,
                'expanded'   => FALSE,
                'multiple'   => TRUE,
                'attr'       => array(
                    'class'    => 'multiselect',
                    'multiple' => 'multiple',
                    'placeholder' => 'Search by common interests                                                  '
                )
            )),
            
             
            
        );

        $this->generateForm($builder);
    }
}

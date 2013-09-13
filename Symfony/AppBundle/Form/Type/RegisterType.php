<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class RegisterType extends BaseFormType
{
    protected $name = 'register_form';

    public $profile_type = 1;
    public $entity_type = NULL;

    /*public function getDefaultOptions(array $options)
    {
        $options['data_class'] = 'Yaw\AppBundle\Entity\User';
        return $options;
    }*/

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if ($this->entity_type !== NULL) {
            $resolver
                ->setDefaults(array(
                    'data_class' => 'Yaw\AppBundle\Entity\\' . ucfirst($this->entity_type),
                ));
        }

        parent::setDefaultOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $by_entity = array(
            'user' => array(
                'email',
                'first_name',
                'last_name',
                'plainPassword',
                'password',
                'profile_type',
                'zip',
                'address_1',
                'address_2',
                'city',
                'state',
                'ssn',
                'cell_phone',
                'avatar',
                'facebookid',
            )
        );

        $loan = $this->data['loan']['loan_' . $this->profile_type];

        $this->structure = array(
            //-------------------------------------------------------------//
            // Step #1
            //-------------------------------------------------------------//
            'terms'         => array('checkbox', array(
                'label' => 'I agree to the ',
            )),

            //-------------------------------------------------------------//
            // Step #2
            //-------------------------------------------------------------//
            'profile_type'          => array(new CustomChoiceType(), array(
                'label'      => FALSE,
                'choices'    => array(
                    1 => 'Free',
                    2 => $this->data['options'][2],
                    3 => "<span class=\"fwn\">From</span> {$this->data['options'][2]}",
                ),
                'expanded'   => TRUE,
                'multiple'   => FALSE,
                'lb_first'   => TRUE,
                'break_line' => TRUE,
            )),

            //-------------------------------------------------------------//
            // Step #3
            //-------------------------------------------------------------//
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
            
            'facebookid'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Facebook Id',
                )
            )),
            
            'email'         => array('email', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Enter your email address',
                )
            )),
            'plainPassword'      => array('repeated', array(
                'label'          => FALSE,
                'type'           => 'password',
                'first_name'     => 'password',
                'first_options'  => array(
                    'label' => FALSE,
                    'attr'  => array(
                        'placeholder' => 'Password'
                    )
                ),
                'second_name'    => 'conf_password',
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
                    'placeholder' => 'ZIP code',
                    'class'       => 'input-zip',
                    //'data-container-class' => 'input-third-width-last',
                )
            )),
            'avatar'        => array('hidden'),

            //-------------------------------------------------------------//
            // Step #4
            //-------------------------------------------------------------//
            'loan_amount' => array('text', array(
                'label' => 'I want to borrow',
                'attr'  => array(
                    'readonly'      => 'readonly',
                    'data-min'      => $loan['min'],
                    'data-max'      => $loan['max'],
                    'data-maxmonth' => isset($loan['maxmonth']) ? $loan['maxmonth'] : 0,
                    'data-step'     => $loan['step'],
                )
            )),
            'frequency'     => array(new CustomChoiceType(), array(
                'label'      => FALSE,
                'data' => 1,
                'choices'    => array(
                    'once'    => 'Once',
                    'monthly' => 'Monthly',
                ),
                'expanded'   => TRUE,
                'multiple'   => FALSE,
                'lb_first'   => FALSE,
                'break_line' => FALSE
            )),
            'date'          => array('text', array(
                'label' => 'I need it by',
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
                    'placeholder' => 'Enter a personal statement'
                )
            )),
            'reason'        => array('choice', array(
                'label'      => FALSE,
                'choices'    => $this->data['reasons'],
                'expanded'   => FALSE,
                'multiple'   => FALSE,
                'attr'       => array(
                    'class'            => 'singleselect',
                    'data-placeholder' => 'My reason for borrowing'
                )
            )),
            'interests'     => array('choice', array(
                'label'      => FALSE,
                'choices'    => $this->data['interests'],
                'expanded'   => FALSE,
                'multiple'   => TRUE,
                'attr'       => array(
                    'class'    => 'multiselect',
                    'multiple' => 'multiple',
                    'placeholder' => 'Choose up to 5 of your interests'
                )
            )),

            //-------------------------------------------------------------//
            // Step #5
            //-------------------------------------------------------------//
            'id_verify' => array('checkbox', array(
                'label' => 'ID Verification',
                'attr' => array(
                    'readonly' => 'readonly',
                    'checked' => 'checked',
                    'data-value' => $this->data['evals']['id_verify'],
                )
            )),
            'fico_score' => array('checkbox', array(
                'label' => 'Fico Score and Existing Loans',
                'attr' => array(
                    'readonly' => 'readonly',
                    'checked' => 'checked',
                    'data-value' => $this->data['evals']['fico_score'],
                )
            )),
            'credit_lines' => array('checkbox', array(
                'label' => 'Credit Lines',
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $this->data['evals']['credit_lines']
                )
            )),
            'banking_status' => array('checkbox', array(
                'label' => 'Banking Status',
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $this->data['evals']['banking_status'],
                )
            )),
            'public_report' => array('checkbox', array(
                'label' => 'Public Report',
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $this->data['evals']['public_report'],
                )
            )),
            'all_evals' => array('checkbox', array(
                'label' => '<strong>OR</strong> all the above for only',
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $this->data['evals']['all_evals'],
                )
            )),
            'ssn'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Social Security Number',
                )
            )),
	    'cell_phone'        => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Cell Phone Number',
                )
            )),
            'address_1' => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Address Line 1'
                )
            )),
            'address_2' => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'Address Line 2'
                )
            )),
            'city' => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'class' => 'input-city',
                    'placeholder' => 'City',
                    //'data-container-class' => 'input-third-width',
                )
            )),
            'state' => array('text', array(
                'label' => FALSE,
                'attr'  => array(
                    'placeholder' => 'State',
                    'class'       => 'input-state',
                    //'data-container-class' => 'input-third-width',
                )
            )),
            'checkout_id' => array('hidden'),
        );

        if ($this->entity_type) {
            foreach ($this->structure as $key => $value) {
                if (!in_array($key, $by_entity[$this->entity_type])) {
                    $this->structure[$key][1]['mapped'] = FALSE;
                    $this->structure[$key][1]['required'] = FALSE;
                }
            }
        }

        if ($this->profile_type === 1) {
            $this->structure['ssn'][1]['required'] = TRUE;
	    $this->structure['cell_phone'][1]['required'] = TRUE;
        }

        $this->generateForm($builder);
    }
}
<?php
namespace Yaw\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yaw\AppBundle\Core\Form\BaseFormType;

class UserVerificationFormType extends BaseFormType
{
    protected $name = 'user_verification_form';

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yaw\AppBundle\Entity\UserVerification',
        ));

        parent::setDefaultOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $evals = $this->repo('Settings')->getEvalsChoicesList();

        $this->structure = array(
            'fin_evals'     => array('entity', array(
                'label'      => FALSE,
                'class'      => 'YawAppBundle:Settings',
                'choices' => $evals,
                'expanded'   => TRUE,
                'multiple'   => TRUE,
            )),
            /*'id_verify' => array('checkbox', array(
                'label' => 'ID Verification',
                'mapped' => FALSE,
                'attr' => array(
                    'readonly' => 'readonly',
                    'checked' => 'checked',
                    'data-value' => $evals['id_verify'],
                )
            )),
            'fico_score' => array('checkbox', array(
                'label' => 'Fico Score and Existing Loans',
                'mapped' => FALSE,
                'attr' => array(
                    'readonly' => 'readonly',
                    'checked' => 'checked',
                    'data-value' => $evals['fico_score'],
                )
            )),
            'credit_lines' => array('checkbox', array(
                'label' => 'Credit Lines',
                'mapped' => FALSE,
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $evals['credit_lines']
                )
            )),
            'banking_status' => array('checkbox', array(
                'label' => 'Banking Status',
                'mapped' => FALSE,
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $evals['banking_status'],
                )
            )),
            'public_report' => array('checkbox', array(
                'label' => 'Public Report',
                'mapped' => FALSE,
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $evals['public_report'],
                )
            )),
            'all_evals' => array('checkbox', array(
                'label' => '<strong>OR</strong> all the above for only',
                'mapped' => FALSE,
                'required' => FALSE,
                'attr' => array(
                    'data-value' => $evals['all_evals'],
                )
            )),
            'fin_evals' => array('hidden'),*/
        );

        $this->generateForm($builder);
    }
}
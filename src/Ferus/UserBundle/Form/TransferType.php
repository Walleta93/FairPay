<?php

namespace Ferus\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransferType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receiver', 'barcode', array(
                'label' => 'Récepteur',
            ))
            ->add('amount', 'euro', array(
                'label' => 'Montant',
            ))
            ->add('cause', 'text', array(
                'label' => 'Motif',
            ))
            ->add('actions', 'form_actions', [
                'buttons' => array(
                    'save' => [
                        'type' => 'submit',
                        'options' => [
                            'label' => 'Enregistrer',
                        ]
                    ],
                )
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ferus\TransactionBundle\Entity\Transaction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ferus_userbundle_transfer';
    }
}

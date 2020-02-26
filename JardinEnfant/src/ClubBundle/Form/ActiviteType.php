<?php

namespace ClubBundle\Form;

use ClubBundle\Entity\Club;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

class ActiviteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('photo', FileType::class, array('label' => 'Photo (png, jpeg)'))
                ->add('adresse')->add('agemin')->add('agemax')->add('jours')->add('heured')->add('heuref')->add('nbDispo')->add('montantp')
                ->add('club',EntityType::class,array(
            'class'=>Club::class,
            'choice_label'=>'nom',
            'multiple'=>false
        ))->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClubBundle\Entity\Activite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clubbundle_activite';
    }


}

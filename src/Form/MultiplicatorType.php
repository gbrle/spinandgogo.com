<?php

namespace App\Form;

use App\Entity\BuyIn;
use App\Entity\Multiplicator;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiplicatorType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('value', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, [
                'label' => 'Valeur du multiplicateur'
            ])
            ->add('buy_in', EntityType::class, array(
                'class' => BuyIn::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.room = 41');
                }))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Multiplicator::class,
        ]);
    }
}

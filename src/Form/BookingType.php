<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, $this->getGonfiguration("Date d'arrivée", "La date à laquelle vous comptez arriver"))
            ->add('endDate', DateType::class, $this->getGonfiguration("Date de départ", "La date à laquelle vous quittez les lieux"))
            ->add('comment', TextareaType::class, $this->getGonfiguration(false, "Ajouter un commentaire"));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}

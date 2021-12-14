<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AdType extends AbstractType
{


    /**
     * Permet d'avoir la configuration de base pour un champ ! 
     *
     * @param [string] $label
     * @param [string] $placeholder
     * @return array
     */
    private function getGonfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getGonfiguration("Titre", "Tapez un titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getGonfiguration("Votre url", "Tapez votre adress web"))
            ->add('price', MoneyType::class, $this->getGonfiguration("Prix par nuit", "Le prix que vous voulez"))
            ->add('introduction', TextType::class, $this->getGonfiguration("Introduction", "Donnez une description pour votre annonce"))
            ->add('content', TextareaType::class, $this->getGonfiguration("Description détaillée", "Tapez un description qui donne vraiment envie de venir chez vous !"))
            ->add('coverImage', UrlType::class, $this->getGonfiguration("URL de l'image principale", "Donnez l'adresse d'une image qui donne vraiment envie"))
            ->add('rooms', IntegerType::class, $this->getGonfiguration("Nombre de chambres", "Le nombre de chambre disponibles"));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}

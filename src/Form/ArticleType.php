<?php

namespace App\Form;

use App\Entity\User;
use Assert\NotBlank;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label'=> 'Le nom de ton titre : ',
                'constraints'=>[
                    new Assert\NotBlank([
                        'message'=>'Le champ titre ne peux pas être vide',]),
                    ],
            ])
             ->add('nom', TextType::class,[
                'label'=> 'Le nom de ton axolotl : ',
                'constraints'=>[
                    new Assert\NotBlank([
                        'message'=>'Le champ nom ne peux pas être vide',]),
                    ],
            ])
             ->add('couleur', TextType::class,[
                'label'=> 'La couleur de ton axolotl : ',
                'constraints'=>[
                    new Assert\NotBlank([
                        'message'=>'Le champ couleur ne peux pas être vide',]),
                    ],
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description : ',
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => ' Votre image  : ',
                'mapped' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, GIF).',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

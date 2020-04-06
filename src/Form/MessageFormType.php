<?php

namespace App\Form;

use App\Entity\Message;
use PR\Bundle\RecaptchaBundle\Form\Type\RecaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'name',
                ],
                'required' => true,
                'constraints' => new NotBlank(),
            ])
            ->add('senderEmail',EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'email',
                ],
                'required' => true,
                'constraints' => new NotBlank(),
            ])
            ->add('subject', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'subject',
                ],
                'required' => true,
                'constraints' => new NotBlank(),
            ])
            ->add('message',TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'message',
                    'class' => 'h-100',
                ],
                'required' => true,
                'constraints' => new NotBlank(),
            ])
            ->add('captcha', RecaptchaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'submit',
                'attr' => [
                    'class' => 'w-100 w-md-auto btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}

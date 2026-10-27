<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

final class CustomerSupportAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
          $builder
              ->add('message', TextareaType::class, [
                'label' => false
              ])
              ->add('file', FileType::class, [
                  'required' => false,
                  'label' => false,
                  'constraints' => [
                      new File([
                          'maxSize' => '10M',
                          'mimeTypes' => [
                              'application/pdf',
                              'image/png',
                              'image/jpeg',
                          ],
                          'mimeTypesMessage' => 'arobases_sylius_customer_support_plugin.form.file.invalid_type',
                      ])
                  ],
              ]);
    }
    public function getBlockPrefix(): string
    {
        return 'arobases_customer_support_answer';
    }

}

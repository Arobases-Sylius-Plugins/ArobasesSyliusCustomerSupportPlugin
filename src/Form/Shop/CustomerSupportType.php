<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Shop;

use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport;
use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Arobases\SyliusCustomerSupportPlugin\Files\Uploader\CustomerSupportAnswerUploader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CustomerSupportType extends AbstractType
{
    private CustomerSupportAnswerUploader $customerSupportAnswerUploader;
    private TranslatorInterface $translator;

    public function __construct(CustomerSupportAnswerUploader $customerSupportAnswerUploader, TranslatorInterface $translator)
    {
        $this->customerSupportAnswerUploader = $customerSupportAnswerUploader;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('customerSupportAnswers', CustomerSupportAnswerType::class, [
                'mapped' => false,
                'label' => 'arobases_sylius_customer_support.ui.new_message',
                'required' => false,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }

    public function onPostSubmit(FormEvent $event): void
    {
        /** @var CustomerSupport $data */
        $data = $event->getData();
        $form = $event->getForm();

        $message = $form->get('customerSupportAnswers')->getData()['message'];
        if(null === $message) {
            $form['customerSupportAnswers']['message']->addError(new FormError($this->translator->trans('arobases_sylius_customer_support_plugin.form.message.not_blank', [], 'validators')));
            return;
        }
        $file = null;
        if(array_key_exists('file',$form->get('customerSupportAnswers')->getData())){
            $file = $form->get('customerSupportAnswers')->getData()['file'];
        }

        $customerSupportAnswer = new CustomerSupportAnswer();
        $customerSupportAnswer->setMessage($message);
        $customerSupportAnswer->setCustomerSupport($data);
        $customerSupportAnswer->setAuthor($data->getOrder()->getCustomer()->getFullName());
        if ($file !== null) {
            $pathFile = $this->customerSupportAnswerUploader->upload($file);
            $customerSupportAnswer->setFilePath($pathFile);
        }

        $data->addCustomerSupportAnswer($customerSupportAnswer);
    }
    public function getBlockPrefix(): string
    {
        return 'arobases_customer_support_plugin';
    }
}

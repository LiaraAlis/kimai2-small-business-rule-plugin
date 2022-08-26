<?php

namespace KimaiPlugin\SmallBusinessRuleBundle\Form;

use App\Entity\InvoiceTemplate;
use KimaiPlugin\SmallBusinessRuleBundle\Configuration\SmallBusinessRuleConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\InvoiceTemplateForm as CoreInvoiceTemplateForm;

class InvoiceTemplateForm extends AbstractType
{
    /**
     * @var CoreInvoiceTemplateForm
     */
    private $originalForm;

    /**
     * @var SmallBusinessRuleConfiguration
     */
    private $configuration;

    /**
     * @param CoreInvoiceTemplateForm $original
     * @param SmallBusinessRuleConfiguration $configuration
     */
    public function __construct(CoreInvoiceTemplateForm $original, SmallBusinessRuleConfiguration $configuration)
    {
        $this->originalForm = $original;
        $this->configuration = $configuration;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->originalForm->buildForm($builder, $options);

        if (!$this->configuration->isSmallBusinessRule()) {
            return;
        }

        /** @var InvoiceTemplate $data */
        $data = $options['data'];
        $data->setVat(0.00);

        $builder->get('vat')
            ->setDisabled(true);
    }
}

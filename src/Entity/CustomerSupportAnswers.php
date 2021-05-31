<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="arobases_customer_support_answer")
 */
class CustomerSupportAnswer implements ResourceInterface
{
    use TimestampableEntity;
    use ToggleableTrait;

    /**
     * @var bool
     * @ORM\Column(type="enabled")
     */
    protected $enabled;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport",
     *     inversedBy="customerSupportAnswers",
     *     fetch="EXTRA_LAZY"
     * )
     */
    protected ?CustomerSupport $customerSupport = null;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    protected ?string $filePath = null;

    protected ?File $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCustomerSupport(): ?CustomerSupport
    {
        return $this->customerSupport;
    }

    public function setCustomerSupport(?CustomerSupport $customerSupport): void
    {
        $this->customerSupport = $customerSupport;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }
}

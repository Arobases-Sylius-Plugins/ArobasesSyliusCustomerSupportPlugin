<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="arobases_customer_support")
 */

class CustomerSupport implements ResourceInterface {

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
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Core\Model\Customer", inversedBy="id", fetch="EXTRA_LAZY")
     *
     */
    protected ?Customer $customer = null;

    /**
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Core\Model\Order", inversedBy="id", fetch="EXTRA_LAZY")
     *
     */
    protected ?Order $order = null;

    /**
     * @ORM\OneToMany(targetEntity="Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswers", mappedBy="customerSupport", fetch="EXTRA_LAZY")
     *
     */

    protected Collection $customerSupportAnswers;

    public function __construct()
    {
        $this->customerSupportAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getCustomerSupportAnswers(): Collection
    {
        return $this->customerSupportAnswers;
    }

    public function addCustomerSupportAnswer(CustomerSupportAnswers $answer): void
    {
        if (!$this->hasCustomerSupportAnswer($answer)) {
            $this->customerSupportAnswers->add($answer);
            $answer->setCustomerSupport($this);
        }
    }

    public function removeCustomerSupportAnswer(CustomerSupportAnswers $answer): void
    {
        if ($this->hasCustomerSupportAnswer($answer)) {
            $answer->setCustomerSupport(null);
            $this->customerSupportAnswers->removeElement($answer);
        }
    }

    public function hasCustomerSupportAnswer(CustomerSupportAnswers $answer): bool
    {
        return $this->customerSupportAnswers->contains($answer);
    }
}

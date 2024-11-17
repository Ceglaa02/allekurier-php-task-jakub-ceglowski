<?php

namespace App\Core\Invoice\Infrastructure\Persistance;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\Invoice\Domain\Status\InvoiceStatus;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineInvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function getInvoicesWithGreaterAmountAndStatus(int $amount, InvoiceStatus $invoiceStatus): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Invoice::class, 'i')
            ->where('i.status = :invoice_status')
            ->andWhere('i.amount > :amount')
            ->setParameter('invoice_status', $invoiceStatus)
            ->setParameter('amount', $amount)
            ->getQuery()
            ->getResult();
    }

    public function save(Invoice $invoice): void
    {
        $this->entityManager->persist($invoice);

        $events = $invoice->pullEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}

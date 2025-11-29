<?php declare(strict_types=1);

namespace App\Domain;

final class Cart
{
    private int $total = 0;
    private int $itemsCount = 0;
    /** @var int[] */
    private array $items = [];

    public function addItem(int $priceInEuros): void
    {
        if ($priceInEuros < 0) {
            throw new \InvalidArgumentException('Price must be positive');
        }

        $this->total += $priceInEuros;
        $this->itemsCount++;
        $this->items[] = $priceInEuros;
    }

    public function itemsCount(): int
    {
        return $this->itemsCount;
    }

    /**
     * @return int[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function clear(): void
    {
        $this->total = 0;
        $this->itemsCount = 0;
        $this->items = [];
    }
}

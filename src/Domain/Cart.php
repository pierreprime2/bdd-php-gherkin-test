<?php

declare(strict_types=1);

namespace App\Domain;

final class Cart
{
    private int $total = 0;

    public function addItem(int $priceInEuros): void
    {
        // Minimal behavior: just accumulate the total
        $this->total += $priceInEuros;
    }

    public function total(): int
    {
        return $this->total;
    }
}
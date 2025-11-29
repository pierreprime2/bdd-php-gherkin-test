<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use App\Domain\Cart;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private Cart $cart;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->cart = new Cart();
    }

    #[Given('an empty cart')]
    public function anEmptyCart(): void
    {
        $this->cart = new Cart();
    }

    #[When('I add an item priced at :arg1€')]
    public function iAddAnItemPricedAt(int $arg1): void
    {
        $this->cart->addItem($arg1);
    }

    #[Then('the cart total should be :arg1€')]
    public function theCartTotalShouldBe(int $arg1): void
    {
        $total = $this->cart->total();

        if ($total !== $arg1) {
            throw new \RuntimeException(
                sprintf('Expected total %d€, got %d€', $arg1, $total)
            );
        }
    }
}

<?php

declare(strict_types=1);

use App\Domain\Cart;
use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private Cart $cart;

    private ?string $lastErrorMessage = null;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    #[Given('an empty cart')]
    public function anEmptyCart(): void
    {
        $this->cart = new Cart();
        $this->lastErrorMessage = null;
    }

    #[When('I add an item priced at :price€')]
    public function iAddAnItemPricedAt(int $price): void
    {
        $this->cart->addItem($price);
    }

    #[When('I try to add an item priced at :price€')]
    public function iTryToAddAnItemPricedAt(int $price): void
    {
        $this->lastErrorMessage = null;

        try {
            $this->cart->addItem($price);
        } catch (\InvalidArgumentException $e) {
            $this->lastErrorMessage = $e->getMessage();
        }
    }

    #[When('I clear the cart')]
    public function iClearTheCart(): void
    {
        $this->cart->clear();
    }

    #[Then('the cart total should be :total€')]
    public function theCartTotalShouldBe(int $total): void
    {
        Assert::assertSame($total, $this->cart->total());
    }

    // Gère "1 item" ET "2 items"
    #[Then('the cart should contain :count item')]
    #[Then('the cart should contain :count items')]
    public function theCartShouldContainItems(int $count): void
    {
        Assert::assertSame($count, $this->cart->itemsCount());
    }

    // Step générique (pas utilisé par Behat dans tes scénarios actuels, mais on le garde)
    #[Then('the cart items should be [:items]')]
    public function theCartItemsShouldBe(string $items): void
    {
        $expected = array_filter(array_map('trim', explode(',', $items)));
        $expected = array_map('intval', $expected);

        Assert::assertSame($expected, $this->cart->items());
    }

    // Step spécifique que Behat propose pour "[10, 20]"
    #[Then('the cart items should be [10, :arg1]')]
    public function theCartItemsShouldBe10And(int $arg1): void
    {
        Assert::assertSame([10, $arg1], $this->cart->items());
    }

    // Step spécifique que Behat propose pour "[]"
    #[Then('the cart items should be []')]
    public function theCartItemsShouldBeEmpty(): void
    {
        Assert::assertSame([], $this->cart->items());
    }

    #[Then('I should see an error about invalid price')]
    public function iShouldSeeAnErrorAboutInvalidPrice(): void
    {
        Assert::assertNotNull($this->lastErrorMessage);
        Assert::assertStringContainsString('Price must be positive', $this->lastErrorMessage);
    }
}
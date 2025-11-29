<?php declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Cart;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Cart::class)]
class CartTest extends TestCase
{
    private Cart $cart;

    /**
     * Setup tests
     */
    protected function setUp(): void
    {
        $this->cart = new Cart();
    }

    #[Test]
    public function testAddItem(): void
    {
        // Given an empty cart (setUp)

        // When I add an item priced at 10€
        $this->cart->addItem(10);

        // Then the cart total should be 10€
        self::assertSame(10, $this->cart->total());
    }

    #[Test]
    public function testTotal(): void
    {
        // Given an empty cart (setUp)

        // Then the cart total should be 0€
        self::assertSame(0, $this->cart->total());
    }

    #[Test]
    public function testAddMultipleItemsCumulatively(): void
    {
        // Given an empty cart (setUp)

        // When I add items priced at 10€ and 20€
        $this->cart->addItem(10);
        $this->cart->addItem(20);

        // Then the cart total should be 30€
        self::assertSame(30, $this->cart->total());
    }

    #[Test]
    public function testCannotAddNegativePrice(): void
    {
        // Given an empty cart (setUp)
        // When I add an item priced at -5€
        // Then I should get an error about invalid price

        $this->expectException(\InvalidArgumentException::class);
        $this->cart->addItem(-5);
    }

    #[Test]
    public function testItemsListContainsEachAddedPrice(): void
    {
        // Given an empty cart (setUp)

        // When I add items priced at 10€ and 20€
        $this->cart->addItem(10);
        $this->cart->addItem(20);

        // Then the cart items should be [10, 20]
        self::assertSame([10, 20], $this->cart->items());
    }

    #[Test]
    public function testClearResetsTotalAndItems(): void
    {
        // Given a cart with two items priced at 10 and 20
        $this->cart->addItem(10);
        $this->cart->addItem(20);

        // When I clear the cart
        $this->cart->clear();

        // Then the cart total should be 0
        self::assertSame(0, $this->cart->total());

        // And the cart should contain 0 items
        self::assertSame(0, $this->cart->itemsCount());
        self::assertSame([], $this->cart->items());
    }
}

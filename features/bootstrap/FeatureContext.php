<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {}

    #[Given('an empty cart')]
    public function anEmptyCart(): void
    {
        throw new PendingException();
    }

    #[When('I add an item priced at :arg1€')]
    public function iAddAnItemPricedAt($arg1): void
    {
        throw new PendingException();
    }

    #[Then('the cart total should be :arg1€')]
    public function theCartTotalShouldBe($arg1): void
    {
        throw new PendingException();
    }
}

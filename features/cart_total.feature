Feature: Cart total calculation

  Scenario: Adding a single item updates the cart total
    Given an empty cart
    When I add an item priced at 10€
    Then the cart total should be 10€
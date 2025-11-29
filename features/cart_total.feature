Feature: Cart total calculation

  Scenario: Adding a single item updates the cart total
    Given an empty cart
    When I add an item priced at 10€
    Then the cart total should be 10€
    And the cart should contain 1 item
    And the cart items should be [10]

  Scenario: Adding multiple items updates the cart total cumulatively
    Given an empty cart
    When I add an item priced at 10€
    And I add an item priced at 20€
    Then the cart total should be 30€
    And the cart should contain 2 items
    And the cart items should be [10, 20]

  Scenario: Rejecting negative item price
    Given an empty cart
    When I try to add an item priced at -5€
    Then I should see an error about invalid price
    And the cart total should be 0€
    And the cart should contain 0 items

  Scenario: Clearing a non-empty cart
    Given an empty cart
    When I add an item priced at 10€
    And I add an item priced at 20€
    And I clear the cart
    Then the cart total should be 0€
    And the cart should contain 0 items
    And the cart items should be []

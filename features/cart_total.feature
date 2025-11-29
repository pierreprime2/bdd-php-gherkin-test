Feature: Cart total calculation

  Scenario: Adding a single item updates the cart total
    Given an empty cart
    When I add an item priced at 10€
    Then the cart total should be 10€

  Scenario: Adding multiple items updates the cart total cumulatively
    Given an empty cart
    When I add an item priced at 10€
    And I add an item priced at 20€
    Then the cart total should be 30€

  Scenario: Reject negative priced items
    Given an empty cart
    When I add an item priced at -5€
    Then I should see an error about invalid price
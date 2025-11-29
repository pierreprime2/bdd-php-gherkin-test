---
title: "Translate Gherkin Spec into Unit Tests"
author: ""
---

# 1. Overview

Gherkin expresses business behavior using `Given` / `When` / `Then`.  
Unit tests express technical behavior using `Arrange` / `Act` / `Assert`.

Mapping Gherkin → Unit Tests keeps business specifications and technical tests aligned.

---

# 2. Mapping Rules

- **Given → Arrange**  
  Prepare the initial state, objects, collaborators, and values required by the scenario.

- **When → Act**  
  Perform the business action under test (one clear action per test).

- **Then → Assert**  
  Verify the expected state, return value, or observable effect.

This mapping is structural and works for any well-written Gherkin scenario.

---

# 3. Concrete Example

## 3.1 Gherkin Scenario

```gherkin
Scenario: Adding multiple items updates the total
  Given an empty cart
  When I add an item priced at 10€
  And I add an item priced at 20€
  Then the cart total should be 30€
```

## 3.2 Corresponding Unit Test (conceptual)
	•	Arrange (Given) : Create an empty cart.
	•	Act (When / And) : Add items priced at 10 and 20.
	•	Assert (Then) : Verify the total is 30.

In PHP-like pseudocode:

```
public function test_add_multiple_items_updates_total(): void
{
    // Arrange
    $cart = new Cart();

    // Act
    $cart->addItem(10);
    $cart->addItem(20);

    // Assert
    self::assertSame(30, $cart->total());
}
```
The unit test is just the Gherkin scenario rewritten in code:

```
	•	Given an empty cart → $cart = new Cart();
	•	When I add an item priced at 10€ → $cart->addItem(10);
	•	And I add an item priced at 20€ → $cart->addItem(20);
	•	Then the cart total should be 30€ → assertSame(30, $cart->total());
```

# 4. Why This Works

```
	1.	Gherkin describes WHAT the system must do
It is written in business language and captures domain rules.
	2.	Unit tests describe HOW we verify that behavior in code
They make the behavior executable and repeatable.
	3.	Given/When/Then and Arrange/Act/Assert are isomorphic
They both describe:
	•	a starting state,
	•	an action,
	•	an expected outcome.
```

Because of this structural equivalence, you can:
* design behavior at the Gherkin level with domain experts,
* implement behavior at the unit test level with developers,
* keep both views aligned.

# 5. Suggested Workflow (BDD + TDD)

```
	1.	Write the Gherkin scenario
Describe the behavior in Given/When/Then with domain language.
	2.	Translate to a unit test
	•	Given → Arrange the domain objects.
	•	When → Call the method under test.
	•	Then → Assert on results and state.
	3.	Implement the domain code (TDD)
	•	Run the unit test → it fails (Red).
	•	Implement the minimal domain logic → make it pass (Green).
	•	Refactor while keeping the test green (Refactor).
	4.	Validate end-to-end with BDD tools
```

Use Behat / Cucumber / similar tools to execute the original Gherkin scenarios against the real system.
This ensures that unit-level behavior and end-to-end behavior
are consistent.

# 6. Summary
```
	•	Gherkin’s Given / When / Then maps directly to unit testing’s Arrange / Act / Assert.
	•	This mapping makes it straightforward to translate business scenarios into technical unit tests.
	•	The combination of:
	•	Gherkin for business behavior, and
	•	TDD for domain implementation
provides a clean, repeatable path from specification to working, tested code.
```
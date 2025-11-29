# bdd-php-gherkin-test

## Purpose

This project aims to demonstrate a concrete way to combine LLM-driven development, BDD (Behavior Driven Development) and TDD (Test Driven Development).

## Stack

PHP 8.4, PHPUnit, Next.js, Behat, UUTG

* Check Behat website : https://docs.behat.org/en/latest/
* Check UUTG : https://github.com/UltimateModuleCreator/uutg

## Bootstrap workflow

```mermaid
flowchart TD
    B[Write first Gherkin feature and scenario] --> C[Run Behat]
    C --> D[Generate missing step definitions and add them to FeatureContext]
    D --> E[Generate minimal domain classes from Gherkin with LLM]
    E --> F[Wire Behat steps to the domain in FeatureContext]
    F --> G[Set up tooling: Composer autoload, PHPUnit config, UUTG config]
    G --> H[Run PHPUnit and Behat to verify everything works]
```

## Iterating workflow

```mermaid
flowchart TD
    B[Write or update Gherkin scenario for new behavior]
        --> C[Optionally adjust domain API skeleton]

    C --> D[Generate or update unit test skeletons with UUTG]
    D --> E[Write or refine unit tests from Given-When-Then]
    E --> F[Implement or adjust domain code until unit tests pass]

    F --> G{Is the behavior stable and clear?}
    G -- No --> B

    G -- Yes --> H{Is it time to update Behat?}

    H -- No --> B
    H -- Yes --> J[Add or update Behat scenarios and step definitions]

    J --> K[Run Behat to validate end-to-end]
    K --> B
```

## Behavior milestone
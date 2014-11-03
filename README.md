Decimal
=======

Simple wrapper around BC Math for simple math functions

## Installation

Simply add a dependency to your project's `composer.json` file if you use [Composer](http://getcomposer.org/) to manage the dependencies of your project.

Here is a minimal example of a `composer.json` file that just defines a dependency on Money:

    {
        "require": {
            "JaycoDesign/Decimal": "*"
        }
    }

## Usage Examples

```php
  use JaycoDesign\Decimal\Decimal;
  
  Decimal::mul(10, 5); // 50
  Decimal::div(10, 5); // 2
  Decimal::add(10, 5); // 15
  Decimal::sub(10, 5); // 5
  
  Decimal::greater_than(1,2); // TRUE
  Decimal::less_than(1,2); // FALSE
  
  Decimal::trim(10.3400000); // 10.34
  
  
```

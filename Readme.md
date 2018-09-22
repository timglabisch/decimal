# Numbers

## Decimal

PHP is very popular for developing business applications.
Often such applications needs to calculate numbers, for example when dealing with money.

Even if php is a high level programming language, dealing with something like money is error prone and often not proper implemented.
One of the reasons for this is that php doesn't have a `Decimal` type. Often people use float's to do such Calculations.
If you take a look at the [floating point documentation](http://php.net/manual/de/language.types.float.php) there is a huge warning 
 > So never trust floating number results to the last digit, and do not compare floating point numbers directly for equality. 

it's quite easy to do this wrong and even if this just affect the `last digit` this could result in a huge, hard to fix problem.

if you simply want to calculate a price, or do some basic math you probably don't want to think about [Floating-Point Arithmetic](https://docs.oracle.com/cd/E19957-01/806-3568/ncg_goldberg.html) at all.

### Decimal Type

The package comes with the classes `Decimal` and `Decimal[0-100]` the `0-100` indicates the precision.
This would allow you to write Something like `(new Decimal2("1.99"))->add(new Decimal2("1.99))`.
There are also helper functions to create Decimals: `dec2("1.99")->add(dec2("1.99))`. The Function `dec2` returns a `Decimal2`, `dec99` could return an Instance of `Decimal99`.

## Rational

the Package also comes with a Rational Type. 
This could help you for example if you need to calculate something like `3 * (1/3)`. Using the rational type you could simply write 
`Rational::fromDecimal(dec0(3))->mul(new Rational(dec0(1), dec0(3))`

## Lazy Calculation



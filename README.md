# Div PHP Enum Solution 1.0.1

This is a PHP Enum Solution using classes and type hinting. 
**Also you can build a taxonomies of enums!**

An enumeration type, "enum" for short, is a data type to categorise named 
values. Enums can be used instead of hard coded strings to represent, 
for example, the status of a blog post in a structured and typed way.

In July 2019, I wrote a gist searching a solution for this. 

https://gist.github.com/rafageist/aef9825b7c935cdeb0c6187a2d363909/revisions

Now I am converting the gist in a real project.

## The problem

PHP doesn't have a native enum type. It offers a very basic SPL implementation
(https://www.php.net/manual/en/class.splenum.php), but this really doesn't cut 
the mustard.
 
Some solutions using constants, but not resolve the problem. 
How to validate HOT or COLD ?

```php
<?php

const HOT = 1;
const COLD = 2;

const FIRE = 1;
const ICE = 2;

function doSomething(int $temperature) { /* ... */}

doSomething(FIRE);
```
 
There's a popular package called **myclabs/php-enum**. 
It's really awesome, but have a problem because we lose static 
analysis benefits like auto completion and refactoring.

## The solution

Use PHP! 

The class **divengine\enum** help you, but remember: 
_the most important solution is the concept of this library_.

With this class, you can solves the following problems:
 
1. Constants with different names and equal value can be used as function arguments
2. Lose static analysis benefits like auto completion and refactoring
3. Maintaining duplicated code when use docblock type hints to solve the first problem

We need have built-in enums in PHP ! But, for now, this is a solution.

# Installation

### Composer:
```
composer require divengine\enum;
```

### Manual:

Clone the repo:
```
git clone https://github.com/divengine/enum
```

Include the lib:
```php
include "/path/to/divengine/enum/src/folder/enum.php";
```

## Example

First, define your enums. You can build a taxonomy !!!:

**Enums.php**
```php
<?php

namespace MyEnums;

use divengine\enum;

class Temperature extends enum {/* Father of all types of temperatures */}
class ExtremeTemperature extends Temperature {/* Father of all types of extreme temperatures */}
class FIRE extends ExtremeTemperature {}
class ICE extends ExtremeTemperature {}

class NormalTemperature extends Temperature {/* Father of all types of normal temperatures */}
class HOT extends NormalTemperature {}
class COOL extends NormalTemperature {}
class COLD extends NormalTemperature {}
```

Second use your enums:

```php
<?php

use MyEnums;


// Constants are good tricks, but optional
const COOL = COOL::class;

class AllTemperatures {
    const COOL = COOL::class; // maybe better
    const HOT = 'Enums\\HOT';  // ugly !!!

    //...
}

// Define some function with type hinting
function WhatShouldIdo(Temperature $temperature)
{
    switch (true) {
        case $temperature instanceof ExtremeTemperature:
            switch (true) {
                case $temperature instanceof FIRE:
                    return "Call the fire department";

                case $temperature instanceof ICE:
                    return "Warm up";
            }
            break;

        case $temperature instanceof NormalTemperature:
            switch ($temperature) {

                case HOT::class: // compare using classname
                    return "Drink a bear :D";

                case COOL or AllTemperatures::COOL: // compare using constants
                    return "Just go away !";

                case 'Enums\\COLD': // compare using string, ugly !!!
                    return "Wear a coat";
            }

            break;
    }

    return "I don't know";
}

// Call to function with a instance of any Temperature
echo WhatShouldIdo(new HOT()) . PHP_EOL;
```

Enjoy!

-- 

@rafageist

Eng. Rafa Rodriguez

https://rafageist.github.io
# Div PHP Enum Solution 1.0.2

This is a PHP Enum Solution using classes and type hinting. 
**Also you can build a taxonomies of enums!**

An enumeration type, "enum" for short, is a data type to categorise named 
values. Enums can be used instead of hard coded strings to represent, 
for example, the status of a blog post in a structured and typed way.

In July 2019, I wrote a gist searching a solution for this. 

https://gist.github.com/rafageist/aef9825b7c935cdeb0c6187a2d363909/revisions

Then I convert the gist in a real project. https://www.phpclasses.org/package/11366-PHP-Implement-enumerated-values-using-classes.html

## The problem

Before 8.1, PHP didn't have a native enum type, only a very basic SPL implementation (https://www.php.net/manual/en/class.splenum.php), but this really doesn't cut the mustard. Some solutions using constants, but not resolve the problem. How to validate HOT or COLD ?

From 8.1, PHP have a enums implementation (https://www.php.net/manual/en/language.types.enumerations.php). 

And now you can combine this solution with the new features of PHP.

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

Second, use your enums:

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

## Do you like Java programming language? 

You actually can switch on enums, but you can't switch on Strings until Java 7. 
You might consider using polymorphic method dispatch with Java enums rather 
than an explicit switch. Note that enums are objects in Java, not just symbols 
for ints like they are in C/C++. You can have a method on an enum type, 
then instead of writing a switch, just call the method - one line of code: done!

```java
public enum Temperature {
    HOT {
        @Override
        public void whatShouldIdo() {
            System.out.println("Drink a bear!");
        }
    },
    COLD {
        @Override
        public void whatShouldIdo() {
             System.out.println("Wear a coat!");
        }
    };

    public abstract void whatShouldIdo();
}

// ...

void aMethodSomewhere(final Temperature temperature) {
    doSomeStuff();
    temperature.whatShouldIdo(); // here is where the switch would be, now it's one line of code!
    doSomeOtherStuff();
}

```

One of the nice things about this approach is that it is simply impossible 
to get certain types of errors. You can't miss a switch case (you can incorrectly 
implement a method for a particular constant, but there's nothing that will 
ever totally prevent that from happening!). There's no switch "default" 
to worry about. Also, I've seen code that puts enum constants into arrays 
and then indexes into the arrays - this opens the possibility of array 
index out of bounds exceptions - just use the enum! Java enums are very, 
very powerful. Learn all that you can about them to use them effectively. 

Also note if you have several enum constants that all have the same behavior 
for a particular method (like days of the week, in which 
weekend days have the same behavior and the weekdays Tuesday through Thursday 
also share the same behavior), you can simply gather that shared code in an enum 
method that is not overridden by every constant (final protected) and then call 
that method from the appropriate methods. So, add 
"final protected void commonMethod() { ... }" and then the implementation 
of method() in each constant would just call commonMethod().

And.... what about PHP ? This is a similar solution ...

```php
<?php

abstract class Temperature extends divengine\enum {
  public function whatShouldIdo() {}
}

class HOT extends Temperature {
  public function whatShouldIdo() {
    echo "Drink a bear!";
  }
}

class COLD extends Temperature {
  public function whatShouldIdo() {
    echo "Wear a coat!";
  }
}

// ....

function someStuff(Temperature $t) {
  $t->whatShouldIdo();
}

someStuff( new HOT() );
```

Enjoy!

Documentation: https://divengine.org

-- 

@rafageist

Eng. Rafa Rodriguez

https://rafageist.com

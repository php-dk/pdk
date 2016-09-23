<?php

class A {
    public function foo(self $var)
    {
        if ($var instanceof static) {
            var_dump('YES');
        }
    }
}

class B extends A {}


$a = new A;
$a->foo(new B);
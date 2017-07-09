<?php

namespace phpdk\tests\unit\util;


use phpdk\util\AbstractCollection;
use phpdk\util\TVector;

class VectorTest extends AbstractCollectionTest
{

    public function buildCollection(...$args): AbstractCollection
    {
        return new TVector(...$args);
    }
}
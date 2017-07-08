<?php

namespace PDK\tests\unit\util;


use PDK\util\AbstractCollection;
use PDK\util\TVector;

class VectorTest extends AbstractCollectionTest
{

    public function buildCollection(...$args): AbstractCollection
    {
        return new TVector(...$args);
    }
}
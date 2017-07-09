<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 09.07.17
 * Time: 19:09
 */

namespace phpdk\lang;


class Lang
{
    /**
     * @param $self
     * @param string $operator
     * @param $var
     * @return bool
     * @throws Exception
     */
    public static function compare($self, string $operator, $var): bool
    {
        $validateOperators = ['>', '>=', '<', '<=', '<=>', '===', '==', '!=', '<>'];
        if (!in_array($operator, $validateOperators)) {
            throw new Exception('Ператор не опознан');
        }

        return (bool)eval("return \$self $operator \$var;");
    }

}
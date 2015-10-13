<?php

namespace Bound\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BoundUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }
}

<?php

namespace Bound\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BoundCoreBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }
}

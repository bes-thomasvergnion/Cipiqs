<?php

namespace TV\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TVUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

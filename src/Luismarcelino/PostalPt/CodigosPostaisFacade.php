<?php

namespace Luismarcelino\PostalPt;

use Illuminate\Support\Facades\Facade;

/**
 * FreguesiasFacade
 *
 */
class CodigosPostaisFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'postal_pt'; }

}

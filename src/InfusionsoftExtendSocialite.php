<?php

namespace InfusionsoftSocialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

class InfusionsoftExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('infusionsoft', Provider::class);
    }
}

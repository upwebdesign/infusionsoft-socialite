<?php

namespace InfusionsoftSocialite;

use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'INFUSIONSOFT';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['full'];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://accounts.infusionsoft.com/app/oauth/authorize', $state);
    }

    /**
     * Retrieve access token from response
     *
     * @return array|object
     */
    public function getToken()
    {
        return $this->getAccessTokenResponse($this->getCode());
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://api.infusionsoft.com/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $userUrl = 'https://api.infusionsoft.com/crm/rest/account/profile';

        $response = $this->getHttpClient()->get($userUrl, $this->getRequestOptions($token));

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => null,
            'nickname' => null,
            'name' => Arr::get($user, 'name'),
            'email' => Arr::get($user, 'email'),
            'avatar' => Arr::get($user, 'logo_url'),
        ]);
    }

    /**
     * Get the default options for an HTTP request.
     *
     * @param  string  $token
     * @return array
     */
    protected function getRequestOptions($token)
    {
        return [
            'headers' => [
                'Accept' => 'application/json, */*',
                'Authorization' => 'Bearer ' . $token,
            ],
        ];
    }
}

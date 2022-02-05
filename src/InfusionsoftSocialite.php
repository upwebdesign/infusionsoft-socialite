<?php

namespace InfusionsoftSocialite;

use Illuminate\Support\Arr;
use Laravel\Socialite\Two\User;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class InfusionsoftSocialite extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected $scopes = ['full'];

    /**
     * {@inheritdoc}
     */
    public function getAuthUrl($state): string
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
    protected function getTokenUrl(): string
    {
        return 'https://api.infusionsoft.com/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token): array
    {
        $userUrl = 'https://api.infusionsoft.com/crm/rest/account/profile';

        $response = $this->getHttpClient()->get($userUrl, $this->getRequestOptions($token));

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user): User
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
    protected function getRequestOptions($token): array
    {
        return [
            'headers' => [
                'Accept' => 'application/json, */*',
                'Authorization' => 'Bearer ' . $token,
            ],
        ];
    }
}

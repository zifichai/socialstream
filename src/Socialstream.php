<?php

namespace JoelButcher\Socialstream;

use JoelButcher\Socialstream\Contracts\CreatesConnectedAccounts;
use JoelButcher\Socialstream\Contracts\CreatesUserFromProvider;
use JoelButcher\Socialstream\Contracts\GeneratesProviderRedirect;
use JoelButcher\Socialstream\Contracts\HandlesInvalidState;
use JoelButcher\Socialstream\Contracts\ResolvesSocialiteUsers;
use JoelButcher\Socialstream\Contracts\SetsUserPasswords;

class Socialstream
{
    /**
     * Indicates if Socialstream routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * The user model that should be used by Jetstream.
     *
     * @var string
     */
    public static $connectedAccountModel = 'App\\Models\\ConnectedAccount';

    /**
     * Determine whether or not to show Socialstream components on login or registration.
     *
     * @return bool
     */
    public static function show()
    {
        return config('socialstream.show');
    }

    /**
     * Determine which providers the application supports.
     *
     * @return array
     */
    public static function providers()
    {
        return config('socialstream.providers');
    }

    /**
     * Determine if Socialistream supports a specific Socialite service.
     *
     * @return bool
     */
    public static function hasSupportFor(string $service)
    {
        return in_array($service, config('socialstream.providers'));
    }

    /**
     * Find a connected account instance fot a given provider and provider ID.
     *
     * @param  string  $provider
     * @param  string  $providerId
     * @return mixed
     */
    public static function findConnectedAccountForProviderAndId(string $provider, string $providerId)
    {
        return static::newConnectedAccountModel()
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();
    }

    /**
     * Get the name of the connected account model used by the application.
     *
     * @return string
     */
    public static function connectedAccountModel()
    {
        return static::$connectedAccountModel;
    }

    /**
     * Get a new instance of the connected account model.
     *
     * @return mixed
     */
    public static function newConnectedAccountModel()
    {
        $model = static::connectedAccountModel();

        return new $model;
    }

    /**
     * Specify the connected account model that should be used by Jetstream.
     *
     * @param  string  $model
     * @return static
     */
    public static function useConnectedAccountModel(string $model)
    {
        static::$connectedAccountModel = $model;

        return new static;
    }

    /**
     * Register a class / callback that should be used to resolve the user for a Socialite Provider.
     *
     * @param  string  $c;ass
     * @return void
     */
    public static function resolvesSocialiteUsersUsing($class)
    {
        return app()->singleton(ResolvesSocialiteUsers::class, $class);
    }

    /**
     * Register a class / callback that should be used to create users from social providers.
     *
     * @param  string  $class
     * @return void
     */
    public static function createUsersFromProviderUsing(string $class)
    {
        return app()->singleton(CreatesUserFromProvider::class, $class);
    }

    /**
     * Register a class / callback that should be used to create connected accounts.
     *
     * @param  string  $class
     * @return void
     */
    public static function createConnectedAccountsUsing(string $class)
    {
        return app()->singleton(CreatesConnectedAccounts::class, $class);
    }

    /**
     * Register a class / callback that should be used to set user passwords.
     *
     * @param  string  $callback
     * @return void
     */
    public static function setUserPasswordsUsing(string $callback)
    {
        return app()->singleton(SetsUserPasswords::class, $callback);
    }

    /**
     * Register a class / callback that should be used to set user passwords.
     *
     * @param  string  $callback
     * @return void
     */
    public static function handlesInvalidStateUsing(string $callback)
    {
        return app()->singleton(HandlesInvalidState::class, $callback);
    }

    /**
     * Register a class / callback that should be used for generating provider redirects.
     *
     * @param  string  $callback
     * @return void
     */
    public static function generatesProvidersRedirectsUsing(string $callback)
    {
        return app()->singleton(GeneratesProviderRedirect::class, $callback);
    }
}

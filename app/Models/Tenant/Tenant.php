<?php

namespace App\Models\Tenant;

use Session;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Models\Hostname;
use App\Models\Tenant\CloudFlare;
use App\Models\Tenant\Users\User;
use Illuminate\Support\Facades\Hash;
use App\Models\System\Clients\Client;
use Illuminate\Support\Facades\Artisan;
use App\Models\Tenant\Settings\Parameter;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

/**
 * @property Website website
 * @property Hostname hostname
 * @property User admin
 */
class Tenant
{
    public function __construct(
        Website $website = null,
        Hostname $hostname = null,
        User $admin = null,
        Client $client = null
    ) {
        $this->website = $website;
        $this->hostname = $hostname;
        $this->admin = $admin;
        $this->client = $client;
    }

    /**
     * [delete description]
     *
     * @param   [type]  $name  [$name description]
     *
     * @return  [type]         [return description]
     */
    public static function delete($name)
    {
        $baseUrl = config('tenancy.hostname.default');

        $name = "{$name}.{$baseUrl}";

        if ($tenant = Hostname::where('fqdn', $name)->firstOrFail()) {
            app(HostnameRepository::class)->delete($tenant, true);

            app(WebsiteRepository::class)->delete($tenant->website, true);

            return "Tenant {$name} successfully deleted.";
        }
    }

    /**
     * [deleteByFqdn description]
     *
     * @param   [type]  $fqdn  [$fqdn description]
     *
     * @return  [type]         [return description]
     */
    public static function deleteByFqdn($fqdn)
    {
        if ($tenant = Hostname::where('fqdn', $fqdn)->firstOrFail()) {
            app(HostnameRepository::class)->delete($tenant, true);

            app(WebsiteRepository::class)->delete($tenant->website, true);

            return "Tenant {$fqdn} successfully deleted.";
        }
    }

    /**
     * [registerTenant description]
     *
     * @return  Tenant  [return description]
     */
    public static function registerTenant(...$user): Tenant
    {
        /** Convert all to lowercase */
        $name = strtolower($user[0]['sub_domain']);
        $email = strtolower($user[0]['email']);
        $password = $user[0]['password'];

        /** Create the website */
        $website = new Website;
        $website->uuid = $name. '-' . substr(md5(mt_rand(1, 50)), 0, -(strlen($name) + 1));
        app(WebsiteRepository::class)->create($website);

        /**  Associate the website with a WEB hostname */
        $baseUrl = config('tenancy.hostname.default'); // nfit-webapp.test
        $hostname = static::createHostname($name, $baseUrl, $website);

        /**  Associate the website with a API hostname */
        $baseUrlApi = config('tenancy.hostname.default-api'); // nfit-api.test
        static::createHostname($name, $baseUrlApi, $website);

        /**  Make hostname current */
        app(Environment::class)->tenant($hostname->website);

        Artisan::call('passport:install');

        /**  Add DNS Name to CloudFlare, skip on local development */
        if ( ! \App::environment(['local', 'testing']) ) {
            $response_cloudflare = app(CloudFlare::class)->addDomain($name);

            if ($response_cloudflare !== true) {
                Session::flash('warning', $response_cloudflare);
            }
        }

        /** Assign name and email Parameters */
        Parameter::create([
            'id' => 1,
            'calendar_start' => '07:00',
            'calendar_end' => '22:00',
            'check_confirm' => 0,
            'check_quite_alumnos' => 0,
            'box_name' => $name,
            'box_email' => $email
        ]);

        /** Make the registered user the default Admin of the site. */
        $admin = static::makeAdmin($user[0], $hostname->id, $website->uuid, $name);

        return new Tenant($website, $hostname, $admin);
    }

    /**
     * [makeAdmin description]
     *
     * @param   [type]  $user          [$user description]
     * @param   [type]  $hostnameId    [$hostnameId description]
     * @param   [type]  $website_UUID  [$website_UUID description]
     *
     * @return  [type]                 [return description]
     */
    private static function makeAdmin($user, $hostnameId, $website_UUID)
    {
        $admin = User::create([
            'rut' => $user['rut'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'phone' => $user['phone'] ?? null,
            'birthdate' => $user['birthdate'] ?? null,
            'address' => $user['address'] ?? null,
            'password' => Hash::make($user['password'])
        ]);

        static::storeClient($user, $hostnameId, $website_UUID);

        $admin->assignRole('admin');

        return $admin;
    }

    /**
     * [storeClient description]
     *
     * @param   [type]  $user          [$user description]
     * @param   [type]  $hostnameId    [$hostnameId description]
     * @param   [type]  $website_UUID  [$website_UUID description]
     * @param   [type]  $name          [$name description]
     *
     * @return  void
     */
    public static function storeClient($user, $hostnameId, $website_UUID)
    {
        $client = Client::create([
            'rut' => $user['rut'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'box_name' => $user['box_name'],
            'sub_domain' => $user['sub_domain'],
            'database_uuid' => $website_UUID,
            'email' => $user['email'],
            'status_client' => 1,
            'phone' => $user['phone'] ?? null,
            'birthdate' => $user['birthdate'] ?? null,
            'address' => $user['address'] ?? null,
            'hostname_id' => $hostnameId ?? null
        ]);
    }

    /**
     * [tenantExists description]
     *
     * @param   [type]  $name  [$name description]
     *
     * @return  [type]         [return description]
     */
    public static function tenantExists($name)
    {
        $name = $name . '.' . config('tenancy.hostname.default');

        return Hostname::where('fqdn', $name)->exists();
    }

    /**
     * Create fqdn for web and mobil app
     *
     * @param   string  $name  sub_domain
     * @param   string  $url  Can be api or web
     * @param   Hyn\Tenancy\Models\Website $website
     *
     * @return  Hyn\Tenancy\Models\Hostname $hostname
     */
    public static function createHostname($name, $url, $website)
    {
        $hostname = new Hostname;

        $hostname->fqdn = "{$name}.{$url}";

        app(HostnameRepository::class)->attach($hostname, $website);

        return $hostname;
    }
}

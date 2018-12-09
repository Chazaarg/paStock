<?php
namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends Controller
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/google", name="connect_google_start")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
    
        // will redirect to Facebook!
        return $clientRegistry
            ->getClient('google') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
            'profile', 'email' // the scopes you want to access
            ])
        ;
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/google/check", name="connect_google_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)
    }
}

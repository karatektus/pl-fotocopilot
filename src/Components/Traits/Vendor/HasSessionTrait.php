<?php


namespace App\Components\Traits\Vendor;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Trait HasSessionTrait
 *
 * @package App\Components\Traits\Vendor
 */
trait HasSessionTrait
{
    /**
     * @var SessionInterface|Session
     */
    private $session;

    /**
     * @return SessionInterface|Session
     */
    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    /**
     * @param SessionInterface $session
     */
    public function setSession(SessionInterface $session): void
    {
        $this->session = $session;
    }


}
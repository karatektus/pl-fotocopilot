<?php


namespace App\Services;

use App\Components\Traits\Vendor\HasSessionTrait;
use App\Components\Traits\Vendor\HasTranslatorTrait;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MessageService
 *
 * @package App\Services
 */
class MessageService
{
    use
        HasSessionTrait,
        HasTranslatorTrait;


    /**
     * MessageService constructor.
     *
     * @param SessionInterface    $session
     * @param TranslatorInterface $translator
     */
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->setSession($session);
        $this->setTranslator($translator);
    }

    /**
     * Success
     *
     * @param string $message
     * @param array  $messageParameters
     * @param string $translationDomain
     */
    public function success(string $message, array $messageParameters = [], $translationDomain = 'messages')
    {
        $this->getSession()->getFlashBag()->add('success', $this->getTranslatedMessage($message, $messageParameters, $translationDomain));
    }

    /**
     * Success
     *
     * @param string $message
     * @param array  $messageParameters
     * @param string $translationDomain
     */
    public function error(string $message, array $messageParameters = [], $translationDomain = 'messages')
    {
        $this->getSession()->getFlashBag()->add('danger', $this->getTranslatedMessage($message, $messageParameters, $translationDomain));
    }

    /**
     * Get Translated Message
     *
     * @param string $message
     * @param array  $messageParameters
     * @param string $translationDomain
     *
     * @return string
     */
    private function getTranslatedMessage(string $message, array $messageParameters = [], $translationDomain = 'messages')
    {
        if (false === $translationDomain) {
            return $message;
        }

        return $this->getTranslator()->trans($message, $messageParameters, $translationDomain);
    }
}
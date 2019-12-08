<?php


namespace App\Components\Traits\Vendor;


use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Trait HasTranslatorTrait
 *
 * @package App\Components\Traits\Vendor
 */
trait HasTranslatorTrait
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

}
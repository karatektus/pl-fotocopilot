<?php


namespace App\Components\Model;


class MessageModel
{
    /**
     * @var string
     */
    private $captcha;

    /**
     * @return string
     */
    public function getCaptcha(): string
    {
        if(null === $this->captcha){
            return "";
        }

        return $this->captcha;
    }

    /**
     * @param string $captcha
     */
    public function setCaptcha(string $captcha): void
    {
        $this->captcha = $captcha;
    }


}
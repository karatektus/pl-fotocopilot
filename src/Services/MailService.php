<?php


namespace App\Services;


use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

/**
 * Class MailService
 * @package App\Services
 */
class MailService
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @return Mailer
     */
    public function getMailer(): Mailer
    {
        return $this->mailer;
    }

    /**
     * MailService constructor.
     */
    public function __construct()
    {
        $transport = new GmailSmtpTransport($_ENV['GMAIL_USER'], $_ENV['GMAIL_PASSWORD']);
        $this->mailer = new Mailer($transport);
    }

    /**
     * @param string $sender
     * @param string $senderMail
     * @param string $subject
     * @param string $message
     *
     * @return bool
     */
    public function send(string $sender, string $senderMail, string $subject, string $message)
    {
        $email = (new Email())
            ->from($_ENV['GMAIL_SENDER'])
            ->to($_ENV['MAIL_RECIPIENT'])
            ->replyTo($senderMail)
            ->priority(Email::PRIORITY_HIGH)
            ->subject(sprintf('%s hat dir eine Nachricht geschrieben: %s', $sender, $subject))
            ->text($message);

        try {
            $this->getMailer()->send($email);
            return true;
        } catch (TransportExceptionInterface $e) {
            return false;
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 10/31/2016
 * Time: 5:34 PM
 */

namespace Cgonser\SwiftMailerDatabaseS3SpoolBundle\Transport;


use Cgonser\SwiftMailerDatabaseS3SpoolBundle\Entity\MailQueueTransport;
use Cgonser\SwiftMailerDatabaseS3SpoolBundle\Repository\MailQueueTransportRepository;

class TransportChain
{

    /** @var MailQueueTransportRepository */
    private $transportRepository;

    /** @var array */
    private $transports = null;

    /** @var array */
    private $swiftMailerTransports = [];

    /**
     * TransportChain constructor.
     * @param MailQueueTransportRepository $transportRepository
     * @param array $transports
     */
    public function __construct(MailQueueTransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
        $this->loadSwiftMailerTranports();
    }


    public function addTransport(\Swift_Transport $transport, $alias)
    {
        $this->swiftMailerTransports[$alias] = $transport;
    }

    /**
     * @return \Swift_Transport
     */
    public function getTransports()
    {
        return $this->swiftMailerTransports;
    }

    /**
     * @return \Swift_Transport
     */
    public function getTransport($alias): \Swift_Transport
    {
        if (array_key_exists($alias, $this->swiftMailerTransports)) {
            return $this->swiftMailerTransports[$alias];
        }

        throw new \Exception('No transports were found.');
    }

    public function getTransportByTags(array $tags): \Swift_Transport
    {
        $score = [];
        $defaultTransport = null;
        foreach ($this->getTranports() as $transport) {
            /** @var MailQueueTransport $transport */
            $score[$transport->getAlias()] = 0;
            foreach ($transport->getTags() as $tag) {
                $score[$transport->getAlias()] += in_array($tag, $tags) ? 1 : 0;
            }
            if ($score[$transport->getAlias()] == 0) {
                unset($score[$transport->getAlias()]);
            }
            if ($transport->isDefault()) {
                $defaultTransport = $transport;
            }
        }

        if (count($score) > 0) {
            arsort($score);
            return $this->getTransport(key($score));
        }

        if ($defaultTransport instanceof MailQueueTransport) {
            return $this->getTransport($defaultTransport->getAlias());
        }

        throw new \Exception('No transports were found.');
    }

    /**
     * @return array
     */
    protected function getTranports()
    {
        if ($this->transports == null) {
            $this->transports = $this->transportRepository->findBy(['enabled' => true]);
        }
        return $this->transports;
    }

    protected function loadSwiftMailerTranports()
    {
        /** @var MailQueueTransport $transport */
        foreach ($this->getTranports() as $transport) {
            $swiftTransport = (new \Swift_SmtpTransport($transport->getHost(), $transport->getPort()))
                ->setUsername($transport->getUsername())
                ->setPassword($transport->getPassword())
                ->setEncryption($transport->getEncryption());
            $this->addTransport($swiftTransport, $transport->getAlias());
        }
    }
}
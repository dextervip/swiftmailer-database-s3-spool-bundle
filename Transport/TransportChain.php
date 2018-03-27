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
    private $swiftTransports;

    /**
     * TransportChain constructor.
     * @param MailQueueTransportRepository $transportRepository
     * @param array $transports
     */
    public function __construct(MailQueueTransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
        $this->loadTranports();
    }


    public function addTransport(\Swift_Transport $transport, $alias)
    {
        $this->swiftTransports[$alias] = $transport;
    }

    /**
     * @return \Swift_Transport
     */
    public function getTransports()
    {
        return $this->swiftTransports;
    }

    public function getTransport($alias)
    {
        if (array_key_exists($alias, $this->swiftTransports)) {
            return $this->swiftTransports[$alias];
        }

        return null;
    }

    public function getTransportByTags(array $tags) : \Swift_Transport
    {
        $transports = $this->transportRepository->findBy(['enabled' => true]);
        /** @var MailQueueTransport $transport */
        $score = [];
        foreach ($transports as $transport){
            $score[$transport->getAlias()] = 0;
            foreach ($transport->getTags() as $tag){
                $score[$transport->getAlias()] += in_array($tag, $tags) ? 1 : 0;
            }
            if($score[$transport->getAlias()] == 0){
                unset($score[$transport->getAlias()]);
            }
        }

        if(count($score) > 0 ){
            arsort($score);
            return $this->getTransport(key($score));
        }

        $defaultTransport = $this->transportRepository->findOneBy(['enabled' => true, 'default' => true]);
        if($defaultTransport instanceof MailQueueTransport){
            return $this->getTransport($defaultTransport->getAlias());
        }

        throw new \Exception('No transports were found.');
    }

    protected function loadTranports(){
        $transports = $this->transportRepository->findBy(['enabled' => true]);
        /** @var MailQueueTransport $transport */
        foreach ($transports as $transport){
            $swiftTransport = (new \Swift_SmtpTransport($transport->getHost(), $transport->getPort()))
                ->setUsername($transport->getUsername())
                ->setPassword($transport->getPassword())
                ->setEncryption($transport->getEncryption())
            ;
            $this->addTransport($swiftTransport, $transport->getAlias());
        }
    }
}
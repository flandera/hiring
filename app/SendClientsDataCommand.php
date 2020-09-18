<?php


namespace App;

use App\Repository\ClientRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class SendClientsDataCommand extends Command
{
    const RETURN_CODE_ERROR = 1;
    const RETURN_CODE_SUCCESS = 0;

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var int
     */
    private $returnCode;

    /**
     * @var TransferClass
     */
    private $api;

    public function __construct()
    {
        parent::__construct();
        $this->returnCode = self::RETURN_CODE_SUCCESS;
        $this->clientRepository =  new ClientRepository();
        $this->api = new TransferClass();
    }

    /**
     * @var string
     */
    protected static $defaultName = 'send:clients';

    protected function configure()
    {
        $this->setHelp('call me with command send:clients');
        $this->setDescription('Sends clients data to API');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new ConsoleLogger($output);
        return $this->run($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $output->write("Starting to fetch Clients Data\n");
        $clients = $this->clientRepository->getClients();
        if (!empty($clients)) {
            $output->write("Succesfully fetched ".count($clients)." clients\n");
            $this->sendClientsData($clients, $output);
        }
        return $this->returnCode;
    }

    /**
     * @param array $clients
     * @param OutputInterface $output
     */
    private function sendClientsData(array $clients, OutputInterface $output)
    {
        $progressBar = new ProgressBar($output, count($clients));
        foreach ($clients as $client){
            try {
                $output->write("Starting to send Clients Data\n");
                $progressBar->advance();
                $this->api->send($client);
            } catch (\Exception $e) {
                $this->returnCode = self::RETURN_CODE_ERROR;
                $output->write("\nERROR: Sending client id: ".$client['id'].' failed! '.$e->getMessage());
            }
        }
        $progressBar->finish();
        $output->write("\nSending Clients Data to API finished\n");
    }
}
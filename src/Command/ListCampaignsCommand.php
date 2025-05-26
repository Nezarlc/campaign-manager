<?php

namespace App\Command;

use App\Repository\CampaignRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:list-campaigns',
    description: 'Muestra todas las campañas en formato de tabla',
)]
class ListCampaignsCommand extends Command
{
    private CampaignRepository $repository;

    public function __construct(CampaignRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $campaigns = $this->repository->findAll();

        if (empty($campaigns)) {
            $output->writeln('<comment>No hay campañas registradas.</comment>');
            return Command::SUCCESS;
        }

        $table = new Table($output);
        $table->setHeaders(['ID', 'Nombre', 'Descripción', 'Inicio', 'Fin']);

        foreach ($campaigns as $c) {
            $table->addRow([
                $c->getId(),
                $c->getName(),
                $c->getDescription(),
                $c->getStartDate()->format('Y-m-d'),
                $c->getEndDate()->format('Y-m-d'),
            ]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}

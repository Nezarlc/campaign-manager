<?php

namespace App\Command;

use App\Repository\CampaignRepository;
use App\Repository\InfluencerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:assign-influencer',
    description: 'Asigna un influencer a una campaña por ID',
)]
class AssignInfluencerCommand extends Command
{
    private EntityManagerInterface $em;
    private CampaignRepository $campaignRepo;
    private InfluencerRepository $influencerRepo;

    public function __construct(
        EntityManagerInterface $em,
        CampaignRepository $campaignRepo,
        InfluencerRepository $influencerRepo
    ) {
        parent::__construct();
        $this->em = $em;
        $this->campaignRepo = $campaignRepo;
        $this->influencerRepo = $influencerRepo;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('campaignId', InputArgument::REQUIRED, 'ID de la campaña')
            ->addArgument('influencerId', InputArgument::REQUIRED, 'ID del influencer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $campaignId = $input->getArgument('campaignId');
        $influencerId = $input->getArgument('influencerId');

        $campaign = $this->campaignRepo->find($campaignId);
        $influencer = $this->influencerRepo->find($influencerId);

        if (!$campaign) {
            $output->writeln("<error>Campaña con ID $campaignId no encontrada.</error>");
            return Command::FAILURE;
        }

        if (!$influencer) {
            $output->writeln("<error>Influencer con ID $influencerId no encontrado.</error>");
            return Command::FAILURE;
        }

        $campaign->addInfluencer($influencer);
        $this->em->flush();

        $output->writeln("<info>Influencer ID $influencerId asignado a la campaña ID $campaignId.</info>");

        return Command::SUCCESS;
    }
}

<?php

namespace App\Command;

use App\Entity\Influencer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:seed-influencers',
    description: 'Crea datos de prueba para influencers',
)]
class SeedInfluencersCommand extends Command
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (range(1, 10) as $i) {
            $influencer = new Influencer();
            $influencer->setName("Influencer $i");
            $influencer->setEmail("influencer$i@example.com");
            $influencer->setFollowersCount(rand(1000, 100000));

            $this->em->persist($influencer);
        }

        $this->em->flush();

        $output->writeln('<info>10 influencers creados correctamente</info>');

        return Command::SUCCESS;
    }
}

<?php

namespace App\Command;

use App\Entity\Campaign;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:create-campaign',
    description: 'Crea una nueva campaña solicitando los datos por consola',
)]
class CreateCampaignCommand extends Command
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $name = $helper->ask($input, $output, new Question('Nombre: '));
        $description = $helper->ask($input, $output, new Question('Descripción: '));
        $start = $helper->ask($input, $output, new Question('Fecha de inicio (YYYY-MM-DD): '));
        $end = $helper->ask($input, $output, new Question('Fecha de fin (YYYY-MM-DD): '));

        try {
            $startDate = new \DateTimeImmutable($start);
            $endDate = new \DateTimeImmutable($end);
        } catch (\Exception $e) {
            $output->writeln('<error>Formato de fecha inválido</error>');
            return Command::FAILURE;
        }

        if ($startDate >= $endDate) {
            $output->writeln('<error>La fecha de inicio debe ser anterior a la de fin</error>');
            return Command::FAILURE;
        }

        $campaign = new Campaign();
        $campaign->setName($name);
        $campaign->setDescription($description);
        $campaign->setStartDate($startDate);
        $campaign->setEndDate($endDate);

        $this->em->persist($campaign);
        $this->em->flush();

        $output->writeln('<info>Campaña creada correctamente</info>');

        return Command::SUCCESS;
    }
}

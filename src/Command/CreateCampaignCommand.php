<?php

namespace App\Command;

use App\Dto\CampaignInputDto;
use App\Mapper\CampaignMapper;
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
        $dto = new CampaignInputDto();
        $helper = $this->getHelper('question');

        $dto->name = $helper->ask($input, $output, new Question('Nombre: '));
        $dto->description = $helper->ask($input, $output, new Question('Descripción: '));
        $dto->start = $helper->ask($input, $output, new Question('Fecha de inicio (YYYY-MM-DD): '));
        $dto->end = $helper->ask($input, $output, new Question('Fecha de fin (YYYY-MM-DD): '));

        $campaign = CampaignMapper::fromDto($dto);

        if (!$campaign) {
            $output->writeln('<error>Fechas inválidas o incoherentes</error>');
            return Command::FAILURE;
        }

        $this->em->persist($campaign);
        $this->em->flush();

        $output->writeln('<info>Campaña creada correctamente</info>');

        return Command::SUCCESS;
    }
}

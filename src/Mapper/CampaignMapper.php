<?php

namespace App\Mapper;

use App\Dto\CampaignInputDto;
use App\Dto\CampaignOutputDto;
use App\Entity\Campaign;
use App\Entity\Influencer;

final class CampaignMapper
{
    public static function toDto(Campaign $campaign): CampaignOutputDto
    {
        $dto = new CampaignOutputDto();
        $dto->id = $campaign->getId();
        $dto->name = $campaign->getName();
        $dto->description = $campaign->getDescription();
        $dto->startDate = $campaign->getStartDate()->format('Y-m-d');
        $dto->endDate = $campaign->getEndDate()->format('Y-m-d');
        $dto->influencers = [];

        foreach ($campaign->getInfluencers() as $influencer) {
            if ($influencer instanceof Influencer) {
                $dto->influencers[] = $influencer->getName();
            }
        }

        return $dto;
    }

    public static function fromDto(CampaignInputDto $dto): ?Campaign
    {
        try {
            $startDate = new \DateTimeImmutable($dto->start);
            $endDate = new \DateTimeImmutable($dto->end);
        } catch (\Exception) {
            return null;
        }

        if ($startDate >= $endDate) {
            return null;
        }

        $campaign = new Campaign();
        $campaign->setName($dto->name);
        $campaign->setDescription($dto->description);
        $campaign->setStartDate($startDate);
        $campaign->setEndDate($endDate);

        return $campaign;
    }
}

<?php

namespace App\Entity;

use App\Repository\SearchByTitleRepository;
use Doctrine\ORM\Mapping as ORM;

class SearchByTitle
{

    private $Title;

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }
}

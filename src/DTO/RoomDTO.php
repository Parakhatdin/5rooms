<?php

namespace App\DTO;

class RoomDTO
{
    private ?int $id = null;
    private ?int $number = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     */
    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "number" => $this->getNumber()
        ];
    }

}
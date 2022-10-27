<?php

namespace App\DTO;

class RoomReserveDTO
{
    private ?int $id = null;
    private ?string $beginDate = null;
    private ?string $endDate = null;
    private ?string $ownerEmail = null;
    private ?RoomDTO $room = null;

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
     * @return string|null
     */
    public function getBeginDate(): ?string
    {
        return $this->beginDate;
    }

    /**
     * @param string|null $beginDate
     */
    public function setBeginDate(?string $beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @param string|null $endDate
     */
    public function setEndDate(?string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string|null
     */
    public function getOwnerEmail(): ?string
    {
        return $this->ownerEmail;
    }

    /**
     * @param string|null $ownerEmail
     */
    public function setOwnerEmail(?string $ownerEmail): void
    {
        $this->ownerEmail = $ownerEmail;
    }

    /**
     * @return RoomDTO|null
     */
    public function getRoom(): ?RoomDTO
    {
        return $this->room;
    }

    /**
     * @param RoomDTO|null $room
     */
    public function setRoom(?RoomDTO $room): void
    {
        $this->room = $room;
    }




    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "begin_date" => $this->getBeginDate(),
            "end_date" => $this->getEndDate(),
            "owner_email" => $this->getOwnerEmail(),
            "room" => $this->getRoom()?->toArray()
        ];
    }

}
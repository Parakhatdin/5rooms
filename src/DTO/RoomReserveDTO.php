<?php

namespace App\DTO;

use DateTime;

class RoomReserveDTO extends BaseDTO
{
    private ?int $id = null;
    private ?DateTime $beginDate = null;
    private ?DateTime $endDate = null;
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
     * @return DateTime|null
     */
    public function getBeginDate(): ?DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param DateTime|null $beginDate
     */
    public function setBeginDate(?DateTime $beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime|null $endDate
     */
    public function setEndDate(?DateTime $endDate): void
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
            "begin_date" => $this->getBeginDate()->format("Y-m-d H:i:s"),
            "end_date" => $this->getEndDate()->format("Y-m-d H:i:s"),
            "owner_email" => $this->getOwnerEmail(),
            "room" => $this->getRoom()?->toArray()
        ];
    }

}
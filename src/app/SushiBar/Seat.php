<?php

namespace SushiBar;

class Seat
{

    /** @var string|null $groupId */
    protected $groupId;
    protected $position;

    public function __construct(int $position)
    {
        $this->position = $position;
    }

    public function isEmpty(): bool
    {
        return is_null($this->groupId);
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setGroup(string $groupId): void
    {
        $this->groupId = $groupId;
    }

    public function getGroup(): ?string
    {
        return $this->groupId;
    }

    public function removeGroup(): void
    {
        $this->groupId = NULL;
    }

    public function __toString()
    {
        $groupLabel = $this->isEmpty() ? ' ' : $this->getGroup();
        return "{$this->getPosition()} [{$groupLabel}]";
    }
}
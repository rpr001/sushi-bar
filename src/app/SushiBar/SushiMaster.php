<?php

namespace SushiBar;

use InvalidArgumentException;

class SushiMaster
{

    const SEATS_PER_TABLE = 10;
    /** @var CircularTable $table */
    protected $table;

    public function __construct(CircularTable $table)
    {
        $this->table = $table;
    }

    public function addGroup(string $groupId, int $numGuests): void
    {
        if ($numGuests > $this->table->count()) {
            throw new InvalidArgumentException('Zu viele Gäste für den Tisch');
        }

        $emptySlots = [];
        for ($index = 0; $index < $this->table->count(); $index++) {
            $this->table->rewind();
            for ($resetIndex = 0; $resetIndex < $index; $resetIndex++) {
                $this->table->next();
            }
            for ($detectionIndex = 0; $detectionIndex < $this->table->count(); $detectionIndex++) {
                if (!$this->table->current()->isEmpty()) {
                    if($detectionIndex < $numGuests) {
                        unset($emptySlots[$index]);
                    }
                    break;
                }

                $this->table->next();
                $emptySlots[$index] = $detectionIndex + 1;
            }
        }

        asort($emptySlots);

        if (empty($emptySlots)) {
            throw new InvalidArgumentException('Nicht genügend freie Sitzplätze für diese Gruppe');
        }

        $firstMatchingSlot = array_keys($emptySlots)[0];
        $this->table->rewind();
        for ($index = 0; $index < $firstMatchingSlot; $index++) {
            $this->table->next();
        }

        for ($index = 0; $index < $numGuests; $index++) {
            $this->table->current()->setGroup($groupId);
            $this->table->next();
        }
        $this->table->rewind();

    }

    public function removeGroup(string $groupId): void
    {
        $this->table->rewind();
        for ($index = 0; $index < $this->table->count(); $index++) {
            if ($this->table->current()->getGroup() == $groupId) {
                $this->table->current()->removeGroup();
            }
            $this->table->next();
        }
    }

    /**
     * @return CircularTable
     */
    public function getTable() : CircularTable
    {
        return $this->table;
    }

}
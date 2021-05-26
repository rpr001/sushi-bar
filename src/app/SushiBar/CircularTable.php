<?php

namespace SushiBar;

use SplFixedArray;

class CircularTable extends SplFixedArray
{

    public function __construct(int $totalSeats)
    {
        parent::__construct($totalSeats);

        for ($index = 0; $index < $totalSeats; $index++) {
            $this[$index] = new Seat($index + 1);
        }
    }

    public function next() : void
    {
        if ($this->key() + 1 == $this->count()) {
            $this->rewind();
            return;
        }
        parent::next();
    }

    public function __toString()
    {
        return implode(' ', $this->toArray()) . "\n";
    }

    /**
     * @return array
     *
     * @psalm-return list<mixed>
     */
    public function toHash(): array {
        $seats = [];
        foreach($this->toArray() as $seat) {
            $seats[] = $seat->getGroup();
        }
        return $seats;
    }

}
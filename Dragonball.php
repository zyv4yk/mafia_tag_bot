<?php

namespace App;

class Dragonball
{

    /** @var int  */
    private $ballCount = 0;

    /**
     * Increace ball count
     */
    public function iFoundaBall(): void
    {
        $this->ballCount++;

        if ($this->ballCount === 7) {
            $this->ballCount = 0;
            $this->printMessage();
        }
    }

    /**
     * Print Message
     */
    protected function printMessage(): void
    {
        echo 'You can ask your wish is';
    }

}

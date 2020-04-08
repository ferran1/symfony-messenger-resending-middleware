<?php

namespace App\Stamps;

use Symfony\Component\Messenger\Stamp\StampInterface;

class   LoopCount implements StampInterface
{

    private $count;

    public function __construct($count){
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getCount(): int {
        return $this->count;
    }
}

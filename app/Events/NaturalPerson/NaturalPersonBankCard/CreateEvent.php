<?php

namespace App\Events\NaturalPerson\NaturalPersonBankCard;

use App\Events\BaseEvent;
use App\Models\NaturalPerson\NaturalPersonBankCard;

class CreateEvent extends BaseEvent
{
    public $naturalPersonBankCard;

    public function __construct(NaturalPersonBankCard $naturalPersonBankCard)
    {
        parent::__construct();
        $this->naturalPersonBankCard = $naturalPersonBankCard;
    }
}
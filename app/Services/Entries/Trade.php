<?php


namespace App\Services\Entries;

class Trade
{

    const DATE_FORMAT = 'd/m/Y';

    protected $currency;
    protected $buyDate;
    protected $sellDate;
    protected $revenue;

    public function __construct(string $currency, \DateTime $buyDate, \DateTime $sellDate, float $revenue)
    {
        $this->currency = $currency;
        $this->buyDate = $buyDate;
        $this->sellDate = $sellDate;
        $this->revenue = $revenue;
    }

    public function getMessage()
    {
        if ($this->revenue > 0) {

            return \sprintf(
                'If you would buy %s at %s and sell them %s you would get ~%s.',
                $this->currency,
                $this->buyDate->format(static::DATE_FORMAT),
                $this->sellDate->format(static::DATE_FORMAT),
                number_format($this->revenue, 2),
            );
        } else {
            return 'All options are bad.';
        }
    }
}

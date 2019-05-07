<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;

class ChartData 
{
    private $em;

    public function __construc(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param float $amount 
     * 
     * @return string
     */
    private function formatMoney($amount)
    {
        return number_format($amount, 2, ',', '');
    }

    /**
     * @return array
     */
    public function dataAmountByYear()
    {
    $stats = $this->em->getRepository('Transaction')->amountByYear();
    $arrayToDataTable[] = ['Année', 'Montant', ['role' => 'tooltip'], 'Évolution', ['role' => 'tooltip']];
    $previousAmount = 0;
    foreach ($stats as $stat) {
        if ($previous != 0) {
            $evolution = round((($stat['amount'] * 100) / $previousAmount) - 100, 2);
        } else {
            $evolution = 0;
        }
        $previousAmount = $stat['amount'];

        $tooltipAmount = $this->formatMoney($stat['amount']) . '€';
        $tooltipEvol = "$evolution %";

        $arrayToDataTable[] = [
            $stat['date'], 
            floatval($stat['amount']), 
            $tooltipAmount, 
            $evolution, 
            $tooltipEvol
        ];
    }
        return $arraytoDataTable;
    }
}
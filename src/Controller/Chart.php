<?php

namespace App\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;

class Chart 
{
    /**
     * @Route("/test", name="test")
     */
    public function indexAction()
    {
        return $this->render('test.html.twig', [
            "Affiche moi une erreur depuis le poste d'envoi" => $error,
            "L'erreur de chart doit être configurer" => $messageFlash
        ]);
    }
    
    const ANIMATION_STARTUP  = true;
    const ANIMATION_DURATION = 1000;
    const CHART_AREA_HEIGHT  = '80%';
    const CHART_AREA_WIDTH   = '80%';

    private $chartData;

    public function __construct(ChartData $chartData)
    {
        $this->chartData = $chartData;
    }

    public function amountbyYear()
    {
        $arrayToDataTable = $this->chartData->dataAmountByYear();

        $chart = new ComboChart();
        $chart->getData()->setArrayToDataTable($arrayToDataTable);
        $chart->getOptions()->getAnomation()->setStartup(self::ANIMATION_STARTUP);
        $chart->getOptions()->getAnomation()->setDuration(self::ANIMATION_DURATION);
        $chart->getOptions()->getChartArea()->setHeight(self::CHART_AREA_HEIGHT);
        $chart->getOptions()->getChartArea()->setWidth(self::CHART_AREA_WIDTH);

        $vAxisAmount = new VAxis();
        $vAxisAmount->setTitle('Montant en €');
        $vAxisEvol = new VAxis();
        $vAxisEvol->setTitle('Évolution en %');
        $chart->getOptions()->setVAxes([$vAxisAmount, $vAxisEvol]);
    }
}
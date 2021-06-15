<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class UxChartController extends AbstractController
{
    /** @var ChartBuilderInterface */
    private $chartBuilder;

    /**
     * @Route(path="/ux-chart", name="ux_chart")
     *
     * @param ChartBuilderInterface $chartBuilder
     *
     * @return Response
     */
    public function __invoke(ChartBuilderInterface $chartBuilder): Response
    {
        $this->chartBuilder = $chartBuilder;

        $randomColor = $this->getRandomColor();

        return $this->render('pages/ux_chart.html.twig', [
            'charts' => [
                'lineChart'     => $this->getChart(Chart::TYPE_LINE),
                'barChart'      => $this->getChart(Chart::TYPE_BAR),
                'radarChart'    => $this->getChart(Chart::TYPE_RADAR),
                'doughnutChart' => $this->getChart(Chart::TYPE_DOUGHNUT, $randomColor),
                'pieChart'      => $this->getChart(Chart::TYPE_PIE, $randomColor),
                'polarChart'    => $this->getChart(Chart::TYPE_POLAR_AREA, $randomColor),
            ],
        ]);
    }

    /**
     * @param string       $chartType
     * @param array|string $chartColor
     *
     * @return Chart
     */
    private function getChart(string $chartType, $chartColor = 'rgba(255, 99, 132, 0.5)'): Chart
    {
        $chart = $this->chartBuilder->createChart($chartType);
        $chart->setData([
            'labels'   => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'datasets' => [
                [
                    'label'           => 'My First dataset',
                    'backgroundColor' => $chartColor,
                    'borderColor'     => $chartColor,
                    'data'            => [15, 35, 45, 70, 55, 60, 95],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],
                ],
            ],
        ]);

        return $chart;
    }

    /**
     * @return array
     */
    private function getRandomColor(): array
    {
        $randomColor = [];
        for ($i=0; $i<7; $i++) {
            $randomColor[] = 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.5)';
        }

        return $randomColor;
    }
}

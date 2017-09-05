<?php
/**
 * User: idulevich
 */

namespace Neo\MainBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GetNasaDataCommand
 *
 * @package Neo\MainBundle\Command
 */
class GetNasaDataCommand extends Command implements ContainerAwareInterface
{
    /** @var  ContainerInterface */
    private $container;

    /** @var  EntityManager */
    private $entityManager;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('get:nasa:data')
            ->setDescription('Get data from NASA api');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $days = $this->container->getParameter('nasa.data.days') - 1;

        $upper = new \DateTime();

        $lower = new \DateTime();
        $lower->sub(new \DateInterval('P' . $days . 'D'));

        $url = 'https://api.nasa.gov/neo/rest/v1/feed'
            . '?start_date=' . $lower->format('Y-m-d')
            . '&end_date=' . $upper->format('Y-m-d')
            . '&detailed=true'
            . '&api_key=' . $this->container->getParameter('nasa.api.key');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://api.nasa.gov/neo/rest/v1/feed?start_date=2017-09-03&end_date=2017-09-05&detailed=true&api_key=N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD',
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        if ($resp !== false) {
            $asteroidService = $this->container->get('neo_main.neo_service');
            $nasaData = json_decode($resp, true);
            if (isset($nasaData['near_earth_objects'])) {
                for ($i = 0; $i <= $days; $i++) {
                    $actualDate = clone $lower;
                    $actualDate->add(new \DateInterval('P' . $i . 'D'));
                    $actual = $actualDate->format('Y-m-d');
                    if (isset($nasaData['near_earth_objects'][$actual])) {
                        $perDataDate = $nasaData['near_earth_objects'][$actual];
                        foreach ($perDataDate as $neoData) {
                            if (isset($neoData['neo_reference_id'])
                                && isset($neoData['name'])
                                && isset($neoData['is_potentially_hazardous_asteroid'])
                                && isset($neoData['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'])) {
                                $asteroid = $asteroidService->getOrCreateNeoAsteroid($neoData['neo_reference_id']);
                                $asteroid
                                    ->setDate($actualDate)
                                    ->setName($neoData['name'])
                                    ->setHazardous($neoData['is_potentially_hazardous_asteroid'])
                                    ->setSpeed($neoData['close_approach_data'][0]['relative_velocity']['kilometers_per_hour']);
                            }
                        }
                    }
                }
            }
            $this->entityManager->flush();
            if (isset($nasaData['element_count'])) {
                $output->writeln($nasaData['element_count']);
            }
        } else {
            throw new \Exception('Request error!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->entityManager = $container->get('doctrine')->getManager();
    }
}
<?php

namespace Neo\MainBundle\Controller;

use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @package Neo\MainBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return new JsonResponse(array(
            'hello' => 'world!'
        ));
    }

    /**
     * @return JsonResponse
     */
    public function hazardousAction()
    {
        return new JsonResponse(
            $this->getDoctrine()->getRepository('NeoMainBundle:Neo')
                ->getAllHazardousQueryBuilder()->getQuery()->getResult(Query::HYDRATE_ARRAY)
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function fastestAction(Request $request)
    {
        $hazardous = $this->container->get('neo_main.parameters_conversion_service')
            ->getBooleanValueOf($request->query->get('hazardous', false));

        return new JsonResponse(
            $this->getDoctrine()->getRepository('NeoMainBundle:Neo')
                ->getFastestQueryBuilder($hazardous)->getQuery()->getOneOrNullResult(Query::HYDRATE_ARRAY)
        );
    }
}

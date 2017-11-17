<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    const WIDTH  = 1000;
    const HEIGHT = 600;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', []);
    }

    /**
     * @param Request $request
     * @Route("/sort", name="sort", methods={"POST", "GET"})
     * @return JsonResponse
     */
    public function sortAction(Request $request)
    {
        $data = json_decode($request->request->get('data', null));
        $continue = false;
        if (count($data) === 0) {
            for ($i = 0; $i < self::HEIGHT; $i++) {
                $data[] = [
                    "x" => rand(0, self::WIDTH),
                    "y" => $i
                ];
            }
            $continue = true;
        } else {
            $continue = $this->bubbleSort($data);
        }
        return new JsonResponse([
            "continue" => $continue,
            "data" => $data
        ]);
    }

    private function bubbleSort(&$data)
    {
        $swap = false;
        for($i = 1; $i < count($data); $i++){
            if ($data[$i]->x < $data[$i - 1]->x){
                $swap = true;
                $swapX = $data[$i]->x;
                $data[$i]->x = $data[$i - 1]->x;
                $data[$i - 1]->x = $swapX;
            }
        }
        return $swap;
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\OrderDto;
use App\Exception\OrderFactoryNotFoundAppraisalException;
use App\Exception\ValidateException;
use App\Factory\OrderFactory;
use App\Repository\AppraisalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppraisalController extends AbstractController
{
    public function __construct(
        private readonly AppraisalRepository $appraisalRepository
    ){}

    #[Route('/appraisal', name: 'appraisal', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('appraisal/index.html.twig', [
            'appraisals' => $this->appraisalRepository->findAll(),
            'error' => '',
            'validate' => ''
        ]);
    }

    #[Route('/appraisal', name: 'appraisal_order', methods: ['POST'])]
    public function order(Request $request, OrderFactory $order): Response
    {
        $error = '';
        $validate = [];
        try{
            $order->create(new OrderDto($request->get('email'), $request->get('name')));
        } catch (OrderFactoryNotFoundAppraisalException $e) {
            $error = $e->getMessage();
        } catch (ValidateException $e) {
            $validate = $e->errors;
        }

        return $this->render('appraisal/index.html.twig', [
            'appraisals' => $this->appraisalRepository->findAll(),
            'error' => $error,
            'validate' => $validate
        ]);
    }
}

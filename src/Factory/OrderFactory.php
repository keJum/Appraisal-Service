<?php

namespace App\Factory;

use App\Dto\OrderDto;
use App\Entity\Order;
use App\Exception\OrderFactoryNotFoundAppraisalException;
use App\Exception\ValidateException;
use App\Repository\AppraisalRepository;
use App\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class OrderFactory
{
    use Validator;

    public function __construct(
        private ValidatorInterface           $validator,
        private EntityManagerInterface       $entityManager,
        private AppraisalRepository $appraisalRepository
    ){}

    /**
     * @throws ValidateException|OrderFactoryNotFoundAppraisalException
     */
    public function create(OrderDto $dto): void
    {
        $this->validate($this->validator, $dto);

        $appraisal = $this->appraisalRepository->findOneBy(['name' => $dto->name]);
        if (is_null($appraisal)) {
            throw new OrderFactoryNotFoundAppraisalException('Not found Appraisal');
        }
        $order = new Order();
        $order->setAppraisal($appraisal);
        $order->setEmail($dto->email);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}

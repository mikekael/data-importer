<?php

namespace App\Controller;

use App\Contract\Service\CustomerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * Create instance of the customer controller
     *
     * @param CustomerServiceInterface $service
     */
    public function __construct(
        protected CustomerServiceInterface $service
    ) {}

    /**
     * Retrieve all customers
     *
     * @return Response
     */
    #[Route('/customers')]
    public function all(): Response
    {
        $data = [];

        /** @var \App\DataTransfer\CustomerViewData */
        foreach ($this->service->all() as $customer) {
            $data[] = [
                'id' => $customer->getId(),
                'full_name' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'country' => $customer->getCountry(),
            ];
        }

        return $this->json($data);
    }

    /**
     * Retrieve single customer data
     *
     * @param  string|int $id
     *
     * @return Response
     */
    #[Route('/customers/{id<[0-9a-z\-]+>}')]
    public function view(int | string $id): Response
    {
        $customer = $this->service->get($id);

        if ($customer === null) {
            return $this->json([
                'message' => 'customer_not_found'
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $customer->getId(),
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ]);
    }
}

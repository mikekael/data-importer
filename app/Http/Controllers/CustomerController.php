<?php

namespace App\Http\Controllers;

use App\Contracts\Domain\CustomerRepository;
use App\Entities\Customer;
use App\Infrastructure\Uuid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CustomerController extends Controller
{
    protected CustomerRepository $customers;

    /**
     * Create controller instance
     *
     * @param \App\Contracts\Domain\CustomerRepository $customers
     */
    public function __construct(CustomerRepository $customers)
    {
        $this->customers = $customers;
    }

    /**
     * Shows the requested customer data
     *
     * @param  string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $id = Uuid::fromString($id);
        } catch (InvalidArgumentException $ex) {
            return new JsonResponse(['message' => 'Customer id is not a valid uuid.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($customer = $this->customers->find($id)) {
            return new JsonResponse([
                'id' => $customer->getId()->getValue(),
                'full_name' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'username' => $customer->getUsername(),
                'gender' => $customer->getGender(),
                'country' => $customer->getCountry(),
                'city' => $customer->getCity(),
                'phone' => $customer->getPhone(),
            ]);
        }

        return new JsonResponse(['message' => 'Customer not found.'], JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * Retrieved all customers
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $payload = $this->validate($request, [
            'page' => 'numeric',
            'per_page' => 'numeric',
        ]);

        $payload = array_merge(['page' => 1, 'per_page' => 100], $payload);

        $results = $this->customers->all((int) $payload['per_page'], (int) $payload['page'])->toArray();

        // map data to only use what should be displayed
        $results['data'] = array_map(fn(Customer $customer) => [
            'id' => $customer->getId()->getValue(),
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
        ], $results['data']);

        return new JsonResponse($results);
    }
}
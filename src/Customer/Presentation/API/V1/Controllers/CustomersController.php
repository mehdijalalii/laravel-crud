<?php

namespace Src\Customer\Presentation\API\V1\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Customer\Application\Resources\CustomersResponse;
use Src\Customer\Application\UseCases\Queries\Listing\SearchCustomersQuery;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class CustomersController
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customer",
     *     operationId="searchCustomers",
     *     tags={"Customers"},
     *     summary="List of customers",
     *     description="Retrieves a list of customers",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CustomersResponse1")
     *     ),
     * )
     *
     * @OA\Schema(
     *     schema="Customer",
     *     @OA\Property(property="id", type="string"),
     *     @OA\Property(property="firstName", type="string"),
     *     @OA\Property(property="lastName", type="string"),
     *     @OA\Property(property="dateOfBirth", type="string", format="date"),
     *     @OA\Property(property="phoneNumber", type="string"),
     *     @OA\Property(property="email", type="string", format="email"),
     *     @OA\Property(property="bankAccountNumber", type="string")
     * )
     *
     * @OA\Schema(
     *     schema="CustomersResponse1",
     *     @OA\Property(property="customers", type="array", @OA\Items(ref="#/components/schemas/Customer"))
     * )
     *
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var CustomersResponse $customersResponse */
        $customersResponse = $this->queryBus->ask(
            new SearchCustomersQuery()
        );

        return response()->json([
            'customers' => $customersResponse
        ]);
    }
}

<?php

namespace Src\Customer\Presentation\API\V1\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Customer\Application\Resources\CustomersResponse;
use Src\Customer\Application\UseCases\Queries\Get\GetCustomerByIdQuery;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class GetCustomerByIdController
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customer/{id}",
     *     summary="Get customer by ID",
     *     description="Get customer by ID",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="customer",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomersResponse")
     *             )
     *         ),
     *     )
     * )
     * @OA\Schema(
     *     schema="CustomersResponse",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example="dd403251-ef22-4755-b08f-2dfc6d99bdfa"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Mehdi Jalali"
     *     ),
     * )
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        /** @var CustomersResponse $customersResponse */
        $customerResponse = $this->queryBus->ask(
            new GetCustomerByIdQuery($id)
        );

        return response()->json([
            'customer' => (array) $customerResponse
        ]);
    }
}

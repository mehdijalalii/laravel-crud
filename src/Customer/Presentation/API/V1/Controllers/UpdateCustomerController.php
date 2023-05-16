<?php

namespace Src\Customer\Presentation\API\V1\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Customer\Application\UseCases\Commands\Update\UpdateCustomerCommand;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;

final class UpdateCustomerController
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    /**
     * @OA\Put(
     *     path="/api/v1/customer/{id}",
     *     summary="Update customer",
     *     description="Update customer",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="customer",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="string",
     *                     example="dd403251-ef22-4755-b08f-2dfc6d99bdfa",
     *                     description="The ID of the created customer"
     *                 )
     *             )
     *         ),
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="UpdateCustomerRequest",
     *     required={"first_name", "last_name", "date_of_birth", "email", "bank_account_number", "phone_number"},
     *     @OA\Property(
     *         property="id",
     *         type="string",
     *         example="dd403251-ef22-4755-b08f-2dfc6d99bdfa"
     *     ),
     *     @OA\Property(
     *         property="first_name",
     *         type="string",
     *         example="example"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         example="example"
     *     ),
     *     @OA\Property(
     *         property="date_of_birth",
     *         type="string",
     *         format="date",
     *         example="2020-01-20"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         example="example@example.com"
     *     ),
     *     @OA\Property(
     *         property="bank_account_number",
     *         type="integer",
     *         example=1234567890
     *     ),
     *     @OA\Property(
     *         property="phone_number",
     *         type="string",
     *         example="+989121234567"
     *     )
     * )
     */
    public function __invoke(\Src\Customer\Presentation\API\V1\Requests\CustomerRequest $request, string $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new UpdateCustomerCommand(
                $id,
                $request->first_name,
                $request->last_name,
                $request->date_of_birth,
                $request->email,
                $request->bank_account_number,
                $request->phone_number,
            )
        );

        return response()->json([
            'customer' => [
                'id' => $id
            ]
        ]);
    }
}

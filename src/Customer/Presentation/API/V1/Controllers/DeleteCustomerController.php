<?php

namespace Src\Customer\Presentation\API\V1\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Customer\Application\UseCases\Commands\Delete\DeleteCustomerByIdCommand;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;

final class DeleteCustomerController
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/customer/{id}",
     *     operationId="deleteCustomer",
     *     summary="Delete a customer",
     *     description="Delete a customer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content"
     *     ),
     * )
     */
    public function __invoke(string $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeleteCustomerByIdCommand($id)
        );

        return response()->json(null, 204);
    }
}

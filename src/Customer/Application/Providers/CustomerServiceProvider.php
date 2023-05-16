<?php

namespace Src\Customer\Application\Providers;

use Src\Customer\Application\UseCases\Commands\Create\CreateCustomerCommandHandler;
use Src\Customer\Application\UseCases\Commands\Delete\DeleteCustomerByIdCommandHandler;
use Src\Customer\Application\UseCases\Queries\Get\GetCustomerByIdQueryHandler;
use Src\Customer\Application\UseCases\Queries\Listing\SearchCustomerQueryHandler;
use Src\Customer\Application\UseCases\Subscriber\SomethingWithCreatedCustomerSubscriber;
use Src\Customer\Application\UseCases\Commands\Update\UpdateCustomerCommandHandler;
use Src\Customer\Domain\CustomerRepositoryInterface;
use Src\Customer\Infrastructure\Elequent\Repositories\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );

        $this->app->tag(
            CreateCustomerCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            DeleteCustomerByIdCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            GetCustomerByIdQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            SearchCustomerQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            UpdateCustomerCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            SomethingWithCreatedCustomerSubscriber::class,
            'domain_event_subscriber'
        );

        $this->loadRoutesFrom(__DIR__.'/../../Presentation/API/api.php');
        $this->loadRoutesFrom(__DIR__.'/../../Presentation/HTTP/web.php');
    }
}

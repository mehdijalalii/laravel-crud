Feature: Customer Management
    In order to manage customers
    As an API user
    I want to be able to perform CRUD operations on customers

Scenario: Create customer
    Given I generate a random customer payload
    And I send a POST request to "/api/v1/customer"
    Then the response status code should be 200
    And the response should be in JSON
    And the response body should have a "customer" key
    And the "customer" key should have a "id" field
    And I store the value of "id" statically as "userId"
    And send response

Scenario: Get customer info by ID
    And I send a GET request to "/api/v1/customer/{userId}"
    Then the response status code should be 200
    And the response should be in JSON
    And the response body should have a "customer" key

Scenario: List customers
    Given I send a GET request to "/api/v1/customer"
    Then the response status code should be 200
    And the response should be in JSON
    And the response body should have a "customers" key
#
Scenario: Update customer
    Given I generate a random updated customer payload
    And I send a PUT request to "/api/v1/customer/{userId}"
    Then the response status code should be 200
    And the response should be in JSON
    And the response body should have a "customer" key

Scenario: Delete customer
    And I send a DELETE request to "/api/v1/customer/{userId}"
    Then the response status code should be 204
    And the response should be empty

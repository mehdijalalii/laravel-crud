<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\Assert;
use Src\Customer\Infrastructure\Elequent\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureContext implements Context
{
    protected $baseUrl = 'http://localhost/api/v1';
    private static $userId;
    private $client;
    private $requestBody;
    private $response;

    /**
     * @BeforeScenario
     */
    public function setupScenario(BeforeScenarioScope $scope)
    {
        putenv('APP_ENV=testing');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * @Given I generate a random customer payload
     */
    public function generateRandomCustomerPayload()
    {
        $payload = Customer::factory()->make()->toArray();
        unset($payload["id"]);

        $this->requestBody = $payload;
    }

    /**
     * @When I send a GET request to :endpoint
     */
    public function sendGetRequest($endpoint)
    {
        $endpoint = str_replace('{userId}', self::$userId, $endpoint);
        $this->response = $this->client->get($endpoint);
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function assertResponseStatusCode($statusCode)
    {
        $responseStatusCode = $this->response->getStatusCode();
        Assert::assertEquals((int)$statusCode, $responseStatusCode);
    }

    /**
     * @Then the response should be in JSON
     */
    public function assertResponseIsJson()
    {
        $contentType = $this->response->getHeaderLine('Content-Type');
        Assert::assertStringContainsString('application/json', $contentType);
    }

    /**
     * @Then the response body should have a :key key
     */
    public function assertResponseBodyHasKey($key)
    {
        $responseData = json_decode($this->response->getBody(), true);
        Assert::assertArrayHasKey($key, $responseData);
    }

    /**
     * @Given /^the "([^"]*)" key should have a "([^"]*)" field$/
     */
    public function theKeyShouldHaveAField($key, $field)
    {
        $responseData = json_decode($this->response->getBody(), true);

        Assert::assertArrayHasKey($key, $responseData);

        Assert::assertArrayHasKey($field, $responseData[$key]);
    }


    /**
     * @Then the response body should have a :field field equal to :value
     */
    public function assertFieldEqualsValue($field, $value)
    {
        $responseData = json_decode($this->response->getBody(), true);
        Assert::assertEquals($value, $responseData[$field]);
    }

    /**
     * @Given I send a POST request to :endpoint
     */
    public function sendPostRequest($endpoint)
    {
        $this->response = $this->client->post($endpoint, [
            RequestOptions::JSON => $this->requestBody,
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @Given I send a PUT request to :endpoint
     */
    public function sendPutRequest($endpoint)
    {
        $endpoint = str_replace('{userId}', self::$userId, $endpoint);

        $this->response = $this->client->put($endpoint, ['json' => $this->requestBody]);
    }

    /**
     * @Given the variable :variableName is not empty
     */
    public function theVariableIsNotEmpty($variableName)
    {
        Assert::assertTrue(isset($this->$variableName));
    }

    /**
     * @Given I generate a random updated customer payload
     */
    public function generateRandomUpdatedCustomerPayload()
    {
        $payload = Customer::factory()->make()->toArray();
        unset($payload['id']);

        $this->requestBody = $payload;
    }

    /**
     * @Given I send a DELETE request to :endpoint
     */
    public function sendDeleteRequest($endpoint)
    {
        $endpoint = str_replace('{userId}', self::$userId, $endpoint);
        $this->response = $this->client->delete($endpoint);
    }

    /**
     * @Then the response should be empty
     */
    public function assertResponseIsEmpty()
    {
        $responseBody = $this->response->getBody()->getContents();

        Assert::assertEmpty($responseBody);
    }

    /**
     * @Given /^I have the user ID from the previous scenario$/
     * @throws Exception
     */
    public function iHaveTheUserIDFromThePreviousScenario()
    {
        if (empty(self::$userId)) {
            throw new Exception("User ID is not available from the previous scenario");
        }
    }

    /**
     * @Given /^I store the value of "([^"]*)" statically as "([^"]*)"$/
     */
    public function iStoreTheValueOfStaticallyAs($field, $variable)
    {
        $responseData = json_decode($this->response->getBody(), true);
        self::${$variable} = $responseData['customer'][$field];
    }
}


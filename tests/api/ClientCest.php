<?php

use Codeception\Util\HttpCode;
use Faker\Factory;
use app\models\Client;

class ClientCest
{
    public const MODEL_SCHEME = [
        'id' => ['type' => 'integer'],
        'firstName' => ['type' => 'string'],
        'lastName' => ['type' => 'string'],
        'email' => ['type' => 'string'],
        'phoneNumber' => ['type' => 'string'],
    ];

    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public static function generateClient()
    {
        $model = new Client([
            'id' => 1,
            'firstName' => 'Manas',
            'lastName' => 'Atabaev',
            'email' => 'user@example.com',
            'phoneNumber' => '+996 700 123 321',
        ]);
        $model->save();
    }

    public function createClient(ApiTester $I)
    {

        $faker = Factory::create();
        $data = [
            'firstName' => $faker->firstName,
            'lastName' => $faker->lastName,
            'email' => $faker->email,
            'phoneNumber' => '+996 700 123 321',
        ];
        $I->sendPost(
            'client',
            $data
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'id' => 'integer',
                'firstName' => 'string',
                'lastName' => 'string',
                'email' => 'string',
                'phoneNumber' => 'string',
            ]
        );
    }

    public function getClients(ApiTester $I)
    {
        $I->sendGet('client');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => static::MODEL_SCHEME,
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function getClient(ApiTester $I)
    {
        static::generateClient();
        $I->sendGet('client/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => static::MODEL_SCHEME,
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function updateClient(ApiTester $I)
    {
        static::generateClient();

        $faker = Factory::create();
        $newName = $faker->name;
        $I->sendPatch(
            'client/1',
            [
                'firstName' => $newName
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['firstName' => $newName]);
    }

    public function deleteClient(ApiTester $I)
    {
        static::generateClient();
        $I->sendDelete('client/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        //try to get deleted user
        $I->sendGet('client/1');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
    }
}

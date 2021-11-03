<?php

use Codeception\Util\HttpCode;
use Faker\Factory;
use app\models\Application;

class ApplicationCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public const MODEL_SCHEME = [
        'id' => ['type' => 'integer'],
        'clientId' => ['type' => 'integer'],
        'term' => ['type' => 'integer'],
        'amount' => ['type' => 'integer'],
        'currency' => ['type' => 'string'],
    ];

    public static function generateApplication()
    {
        ClientCest::generateClient();
        $model = new Application([
            'id' => 1,
            'clientId' => 1,
            'term' => 20,
            'amount' => 1500,
            'currency' => 'EUR',
        ]);
        $model->save();
    }

    public function createApplication(ApiTester $I)
    {
        ClientCest::generateClient();
        $faker = Factory::create();
        $data = [
            'clientId' => 1,
            'term' => 20,
            'amount' => 1500,
            'currency' => 'EUR',
        ];
        $I->sendPost(
            'application',
            $data
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'id' => 'integer',
                'clientId' => 'integer',
                'term' => 'integer',
                'amount' => 'integer',
                'currency' => 'string',
            ]
        );
    }

    public function getApplications(ApiTester $I)
    {
        static::generateApplication();
        $I->sendGet('application');
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

    public function getApplication(ApiTester $I)
    {
        static::generateApplication();
        $I->sendGet('application/1');
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

    public function updateApplication(ApiTester $I)
    {
        static::generateApplication();
        $faker = Factory::create();
        $newName = $faker->name;
        $I->sendPatch(
            'application/1',
            [
                'amount' => 2000
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['amount' => 2000]);
    }

    public function deleteApplication(ApiTester $I)
    {
        static::generateApplication();
        $I->sendDelete('application/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        //try to get deleted user
        $I->sendGet('application/1');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
    }
}

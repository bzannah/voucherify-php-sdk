<?php

use Voucherify\Test\Helpers\CurlMock;

use Voucherify\VoucherifyClient;
use Voucherify\ClientException;

class VouchersTest extends PHPUnit_Framework_TestCase 
{ 
    protected static $headers;
    protected static $apiId;
    protected static $apiKey;
    protected static $client;

    public static function setUpBeforeClass()
    {
        self::$apiId = "c70a6f00-cf91-4756-9df5-47628850002b";
        self::$apiKey = "3266b9f8-e246-4f79-bdf0-833929b1380c";
        self::$headers = [
            "Content-Type: application/json",
            "X-App-Id: " . self::$apiId,
            "X-App-Token: " . self::$apiKey,
            "X-Voucherify-Channel: PHP-SDK"
        ];
        self::$client = new VoucherifyClient(self::$apiId, self::$apiKey);

        CurlMock::enable();
    }

    public static function tearDownAfterClass()
    {
        CurlMock::disable();
    }
 
    public function testCreate()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->post("/vouchers/test-code", [
                "code" => "test-code",
                "type" => "DISCOUNT_VOUCHER"
            ])
            ->reply(200, []);

        self::$client->vouchers->create((object)[
            "code" => "test-code",
            "type" => "DISCOUNT_VOUCHER"
        ]);

        CurlMock::done();
    }

    public function testGet()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->get("/vouchers/test-code")
            ->reply(200, []);

        self::$client->vouchers->get("test-code");

        CurlMock::done();
    }

    public function testUpdateByObject()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->put("/vouchers/test-code", [
                "code" => "test-code",
                "type" => "DISCOUNT_VOUCHER"
            ])
            ->reply(200, []);

        self::$client->vouchers->update((object)[
            "code" => "test-code",
            "type" => "DISCOUNT_VOUCHER"
        ]);

        CurlMock::done();
    }

    public function testUpdateByArray()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->put("/vouchers/test-code", [
                "code" => "test-code",
                "type" => "DISCOUNT_VOUCHER"
            ])
            ->reply(200, []);

        self::$client->vouchers->update([
            "code" => "test-code",
            "type" => "DISCOUNT_VOUCHER"
        ]);

        CurlMock::done();
    }

    public function testDelete()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->delete("/vouchers/test-code")
            ->query([ "force" => "false" ])
            ->reply(200, []);

        self::$client->vouchers->delete("test-code");

        CurlMock::done();
    }

    public function testDeletePermamently()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->delete("/vouchers/test-code")
            ->query([ "force" => "true" ])
            ->reply(200, []);

        self::$client->vouchers->delete("test-code", true);

        CurlMock::done();
    }

    public function testGetList()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->get("/vouchers/")
            ->reply(200, []);

        self::$client->vouchers->getList();

        CurlMock::done();
    }

    public function testGetListByQuery()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->get("/vouchers/")
            ->query([ "campaign" => "test-campaign" ])
            ->reply(200, []);

        self::$client->vouchers->getList([ "campaign" => "test-campaign" ]);

        CurlMock::done();
    }

    public function testEnable()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->post("/vouchers/test-voucher/enable")
            ->reply(200, []);

        self::$client->vouchers->enable("test-voucher");

        CurlMock::done();
    }

    public function testDisable()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->post("/vouchers/test-voucher/disable")
            ->reply(200, []);

        self::$client->vouchers->disable("test-voucher");

        CurlMock::done();
    }

    public function testAddBalance()
    {
        CurlMock::register("https://api.voucherify.io/v1", self::$headers)
            ->post("/vouchers/test-voucher/balance", [
                "amount" => 22
            ])
            ->reply(200, []);

        self::$client->vouchers->addBalance("test-voucher", 22);

        CurlMock::done();
    }
}
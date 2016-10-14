<?php

use Hedii\ColissimoApi\ColissimoApi;

class ColissimoApiTest extends PHPUnit_Framework_TestCase
{
    private $id = '9V01144116749';

    private $wrongId = 'x9V01144112123';

    public function testGetAllReturnsAnArray()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->all();

        $this->assertTrue(is_array($array));
    }

    public function testGetAllArrayHasCorrectKeys()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->all();

        $this->assertArrayHasKey('status', $array, 'status key is missing');
        $this->assertArrayHasKey('id', $array, 'id key is missing');
        $this->assertArrayHasKey('destination', $array, 'destination key is missing');
    }

    public function testGetAllArrayHasCorrectValues()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->all();

        $this->assertTrue(!empty($array['status']), 'status is empty');
        $this->assertTrue(!empty($array['id']), 'id value is empty');
        $this->assertTrue(!empty($array['destination']), 'id value is empty');
    }

    public function testGetAllArrayHasStatusArrayThatContainsCorrectKeys()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->all();

        $this->assertArrayHasKey('date', $array['status'][0], 'date key is missing');
        $this->assertArrayHasKey('label', $array['status'][0], 'label key is missing');
        $this->assertArrayHasKey('location', $array['status'][0], 'location key is missing');
    }

    public function testGetAllArrayHasStatusArrayThatContainsCorrectValues()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->all();

        $this->assertTrue(!empty($array['status'][0]['date']), 'status date value is empty');
        $this->assertTrue(!empty($array['status'][0]['label']), 'status label value is empty');
    }

    public function testGetStatusReturnsAnArray()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->status();

        $this->assertTrue(is_array($array));
    }

    public function testGetStatusArrayHasArrayThatContainsCorrectKeys()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->status();

        $this->assertArrayHasKey('date', $array[0], 'date key is missing');
        $this->assertArrayHasKey('label', $array[0], 'label key is missing');
        $this->assertArrayHasKey('location', $array[0], 'location key is missing');
    }

    public function testGetStatusArrayHasArrayThatContainsCorrectValues()
    {
        $colissimoApi = new ColissimoApi();
        $array = $colissimoApi->get($this->id)->status();

        $this->assertTrue(!empty($array[0]['date']), 'date value is empty');
        $this->assertTrue(!empty($array[0]['label']), 'label value is empty');
    }

    public function testGetIdReturnsAString()
    {
        $colissimoApi = new ColissimoApi();
        $id = $colissimoApi->get($this->id)->id();

        $this->assertTrue(!empty($id), 'id is empty');
        $this->assertTrue(is_string($id), 'id is not a string');
    }

    public function testGetDestinationReturnsAString()
    {
        $colissimoApi = new ColissimoApi();
        $destination = $colissimoApi->get($this->id)->destination();

        $this->assertTrue(!empty($destination), 'destination is empty');
        $this->assertTrue(is_string($destination), 'destination is not a string');
    }

    public function testShowAllReturnsValidJson()
    {
        $colissimoApi = new ColissimoApi();
        $json = $colissimoApi->show($this->id)->all();

        $this->assertJson($json);
    }

    public function testShowAllMatchesGetAll()
    {
        $colissimoApi = new ColissimoApi();
        $get = $colissimoApi->get($this->id)->all();
        $json = $colissimoApi->show($this->id)->all();

        $this->assertJsonStringEqualsJsonString(json_encode($get), $json);
    }

    public function testShowStatusReturnsValidJson()
    {
        $colissimoApi = new ColissimoApi();
        $json = $colissimoApi->show($this->id)->status();

        $this->assertJson($json);
    }

    public function testShowStatusMatchesGetStatus()
    {
        $colissimoApi = new ColissimoApi();
        $get = $colissimoApi->get($this->id)->status();
        $json = $colissimoApi->show($this->id)->status();

        $this->assertJsonStringEqualsJsonString(json_encode($get), $json);
    }

    public function testShowIdReturnsValidJson()
    {
        $colissimoApi = new ColissimoApi();
        $json = $colissimoApi->show($this->id)->id();

        $this->assertJson($json);
    }

    public function testShowIdMatchesGetId()
    {
        $colissimoApi = new ColissimoApi();
        $get = $colissimoApi->get($this->id)->id();
        $json = $colissimoApi->show($this->id)->id();

        $this->assertJsonStringEqualsJsonString(json_encode($get), $json);
    }

    public function testShowDestinationReturnsValidJson()
    {
        $colissimoApi = new ColissimoApi();
        $json = $colissimoApi->show($this->id)->destination();

        $this->assertJson($json);
    }

    public function testShowDestinationMatchesGetDestination()
    {
        $colissimoApi = new ColissimoApi();
        $get = $colissimoApi->get($this->id)->destination();
        $json = $colissimoApi->show($this->id)->destination();

        $this->assertJsonStringEqualsJsonString(json_encode($get), $json);
    }

    public function testGetAllWithInvalidIdReturnsFalse()
    {
        $colissimoApi = new ColissimoApi();
        $result = $colissimoApi->get($this->wrongId)->destination();

        $this->assertEquals(false, $result);
    }

    public function testGetStatusWithInvalidIdReturnsFalse()
    {
        $colissimoApi = new ColissimoApi();
        $result = $colissimoApi->get($this->wrongId)->status();

        $this->assertEquals(false, $result);
    }

    public function testGetIdWithInvalidIdReturnsFalse()
    {
        $colissimoApi = new ColissimoApi();
        $result = $colissimoApi->get($this->wrongId)->id();

        $this->assertEquals(false, $result);
    }

    public function testGetDestinationWithInvalidIdReturnsFalse()
    {
        $colissimoApi = new ColissimoApi();
        $result = $colissimoApi->get($this->wrongId)->destination();

        $this->assertEquals(false, $result);
    }

    public function testShowAllWithInvalidIdReturnsErrorMessage()
    {
        $this->expectOutputString(json_encode('Invalid Colissimo id provided'));

        $colissimoApi = new ColissimoApi();
        $colissimoApi->show($this->wrongId)->all();
    }

    public function testShowStatusWithInvalidIdReturnsErrorMessage()
    {
        $this->expectOutputString(json_encode('Invalid Colissimo id provided'));

        $colissimoApi = new ColissimoApi();
        $colissimoApi->show($this->wrongId)->status();
    }

    public function testShowIdWithInvalidIdReturnsErrorMessage()
    {
        $this->expectOutputString(json_encode('Invalid Colissimo id provided'));

        $colissimoApi = new ColissimoApi();
        $colissimoApi->show($this->wrongId)->id();
    }

    public function testShowDestinationWithInvalidIdReturnsErrorMessage()
    {
        $this->expectOutputString(json_encode('Invalid Colissimo id provided'));

        $colissimoApi = new ColissimoApi();
        $colissimoApi->show($this->wrongId)->destination();
    }
}

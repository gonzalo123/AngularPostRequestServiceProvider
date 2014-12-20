<?php

use Silex\Application;
use G\AngularPostRequestServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class SilexApplicationExampleTest extends \PHPUnit_Framework_TestCase
{
    public function testJSONRequest()
    {
        $request = Request::create(
            '/post',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['name' => 'Gonzalo', 'surname' => 'Ayuso'])
        );

        $expected = '{"status":true,"name":"Gonzalo"}';
        $actual   = $this->getSilexApplication()->handle($request)->getContent();

        $this->assertEquals($expected, $actual);
    }

    public function testNonJSONRequest()
    {
        $request = Request::create(
            '/post',
            'POST',
            ['name' => 'Gonzalo', 'surname' => 'Ayuso'],
            [],
            [],
            ['CONTENT_TYPE' => 'application/x-www-form-urlencoded']);

        $actual = $this->getSilexApplication()->handle($request)->getContent();

        $this->assertEquals(json_encode(['status' => true, 'name' => 'Gonzalo']), $actual);
    }

    private function getSilexApplication()
    {
        $app = new Application();
        $app->register(new AngularPostRequestServiceProvider());

        $app->post("/post", function (Application $app, Request $request) {
            return $app->json([
                'status' => true,
                'name'   => $request->get('name')
            ]);
        });

        return $app;
    }
}
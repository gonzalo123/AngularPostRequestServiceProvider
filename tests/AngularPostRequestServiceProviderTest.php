<?php

use G\AngularPostRequestServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class AngularPostRequestServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testJSONRequest()
    {
        $app = $this->getMock('Silex\Application', ['before']);
        $app->expects($this->any())
            ->method('before')
            ->will($this->returnCallback(function ($closure) use ($app) {
                $request = Request::create(
                    '/',
                    'POST',
                    [],
                    [],
                    [],
                    ['CONTENT_TYPE' => 'application/json'],
                    json_encode(['name' => 'Gonzalo', 'surname' => 'Ayuso'])
                );
                $closure($request, $app);
                $this->assertEquals('Gonzalo', $request->get('name'));
                $this->assertEquals('Ayuso', $request->get('surname'));
            }));

        $provider = new AngularPostRequestServiceProvider();
        $provider->register($app);
    }

    public function testNonJSONRequest()
    {
        $transformer = $this->getMock('G\Transformer', ['transformContent']);
        $app         = $this->getMock('Silex\Application', ['before']);

        $app->expects($this->any())
            ->method('before')
            ->will($this->returnCallback(function ($closure) use ($app) {
                $request = Request::create(
                    '/',
                    'POST',
                    ['name' => 'Gonzalo', 'surname' => 'Ayuso'],
                    [],
                    [],
                    ['CONTENT_TYPE' => 'application/x-www-form-urlencoded']);
                $closure($request, $app);
                $this->assertEquals('Gonzalo', $request->get('name'));
                $this->assertEquals('Ayuso', $request->get('surname'));
            }));

        $provider = new AngularPostRequestServiceProvider($transformer);
        $provider->register($app);
    }

}
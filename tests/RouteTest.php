<?php

namespace Lune\Tests;

use Lune\Route;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public static function routesWithNoParameters()
    {
        return [
            'data set 1' => ['/'],
            'data set 2' => ['/test'],
            'data set 3' => ['/test/nested'],
            'data set 4' => ['/test/another/nested'],
            'data set 5' => ['/test/another/nested/route'],
            'data set 6' => ['/test/another/nested/very/nested/route'],
        ];
    }

    public static function routesWithParameters()
    {
        return [
            'data set 1' =>
            [
                '/test/{test}', 
                '/test/1', 
                ["test" => "1"]
            ],
            'data set 2' =>
            [
                '/users/{user}', 
                '/users/2', 
                ["user" => "2"]
            ],
            'data set 3' =>
            [
                '/test/{test}', 
                '/test/string', 
                ["test" => "string"]
            ],
            'data set 4' =>
            [
                '/test/nested/{route}', 
                '/test/nested/5',
                ["route" => "5"]
            ],
            'data set 5' =>
            [
                '/test/{param}/long/{test}/with/{multiple}/param', 
                '/test/12345/long/5/with/yellow/param',
                ["param" => "12345", "test" => "5", "multiple" => "yellow"]
            ],

        ];
    }


    /**
     * @dataProvider routesWithNoParameters
     * 
     */
    public function test_regex_with_no_parameters(string $uri)
    {

        $route = new Route($uri, fn () => 'Test');
        $this->assertTrue($route->matches($uri));
        $this->assertFalse($route->matches($uri . "/extra/path"));
        $this->assertFalse($route->matches("/some/path" . $uri));
        $this->assertFalse($route->matches("/random/path"));
    }

    /**
     * @dataProvider routesWithNoParameters
     * 
     */
    public function test_regex_on_uri_that_ends_with_slash(string $uri){
        $route = new Route($uri, fn () => 'Test');
        $this->assertTrue($route->matches($uri. "/"));
    }

    /**
     * @dataProvider routesWithParameters
     * 
     */
    public function test_regex_with_parameters(string $definition, string $uri)
    {

        $route = new Route($definition, fn () => 'Test');
        $this->assertTrue($route->matches($uri));
        $this->assertFalse($route->matches($uri . "/extra/path"));
        $this->assertFalse($route->matches("/some/path" . $uri));
        $this->assertFalse($route->matches("/random/path"));
    }

    /**
     * @dataProvider routesWithParameters
     * 
     */
    public function test_parse_parameters(string $definition, string $uri, array $expectedParameters)
    {
        $route = new Route($definition,  fn () => "test");
        $this->assertTrue($route->hasParameters());
        $this->assertEquals($expectedParameters, $route->parseParameters($uri));
    }
}

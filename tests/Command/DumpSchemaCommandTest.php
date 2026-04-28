<?php

namespace TheCodingMachine\GraphQLite\Bundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use TheCodingMachine\GraphQLite\Bundle\Tests\GraphQLiteTestingKernel;

class DumpSchemaCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $kernel = new GraphQLiteTestingKernel();
        $application = new Application($kernel);

        $command = $application->find('graphqlite:dump-schema');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        preg_match('/type Product \{(?P<body>[\s\S]*?)}/', $commandTester->getDisplay(), $matches);
        self::assertArrayHasKey('body', $matches);

        self::assertMatchesRegularExpression(
            '/name: String!/',
            $matches['body']
        );
        self::assertMatchesRegularExpression(
            '/price: Float!/',
            $matches['body']
        );
        self::assertMatchesRegularExpression(
            '/seller: Contact/',
            $matches['body']
        );
    }
}

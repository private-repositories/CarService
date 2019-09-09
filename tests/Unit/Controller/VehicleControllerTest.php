<?php declare(strict_types=1);

namespace DavegTheMighty\CarService\Test\Unit\Controller;

use Awurth\SlimValidation\ValidatorInterface;

use DavegTheMighty\CarService\Controller\VehicleController;
//phpcs:ignore PSR2.Namespaces.UseDeclaration.MultipleDeclarations
use DavegTheMighty\CarService\Model\{
    Owner
};

use PHPUnit\Framework\MockObject\MockObject;
use Mockery as m;
use PHPUnit\Framework\TestCase;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Interop\Container\ContainerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class VehiclelControllerTest extends TestCase
{
    /**
     * @var OriginalController
     */
    private $subject;

    /**
     * @var MockObject|ContainerInterface
     */
    private $container;

    /**
     * @var MockObject|LoggerInterface
     */
    private $logger;

    /**
     * @var MockObject|ValidatorInterface
     */
    private $validator;

    /**
     * @var MockObject|Owner
     */
    private $owner;

    public function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);

        $this->container->logger = $this->logger;
        $this->container->validator = $this->validator;

        //FIXME: Hard Dependency, which should be avoided
        $this->owner = m::mock('overload:DavegTheMighty\CarService\Model\Owner');

        $this->subject = new VehicleController($this->container);
    }

    /**
     * @dataProvider ownerIdDataProvider
     * @param string $testId
     */
    public function testGetByOwnerIdFailure(string $testId): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = new \Slim\Http\Response();

        $this->owner->shouldReceive('findOrFail')
            ->once()
            ->andThrow(new ModelNotFoundException('testy'));

        $this->logger
             ->expects($this->once())
             ->method('error')
             ->with("Owner not found for supplied id: {$testId}");

        $response = $this->subject->getByOwnerId($request, $response, ['owner_id' => $testId]);

        $this->assertEquals($response->getStatusCode(), '404');
    }

    public function ownerIdDataProvider(): array
    {
        $testData = [];
        $testData['invalid uuid'] = ['id' => '1234565'];
        $testData['invalid uuid two'] = ['id' => 'xxx'];

        return  $testData;
    }
}

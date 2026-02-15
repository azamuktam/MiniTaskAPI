<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\TaskService;
use App\Repositories\TaskRepositoryInterface;
use Mockery;
use Mockery\MockInterface;

/**
 * TaskServiceTest
 *
 * Handles both success scenarios and validation failure scenarios.
 */
class TaskServiceTest extends TestCase
{
    /**
     * Mocked TaskRepository dependency.
     *
     * @var TaskRepositoryInterface&MockInterface
     */
    private TaskRepositoryInterface|MockInterface $repositoryMock;

    /**
     * Service under test.
     *
     * @var TaskService
     */
    private TaskService $taskService;

    /**
     * Set up test dependencies.
     *
     * Creates a Mockery mock of TaskRepositoryInterface
     * and injects it into TaskService.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(TaskRepositoryInterface::class);
        $this->taskService = new TaskService($this->repositoryMock);
    }

    /**
     * Clean up Mockery container after each test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * SUCCESS: Test task creation with valid data.
     */
    public function testCreatesTaskWithValidData(): void
    {
        $input = ['title' => 'Valid Title', 'description' => 'This is a long enough description'];

        $this->repositoryMock->shouldReceive('create')
            ->once()
            ->andReturn(10);

        $id = $this->taskService->create($input);
        $this->assertEquals(10, $id);
    }

    /**
     * FAILURE: Test that creation fails if title is missing.
     */
    public function testCreateFailsWhenTitleIsMissing(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The field 'title' is required.");

        // Repository should NEVER be called
        $this->repositoryMock->shouldNotReceive('create');

        $this->taskService->create(['description' => 'Some desc']);
    }

    /**
     * FAILURE: Test that creation fails if title is too short.
     */
    public function testCreateFailsWhenTitleIsTooShort(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The field 'title' must be at least 3 characters.");

        $this->taskService->create(['title' => 'ab']);
    }

    /**
     * SUCCESS: Test update with valid data.
     */
    public function testUpdatesTaskWithValidData(): void
    {
        $input = ['title' => 'Updated Title', 'status' => 'done'];

        // Mock getById because update() checks if task exists
        $this->repositoryMock->shouldReceive('getById')->with(1)->andReturn(['id' => 1]);

        $this->repositoryMock->shouldReceive('update')
            ->with(1, 'Updated Title', '', 'done')
            ->once()
            ->andReturn(true);

        $this->taskService->update(1, $input);
        $this->assertTrue(true);
    }

    /**
     * FAILURE: Test that update fails with invalid status.
     */
    public function testUpdateFailsWithInvalidStatus(): void
    {
        $this->repositoryMock->shouldReceive('getById')->andReturn(['id' => 1]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("must be one of: pending, done");

        $this->taskService->update(1, [
            'title' => 'Valid Title',
            'status' => 'invalid_status'
        ]);
    }

    /**
     * SUCCESS: Test retrieval.
     */
    public function testReturnsAllTasks(): void
    {
        $this->repositoryMock->shouldReceive('getAll')->once()->andReturn([]);
        $result = $this->taskService->getAll();
        $this->assertIsArray($result);
    }

    /**
     * SUCCESS: Test deletion.
     */
    public function testDeletesTask(): void
    {
        $this->repositoryMock->shouldReceive('delete')->with(1)->once()->andReturn(true);
        $this->taskService->delete(1);
        $this->assertTrue(true);
    }
}
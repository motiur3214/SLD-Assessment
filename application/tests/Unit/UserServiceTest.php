<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Illuminate\Http\UploadedFile;
use App\Traits\FileUploadTrait;

class UserServiceTest extends TestCase
{
    protected $userMock;
    protected $userService;
    protected $fileUploadTraitMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userMock = Mockery::mock(User::class);
        $this->fileUploadTraitMock = Mockery::mock(FileUploadTrait::class);

        // Create a partial mock of UserService to inject the mocked trait
        $this->userService = Mockery::mock(UserService::class, [$this->userMock])->makePartial();
        $this->userService->shouldAllowMockingProtectedMethods();
        $this->userService->shouldReceive('FileUpload')->andReturnUsing([$this->fileUploadTraitMock, 'FileUpload']);
        $this->userService->shouldReceive('FileUpdate')->andReturnUsing([$this->fileUploadTraitMock, 'FileUpdate']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testList()
    {
        $paginatorMock = Mockery::mock(LengthAwarePaginator::class);
        Auth::shouldReceive('id')->andReturn(1);

        $this->userMock
            ->shouldReceive('where')
            ->with('id', '!=', 1)
            ->andReturnSelf()
            ->shouldReceive('paginate')
            ->with(10)
            ->andReturn($paginatorMock);

        $result = $this->userService->list(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function testListTrashed()
    {
        $paginatorMock = Mockery::mock(LengthAwarePaginator::class);

        $this->userMock
            ->shouldReceive('onlyTrashed')
            ->andReturnSelf()
            ->shouldReceive('paginate')
            ->with(10)
            ->andReturn($paginatorMock);

        $result = $this->userService->listTrashed(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function testRestore()
    {
        $user = Mockery::mock(User::class);

        $this->userMock
            ->shouldReceive('withTrashed')
            ->andReturnSelf()
            ->shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($user);

        $user->shouldReceive('restore')->andReturn(true);

        $result = $this->userService->restore(1);

        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $user = Mockery::mock(User::class);

        $this->userMock
            ->shouldReceive('withTrashed')
            ->andReturnSelf()
            ->shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($user);

        $user->shouldReceive('trashed')->andReturn(true);
        $user->shouldReceive('forceDelete')->andReturn(true);

        $result = $this->userService->delete(1);

        $this->assertTrue($result);
    }

    public function testDeleteNotTrashed()
    {
        $user = Mockery::mock(User::class);

        $this->userMock
            ->shouldReceive('withTrashed')
            ->andReturnSelf()
            ->shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($user);

        $user->shouldReceive('trashed')->andReturn(false);

        $result = $this->userService->delete(1);

        $this->assertFalse($result);
    }

    public function testDestroy()
    {
        $user = Mockery::mock(User::class);

        $this->userMock
            ->shouldReceive('find')
            ->with(1)
            ->andReturn($user);

        $user->shouldReceive('delete')->andReturn(true);

        $result = $this->userService->destroy(1);

        $this->assertTrue($result);
    }

    public function testFind()
    {
        $user = Mockery::mock(User::class);

        $this->userMock
            ->shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($user);

        $result = $this->userService->find(1);

        $this->assertSame($user, $result);
    }

    public function testStore()
    {
        // Mocking the data for creating a user
        $data = [
            'prefixname' => 'Mr',
            'firstname' => 'John',
            'middlename' => 'M',
            'lastname' => 'Doe',
            'suffixname' => 'Jr',
            'username' => 'johndoe',
            'email' => 'john.doe@example.com',
            'password' => 'password', // Note: Plain text password
            'password_confirmation' => 'password',
            'photo' => UploadedFile::fake()->image('photo.jpg')
        ];

        // Hashing the password using Bcrypt algorithm
        $data['password'] = bcrypt($data['password']);

        // Creating a mock of the CreateUserRequest
        $createUserRequest = Mockery::mock(CreateUserRequest::class)->makePartial();
        $createUserRequest->shouldReceive('validated')->andReturn($data);

        // Mocking array access methods
        foreach ($data as $key => $value) {
            $createUserRequest->shouldReceive('offsetGet')->with($key)->andReturn($value);
            $createUserRequest->shouldReceive('offsetExists')->with($key)->andReturn(isset($data[$key]));
        }

        // Initializing necessary properties of CreateUserRequest
        $createUserRequest->headers = new \Symfony\Component\HttpFoundation\HeaderBag([]);
        $createUserRequest->server = new \Symfony\Component\HttpFoundation\ServerBag([]);
        $createUserRequest->query = new \Symfony\Component\HttpFoundation\InputBag([]);
        $createUserRequest->request = new \Symfony\Component\HttpFoundation\InputBag($data);
        $createUserRequest->cookies = new \Symfony\Component\HttpFoundation\InputBag([]);
        $createUserRequest->files = new \Symfony\Component\HttpFoundation\FileBag(['photo' => $data['photo']]);
        $createUserRequest->attributes = new \Symfony\Component\HttpFoundation\ParameterBag([]);

        // Mocking the user creation
        $this->userMock
            ->shouldReceive('create')
            ->andReturnUsing(function ($data) {
                // Ensure that the password is hashed
                $this->assertTrue(Hash::check('password', $data['password']));
                $user = new User((array)$data);
                $user->id = 1;
                return $user;
            });

        // Mocking the file upload
        $this->fileUploadTraitMock
            ->shouldReceive('FileUpload')
            ->andReturn(true);

        // Mocking the URL generator for the Redirector
        $redirector = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirector->shouldReceive('getUrlGenerator')->andReturn(Mockery::mock(\Illuminate\Routing\UrlGenerator::class));

        // Mocking the redirector property in CreateUserRequest
        $createUserRequest->shouldReceive('redirector')->andReturn($redirector);

        // Injecting the mocked dependencies into the service
        $this->app->instance(User::class, $this->userMock);
        $this->app->instance(CreateUserRequest::class, $createUserRequest);

        // Calling the method under test
        $user = $this->userService->store($createUserRequest);

        // Asserting that the user was created successfully
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->id);
    }







    public function testUpdate()
    {
        // Mocking the data for updating a user
        $data = [
            'prefixname' => 'Mr',
            'firstname' => 'test',
            'middlename' => 'z',
            'lastname' => 'test',
            'suffixname' => 'Jr',
            'username' => 'test',
            'email' => 'test@test.com',
            'photo' => UploadedFile::fake()->image('photo.jpg')
        ];

        // Creating a mock of the UpdateUserRequest
        $updateUserRequest = Mockery::mock(UpdateUserRequest::class);
        $updateUserRequest->shouldReceive('validated')->andReturn($data);

        // Mocking the user retrieval and update
        $user = User::factory()->make(['id' => 1]);
        $this->userMock
            ->shouldReceive('find')
            ->with(1)
            ->andReturn($user);
        $this->userMock
            ->shouldReceive('update')
            ->with((array)$data)
            ->andReturn(true);

        // Mocking the file update
        $this->fileUploadTraitMock
            ->shouldReceive('FileUpdate')
            ->with(
                Mockery::type(UploadedFile::class),
                User::class,
                1,
                'user'
            )
            ->andReturn(true);

        // Injecting the mocked dependencies into the service
        $this->app->instance(User::class, $this->userMock);
        $this->app->instance(UpdateUserRequest::class, (array)$updateUserRequest);

        // Calling the method under test
        $result = $this->userService->update((array)$updateUserRequest, 1);

        // Asserting that the result matches the user object
        $this->assertSame($user, $result);
    }
//    public function testUpdate()
//    {
//        $data = [
//            'prefixname' => 'Mr',
//            'firstname' => 'Jane',
//            'middlename' => 'A',
//            'lastname' => 'Doe',
//            'suffixname' => 'Sr',
//            'username' => 'janedoe',
//            'email' => 'jane.doe@example.com',
//            'photo' => UploadedFile::fake()->image('photo.jpg')
//        ];
//
//        $updateUserRequest = UpdateUserRequest::create('/update', 'PUT', $data);
//        $updateUserRequest->setContainer($this->app)->validateResolved();
//        $validatedData = $updateUserRequest->validated();
//
//        $user = Mockery::mock(User::class);
//        $user
//            ->shouldReceive('find')
//            ->with(1)
//            ->andReturn($user);
//        $user
//            ->shouldReceive('update')
//            ->with((array)$validatedData)
//            ->andReturn($user);
//        $this->app->instance(User::class, $user);
//
//        $this->userService = new UserService($user);
//
//        $this->fileUploadTraitMock
//            ->shouldReceive('FileUpdate')
//            ->with(
//                Mockery::type(UploadedFile::class),
//                User::class,
//                1,
//                'user'
//            )
//            ->andReturn(true);
//
//        $result = $this->userService->update($validatedData, 1);
//
//        $this->assertSame($user, $result);
//    }

    public function testHash()
    {
        $password = 'password';
        $hashedPassword = $this->userService->hash($password);

        $this->assertTrue(Hash::check($password, $hashedPassword));
    }
}

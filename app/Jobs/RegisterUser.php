<?php

namespace App\Jobs;

use App\Events\UserCreated;
use DB;
use Eureka\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Mockery\Exception;
use Webpatser\Uuid\Uuid;

class RegisterUser extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Collection
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param Collection $data
     */
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $userRepository
     * @return array|null
     */
    public function handle(UserRepository $userRepository)
    {
        $data = $this->prepareData($this->data);
        DB::beginTransaction();
        try{
            $user = $userRepository->add($data);
        }catch (Exception $e){
            throw $e;
        }
        $verification_code = $this->generateOTP();
        $user->verification_code()->create([
            'code'=>$verification_code
        ]);
        try{
            event(new UserCreated($user));
        }catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    private function generateOTP()
    {
        return mt_rand(1000, 9999);
    }

    private function prepareData(Collection $payload)
    {
        $payload = $payload->except('dial_code');
        $password = bcrypt($payload->get('password'));
        $uuid = Uuid::generate(4);
        $data = array_add(array_add($payload->except('password')->all(), 'uuid', $uuid), 'type', 'user');
        return array_add($data, 'password', $password);
    }
}

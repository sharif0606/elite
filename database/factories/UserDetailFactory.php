<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use DB;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserDetailFactory extends Factory
{
    protected $model = UserDetail::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /*$users = User::all();
        foreach($users as $u){
            $userdetl = array(
                'user_id' => $u->id
            );
            DB::table('user_details')->insert($userdetl);
        }
        return true;*/
        return [
           'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}

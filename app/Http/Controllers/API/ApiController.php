<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class ApiController extends Controller
{

    /** @var User $user */
    protected $user;

    public function __construct()
    {
        if (session()->has('user_id')) {
            $uid = session()->get('user_id');
            $this->user = User::find(intval($uid));
        }
    }

    protected function failure(string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }

    protected function success(array $data = [])
    {
        $data['success'] = true;
        return response()->json($data);
    }

    protected function smpResponse(array $data)
    {
        $output = Yaml::dump($data);
        return response($output);
    }

    protected function smpFailure()
    {
        return abort(403);
    }

    protected function next(string $form, string $view, ?array $data = [])
    {
        $html = $this->getFormStep($form, $view, $data);
        return $this->success([
            'html' => $html,
            'data' => $data
        ]);
    }

    protected function getFormStep(string $form, string $step, ?array $data = []): string
    {
        $data['authuser'] =  $this->user;
        return view("$form.$step", $data)->render();
    }

    protected function getSMPUser($uuid): User
    {
        $uuid = str_replace('-', '', $uuid);
        $user = User::where('minecraft_id', $uuid)->first();
        return $user;
    }
}

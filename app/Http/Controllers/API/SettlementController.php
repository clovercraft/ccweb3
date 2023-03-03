<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Settlement;
use App\Models\SMP\Settlement as SMPSettlement;
use App\Services\DiscordService;
use App\Services\MinecraftService;
use Illuminate\Http\Request;

class SettlementController extends ApiController
{
    public function list(Request $request)
    {
        $settlements = Settlement::all();

        $data = [];
        foreach ($settlements as $model) {
            $data[] = (new SMPSettlement($model))->format();
        }
        return $this->smpResponse(['data' => $data]);
    }

    public function get(Settlement $settlement)
    {
        if (empty($settlement)) {
            return $this->smpFailure();
        }

        $data = (new SMPSettlement($settlement))->format();

        return $this->smpResponse($data);
    }

    public function create(Request $request, DiscordService $discord)
    {
        if (!$request->has('uuid') || !$request->has('name')) {
            return $this->smpFailure();
        }

        $user = $this->getSMPUser($request->get('uuid'));

        if (empty($user)) {
            return $this->smpFailure();
        }

        if (Settlement::where('name', $request->get('name'))->count() !== 0) {
            return $this->smpFailure();
        }

        $settlement = new Settlement();
        $settlement->name = $request->get('name');
        $settlement->slug = strtolower(str_replace(' ', '-', $request->get('name')));
        $settlement->save();

        $user->settlement_id = $settlement->id;
        $discord->setMemberSettlement($user, $settlement);
        $user->save();

        $data = (new SMPSettlement($settlement))->format();
        return $this->smpResponse($data);
    }

    public function citizens(MinecraftService $minecraft, Request $request)
    {
        if (!$request->has('settlement')) {
            return $this->smpFailure();
        }

        $settlement = Settlement::where('slug', $request->get('settlement'))->first();

        if (empty($settlement)) {
            return $this->smpFailure();
        }

        $data = [];
        foreach ($settlement->members as $member) {
            $player = $minecraft->getPlayer($member->minecraft_id);
            $data[] = $player->get('username');
        }
        return $this->smpResponse(['citizens' => $data]);
    }

    public function update(Settlement $settlement, Request $request)
    {
    }

    public function join(Request $request, DiscordService $discord)
    {
        if (!$request->has('uuid') || !$request->has('name')) {
            return $this->smpFailure();
        }

        $user = $this->getSMPUser($request->get('uuid'));

        if (empty($user)) {
            return $this->smpFailure();
        }

        $settlement = Settlement::where('slug', $request->get('name'))->first();

        if (empty($settlement)) {
            return $this->smpFailure();
        }

        $user->settlement_id = $settlement->id;
        $discord->setMemberSettlement($user, $settlement);
        $user->save();

        $data = (new SMPSettlement($settlement))->format();

        return $this->smpResponse($data);
    }
}

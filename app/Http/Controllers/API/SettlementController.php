<?php

namespace App\Http\Controllers\API;

use App\Models\Settlement;
use App\Models\SMP\Settlement as SMPSettlement;
use App\Facades\Discord;
use App\Facades\Minecraft;
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

    public function create(Request $request)
    {
        if (!$request->has('uuid') || !$request->has('name')) {
            return $this->smpFailure();
        }

        $uuid = $request->get('uuid');
        $name = $request->get('name');

        if (preg_match('/[^a-zA-Z]+/', $name) !== false) {
            return $this->smpFailure();
        }

        $user = $this->getSMPUser($uuid);

        if (empty($user)) {
            return $this->smpFailure();
        }

        if (Settlement::where('name', $name)->count() !== 0) {
            return $this->smpFailure();
        }

        $settlement = new Settlement();
        $settlement->name = $name;
        $settlement->slug = strtolower(str_replace(' ', '-', $name));
        $settlement->save();

        $user->settlement_id = $settlement->id;
        Discord::setMemberSettlement($user, $settlement);
        $user->save();

        $data = (new SMPSettlement($settlement))->format();
        return $this->smpResponse($data);
    }

    public function citizens(Request $request)
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
            $player = Minecraft::getPlayer($member->minecraft_id);
            $data[] = $player->get('username');
        }
        return $this->smpResponse(['citizens' => $data]);
    }

    public function join(Request $request)
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
        Discord::setMemberSettlement($user, $settlement);
        $user->save();

        $data = (new SMPSettlement($settlement))->format();

        return $this->smpResponse($data);
    }
}

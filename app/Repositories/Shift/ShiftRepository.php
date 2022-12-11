<?php

namespace App\Repositories\Shift;

use App\Models\Shift;

class ShiftRepository implements ShiftRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $shiftAll = Shift::all();
        return $shiftAll;
    }

    //INSERT
    public function insert($input)
    {
        Shift::create([
            'name' => $input['name'],
            'start' => $input['start'],
            'finish' => $input['finish']
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $shiftById = Shift::Where('id', '=', $input['id']);
        $odlValue = Shift::Where('id', $input['id'])->first();

        //update
        $shiftById->update([
            'name' => $input['name']?$input['name']:$odlValue['name'],
            'start' => $input['start']?$input['start']:$odlValue['start'],
            'finish' => $input['finish']?$input['finish']:$odlValue['finish'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $shiftById = Shift::find($input);
        $shiftById->delete();
    }
}
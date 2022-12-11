<?php

namespace App\Services\Bill;

interface BillServiceInterface {
    public function destroy($id);
    public function show($id);
    public function billsByDate($date);
    public function update($input);
}
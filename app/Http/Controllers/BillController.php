<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\ShipRequest;
use App\Http\Requests\Order\TakeAwayRequest;
use App\Http\Requests\DateRequest;
use App\Http\Requests\IdRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Services\Order\OrderServiceInterface;
use App\Services\Ship\ShipServiceInterface;
use App\Services\Bill\BillServiceInterface;
use Exception;
use App\Repositories\Bill\BillRepositoryInterface;

class BillController extends Controller
{
    protected $orderService;
    protected $shipService;
    protected $billService;
    protected $billRepository;
    
    public function __construct(
        OrderServiceInterface $orderService, 
        ShipServiceInterface $shipService,
        BillServiceInterface $billService,
        BillRepositoryInterface $billRepository
    )
    {
        $this->orderService = $orderService;
        $this->shipService = $shipService;
        $this->billService = $billService;
        $this->billRepository = $billRepository;
    }
    
    //Order
    public function orderLive(OrderRequest $request)
    {
        try{           
            $input = [
                'tableId' => $request->table_id,
                'products' => $request->products
            ];   
           
            $this->orderService->order($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Order successfully!" ,
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Order failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        } 
    }
    
    //Ship
    public function ship(ShipRequest $request)
    {
        try{
            $input = [
                'products' => $request->products,
                'ship_address' => $request->ship_address,
                'phone_number' => $request->phone_number,
            ];
            
            $this->shipService->ship($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Order for ship succesfully!",   
                'data' => 'No data!',
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Order failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //Take-away
    public function takeAway(TakeAwayRequest $request)
    {
        try{
            $input = [
                'products' => $request->products,
            ];
            $this->orderService->takeAway($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Order for taking away succesfully!",   
                'data' => 'No data!',
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Order for taking away failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }


    //Destroy bill
    public function destroy(IdRequest $request)
    {
        try{
            $id = $request->id;
                
            $this->billService->destroy($id);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete bill succesfully!",   
                'data' => 'No data!',
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete bill failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //Show bill detail
    public function show(IdRequest $request)
    {
        try{
            $id = $request->id;
                
            $this->billService->show($id);
            
            return response()->json([
                'status' => 'True',
                'message' => "Show bill succesfully!",   
                'data' => $this->billService->show($id),
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Show bill failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //Get bills by date
    public function getbillsByDate(DateRequest $request)
    {
        try{
            $date = $request->date;
            $this->billService->billsByDate($date);
            
            return response()->json([
                'status' => 'True',
                'message' => "Get bills by date succesfully!",   
                'data' =>   $this->billService->billsByDate($date),
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get bills by date failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //Update bill     ( REQUIRE FULL PRODUCTS FIELS)
    public function update(UpdateBillRequest $request)
    {
        try{
            $input = [
                 'id' => $request->id,
                 'products' => $request->products,
                 'orderDate' => $request->order_date,
                 'phoneNumber' => $request->phone_number,
                 'address' => $request->ship_address,
                 'numberTable' => $request->number_table,
            ];
            //Check data suits id
            $idOrderRecord = $this->billRepository->idOrderRecord($input['id']);
            $shipId = $idOrderRecord->ship_order_id;
            $tableId = $idOrderRecord->table_id;
            $isTakeAway = $idOrderRecord->is_take_away;
            
            //Check validate bill
            if((isset($input['phoneNumber']) && isset($input['numberTable'])) || (isset($input['address'])&& isset($input['numberTable']))){
                return response()->json([
                    'status' => 'False',
                    'message' => "You need to update just one of three bill types: Bill-live, bill-ship or bill-take-away!!",   
                    'data' => 'No data',
                    'error' => 'True',
                ],422);    
            }
            
            //Check data suits 3 types of bill
            if(isset($tableId) && (isset($input['phoneNumber']) || isset($input['address']))){
                return response()->json([
                    'status' => 'False',
                    'message' => "Updated data does match with live-bill!",   
                    'data' => 'No data',
                    'error' => 'True',
                ],422);  
            }
            if(isset($shipId) && isset($input['numberTable'])){
                return response()->json([
                    'status' => 'False',
                    'message' => "Updated data does match with ship-bill!",   
                    'data' => 'No data',
                    'error' => 'True',
                ],422);  
            }
            if($isTakeAway === 1 && (isset($input['numberTable']) || isset($input['phoneNumber']) || isset($input['address']))){
                return response()->json([
                    'status' => 'False',
                    'message' => "Updated data does match with take-away-bill!",   
                    'data' => 'No data',
                    'error' => 'True',
                ],422);  
            }

            $this->billService->update($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Update bill succesfully!",   
                'data' => 'No data',
                'error' => 'False',
            ],200); 
            
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update bill failed!" ,
                'data' => 'No data',
                'error' => 'True', $e
            ],404);  
        }
    }
}
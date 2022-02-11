<?php

phonespace App\Http\Controllers\API;

use Validator;
use App\Models\OrderPrimary;
use Illuminate\Http\Request;
use App\Http\Resources\OrderPrimary as OrderPrimaryResource;
use App\Http\Controllers\API\BaseController as BaseController;

class OrderPrimaryController extends BaseController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $orderPrimaries = OrderPrimary::all();

    return $this->sendResponse(OrderPrimaryResource::collection($orderPrimaries), 'Orders retrieved successfully.');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'phone' => 'required'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $orderPrimary = OrderPrimary::create($input);

    return $this->sendResponse(new OrderPrimaryResource($orderPrimary), 'Order created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $orderPrimary = OrderPrimary::find($id);

    if (is_null($orderPrimary)) {
      return $this->sendError('Order not found.');
    }

    return $this->sendResponse(new OrderPrimaryResource($orderPrimary), 'Order retrieved successfully.');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $orderPrimary)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'phone' => 'required'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $orderPrimary = OrderPrimary::update($input);

    return $this->sendResponse(new OrderPrimaryResource($orderPrimary), 'Order updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $orderPrimary)
  {
    $orderPrimary->delete();

    return $this->sendResponse([], 'Order deleted successfully.');
  }
}

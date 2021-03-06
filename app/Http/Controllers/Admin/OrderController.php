<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Order\OrderStatus;
use App\Repositories\User\UserRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class OrderController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orders;

    /**
     * OrderController constructor.
     * @param OrderRepository $orders
     */
    public function __construct(OrderRepository $orders)
    {
        $this->middleware('auth');
        $this->middleware('locale'); 
        $this->middleware('timezone'); 
        $this->orders = $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BranchOfficeRepository $branchOfficeRepository)
    {
        $status_admin = ($request->status_admin == 1) ? true : false;
        $orders = $this->orders->paginate_search(10, $request->search, null, $request->status, $status_admin, $request->status_driver, $request->branch_office);
        $branch_offices = ['' => trans('app.all_branchs')] + $branchOfficeRepository->lists();
        $status_admin = [
            '' => trans('app.all_status_payment'), 
            true  => trans('app.canceled'), 
            false  => trans('app.pending_payment')
        ];
        $status_order = [
            '' => trans('app.all_status_order'), 
            true  => trans('app.confirmed'), 
            false  => trans('app.Unconfirmed')
        ];
        $status_driver = ['' => trans('app.all_status_driver')] + OrderStatus::lists();
        if ( $request->ajax() ) {
            if (count($orders)) {
                return response()->json([
                    'success' => true,
                    'view' => view('admin-orders.list', compact('orders', 'branch_offices', 'status', 'status_admin', 'status_driver', 'status_order'))->render(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('app.no_records_found')
                ]);
            }
        }

        return view('admin-orders.index', compact('orders', 'branch_offices', 'status', 'status_admin', 'status_driver', 'status_order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finance($client, Request $request, UserRepository $userRepository, BranchOfficeRepository $branchOfficeRepository)
    {
        $user = $userRepository->find($client);
        $status_admin = ($request->status_admin == 1) ? true : false;
        $orders = $this->orders->paginate_search(10, $request->search, $client, $request->status, $status_admin, $request->status_driver, $request->branch_office);
        $status_driver = ['' => trans('app.all_status_driver')] + OrderStatus::lists();
        $branch_offices = ['' => trans('app.all_branchs')] + $branchOfficeRepository->lists();
        $status = [
            '' => trans('app.all_status_order'), 
            true  => trans('app.confirmed'), 
            false  => trans('app.Unconfirmed')
        ];
        $status_admin = [
            '' => trans('app.all_status_payment'), 
            true  => trans('app.canceled'), 
            false  => trans('app.pending_payment')
        ];
       if ( $request->ajax() ) {
            if (count($orders)) {
                return response()->json([
                    'success' => true,
                    'view' => view('admin-orders.finance.list', compact('orders', 'status', 'status_driver', 'user', 'branch_offices', 'status_admin'))->render(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('app.no_records_found')
                ]);
            }
        }

        return view('admin-orders.finance.index', compact('orders', 'status', 'status_driver', 'user', 'branch_offices', 'status_admin'));
    }

    public function changeConfirmed($id, Request $request) 
    {
        $order = $this->orders->find($id);
        $status_order = [
            '' => trans('app.all_status_order'), 
            true  => trans('app.confirmed'), 
            false  => trans('app.Unconfirmed')
        ];
        if ( $order ) {
            return response()->json([
                'success' => true,
                'view' => view('admin-orders.edit_confirmed', compact('order', 'status_order'))->render()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('app.no_record_found')
            ]);
        }
    }

    public function updateConfirmed($id, Request $request) 
    {
        $order = $this->orders->find($id);
        $payment_id = $order->order_payment->id;
        $payment = $this->orders->update_payment(
            $payment_id, 
            ['confirmed' => $request->confirmed_payment]
        );
        if ($order->order_penalty) {
            $penalty_id = $order->order_penalty->id;
            $penalty = $this->orders->update_penalty(
                $penalty_id, 
                ['confirmed' => $request->confirmed_penalty]
            );
        }
        if ( $payment ) {

            return response()->json([
                'success' => true,
                'message' => trans('app.order_confirmed_updated')
            ]);
        } else {
            
            return response()->json([
                'success' => false,
                'message' => trans('app.error_again')
            ]);
        }
    }

    public function changeStatus($id, Request $request) 
    {
        $order = $this->orders->find($id);
        $status = OrderStatus::lists();
        if ( $order ) {
            return response()->json([
                'success' => true,
                'view' => view('admin-orders.edit_status', compact('order', 'status'))->render()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('app.no_record_found')
            ]);
        }
    }

    public function updateStatus($id, Request $request) 
    {
        $order = $this->orders->update($id, $request->all());

        if ( $order ) {

            return response()->json([
                'success' => true,
                'message' => trans('app.order_status_updated')
            ]);
        } else {
            
            return response()->json([
                'success' => false,
                'message' => trans('app.error_again')
            ]);
        }
    }
}

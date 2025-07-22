<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckOutRequest;
use App\Models\Payment;
use App\Services\CheckOutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CheckOutController extends Controller
{
    /**
     * @var CheckOutService
     */
    private $checkOutService;

    /**
     * CheckOutController constructor.
     *
     * @param CheckOutService $checkOutService
     */
    public function __construct(CheckOutService $checkOutService)
    {
        $this->checkOutService = $checkOutService;
    }
    /**
     * hiển thị trang thanh toán
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // nếu giỏ hàng trống thì không cho vào trang thanh toán
        if (count(Cart::getContent()) <= 0) {
            return back();
        }
        // trả về cho phía khách hàng
        if (count($this->checkOutService->index()) == 0) {
            return redirect()->route('user.home')->with('error', 'Có lỗi xảy ra vui lòng kiểm tra lại');
        }
        return view('client.checkout', $this->checkOutService->index());
    }

    // xử lý khi người dùng bấm nút thanh toán đơn hàng
    public function store(CheckOutRequest $request)
    {
        if (Session::has('info_order')) {
            Session::forget('info_order');
        }
        Session::put('info_order', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'address' => $request->address,
            'district' => $request->district,
            'ward' => $request->ward,
        ]);
        // nếu khách hàng chọn thanh toán online momo
        if ($request->payment_method == Payment::METHOD['momo']) {
            return $this->checkOutService->paymentMomo($request);
        }
        // nếu khách hàng chọn thanh toán online vnpay
        if ($request->payment_method == Payment::METHOD['vnpay']) {
            return $this->checkOutService->paymentVNPAY($request);
        }
        return $this->checkOutService->store($request);
    }

    public function callbackMomo(Request $request)
    {
        return $this->checkOutService->callbackMomo($request);
    }

    public function applyVoucher(Request $request)
    {
        $code = $request->input('voucher_code');
        $voucher = \App\Models\Voucher::where('code', $code)->first();
        if (!$voucher) {
            return redirect()->back()->with('voucher_message', 'Mã voucher không tồn tại!');
        }
        if (!$voucher->isValid()) {
            return redirect()->back()->with('voucher_message', 'Voucher đã hết hạn hoặc đã sử dụng hết!');
        }
        // Lưu voucher vào session để áp dụng khi thanh toán
        session(['applied_voucher' => $voucher->code]);
        return redirect()->back()->with('voucher_message', 'Áp dụng voucher thành công!');
    }

    public function apiApplyVoucher(Request $request)
    {
        $code = $request->input('voucher_code');
        $total = $request->input('total');
        $voucher = \App\Models\Voucher::where('code', $code)->first();
        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không tồn tại!',
            ]);
        }
        if (!$voucher->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher đã hết hạn hoặc đã sử dụng hết!',
            ]);
        }
        $discount = $voucher->applyDiscount($total);
        $newTotal = max(0, $total - $discount);
        return response()->json([
            'success' => true,
            'message' => 'Áp dụng voucher thành công!',
            'discount' => $discount,
            'new_total' => $newTotal,
        ]);
    }
}

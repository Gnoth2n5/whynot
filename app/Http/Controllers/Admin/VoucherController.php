<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Helpers\TextSystemConst;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::paginate(10);
        $title = 'Danh sách voucher';
        return view('admin.vouchers.index', compact('vouchers', 'title'));
    }

    public function create()
    {
        $title = 'Thêm voucher';
        return view('admin.vouchers.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
        ], [
            'code.required' => 'Mã voucher không được bỏ trống.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'start_date.required' => 'Ngày bắt đầu không được bỏ trống.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu không được nằm trong quá khứ.',
            'end_date.required' => 'Ngày kết thúc không được bỏ trống.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'quantity.required' => 'Số lượng không được bỏ trống.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'discount_percentage.required' => 'Giảm giá không được bỏ trống.',
            'discount_percentage.numeric' => 'Giảm giá phải là một số.',
            'max_discount_amount.required' => 'Giảm tối đa không được bỏ trống.',
            'max_discount_amount.numeric' => 'Giảm tối đa phải là một số.',
        ]);
        Voucher::create($request->all());
        return redirect()->route('admin.vouchers_index')->with('success', 'Thêm thành công.');
    }

    public function edit(Voucher $voucher)
    {
        $title = 'Sửa voucher';
        return view('admin.vouchers.edit', compact('voucher', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code,' . $id,
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
        ], [
            'code.required' => 'Mã voucher không được bỏ trống.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'start_date.required' => 'Ngày bắt đầu không được bỏ trống.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu không được nằm trong quá khứ.',
            'end_date.required' => 'Ngày kết thúc không được bỏ trống.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'quantity.required' => 'Số lượng không được bỏ trống.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'discount_percentage.required' => 'Giảm giá không được bỏ trống.',
            'discount_percentage.numeric' => 'Giảm giá phải là một số.',
            'max_discount_amount.required' => 'Giảm tối đa không được bỏ trống.',
            'max_discount_amount.numeric' => 'Giảm tối đa phải là một số.',
        ]);

        $voucher = Voucher::findOrFail($id);
        $voucher->update($request->all());

        return redirect()->route('admin.vouchers_index')->with('success', 'Cập nhật thành công.');
    }

    public function delete(Voucher $voucher)
    {

            // Kiểm tra xem voucher có tồn tại không
            if (!$voucher) {
                return redirect()->route('admin.vouchers_index')->with('error', TextSystemConst::DELETE_FAILED);
            }

            // Thử xóa voucher
            $result = $voucher->delete(); // Sử dụng soft delete nếu bật SoftDeletes

            // Kiểm tra kết quả xóa
            if ($result) {
                return redirect()->route('admin.vouchers_index')->with('success', 'Xóa thành công.');
            }

            return redirect()->route('admin.vouchers_index')->with('error', TextSystemConst::DELETE_FAILED);
        
    }
}

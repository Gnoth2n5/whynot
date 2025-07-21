<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\HomeService;

class HomeController extends Controller
{
    /**
     * @var HomeService
     */
    private $homeService;

    /**
     * Khởi tạo HomeController với tiêm phụ thuộc HomeService
     *
     * - Thêm constructor để tiêm HomeService
     * - Lưu trữ instance HomeService vào thuộc tính private để sử dụng trong các phương thức
     *
     * @param HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * Hiển thị trang chủ website
     *
     * - Triển khai phương thức index() để render view 'client.index' với dữ liệu từ HomeService
     * - Sử dụng HomeService đã được tiêm để lấy dữ liệu
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.index', $this->homeService->index());
    }

    /**
     * Hiển thị trang bảo trì
     *
     * - Triển khai phương thức maintenance() để lấy bản ghi Setting đầu tiên
     * - Render view 'client.maintenance' với dữ liệu setting
     *
     * @return \Illuminate\View\View
     */
    public function maintenance()
    {
        $setting = Setting::first();
        return view('client.maintenance', ['setting' => $setting]);
    }

    /**
     * Hiển thị trang giới thiệu
     *
     * - Triển khai phương thức introduction() để lấy bản ghi Setting đầu tiên
     * - Render view 'client.introduction' với dữ liệu setting
     *
     * @return \Illuminate\View\View
     */
    public function introduction()
    {
        $setting = Setting::first();
        return view('client.introduction', ['setting' => $setting]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromotionController extends Controller
{
    /**
     * Hiển thị danh sách khuyến mãi.
     */
    public function index(): View
    {
        $promotions = Promotion::with('packages')->orderBy('created_at', 'desc')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Hiển thị form tạo khuyến mãi mới.
     */
    public function create(): View
    {
        $packages = Package::all();
        return view('admin.promotions.create', compact('packages'));
    }

    /**
     * Lưu khuyến mãi mới.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:promotions',
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed_amount',
                'discount_value' => 'required|numeric|min:0',
                'minimum_order' => 'nullable|numeric|min:0',
                'maximum_discount' => 'nullable|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'usage_limit' => 'nullable|integer|min:1',
                'is_active' => 'nullable|boolean',
                'packages' => 'nullable|array',
                'packages.*' => 'exists:packages,id',
            ]);

            // Chuyển đổi ngày giờ
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            // Tạo khuyến mãi mới
            $promotion = Promotion::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'minimum_order' => $request->minimum_order ?? 0,
                'maximum_discount' => $request->maximum_discount,
                'is_active' => $request->has('is_active') ? true : false,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'usage_limit' => $request->usage_limit,
                'used_count' => 0,
            ]);

            // Liên kết với các gói dịch vụ
            if ($request->has('packages')) {
                $promotion->packages()->attach($request->packages);
            }

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Khuyến mãi đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Không thể tạo khuyến mãi. Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form chỉnh sửa khuyến mãi.
     */
    public function edit($id): View
    {
        $promotion = Promotion::with('packages')->findOrFail($id);
        $packages = Package::all();
        $selectedPackages = $promotion->packages->pluck('id')->toArray();

        return view('admin.promotions.edit', compact('promotion', 'packages', 'selectedPackages'));
    }

    /**
     * Cập nhật thông tin khuyến mãi.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $promotion = Promotion::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed_amount',
                'discount_value' => 'required|numeric|min:0',
                'minimum_order' => 'nullable|numeric|min:0',
                'maximum_discount' => 'nullable|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'usage_limit' => 'nullable|integer|min:1',
                'is_active' => 'nullable|boolean',
                'packages' => 'nullable|array',
                'packages.*' => 'exists:packages,id',
            ]);

            // Chuyển đổi ngày giờ
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            // Cập nhật thông tin khuyến mãi
            $promotion->update([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'minimum_order' => $request->minimum_order ?? 0,
                'maximum_discount' => $request->maximum_discount,
                'is_active' => $request->has('is_active') ? true : false,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'usage_limit' => $request->usage_limit,
            ]);

            // Cập nhật liên kết với các gói dịch vụ
            if ($request->has('packages')) {
                $promotion->packages()->sync($request->packages);
            } else {
                $promotion->packages()->detach();
            }

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Khuyến mãi đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Không thể cập nhật khuyến mãi. Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Xóa khuyến mãi.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $promotion = Promotion::findOrFail($id);

            // Xóa liên kết với các gói dịch vụ
            $promotion->packages()->detach();

            // Xóa khuyến mãi
            $promotion->delete();

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Khuyến mãi đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.promotions.index')
                ->with('error', 'Không thể xóa khuyến mãi. Lỗi: ' . $e->getMessage());
        }
    }
}

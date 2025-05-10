<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục.
     */
    public function index(): View
    {
        // Lấy tất cả danh mục và sắp xếp theo thứ tự
        $categories = Category::with(['parent', 'children', 'packages'])
            ->orderBy('order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Lưu danh mục mới.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        // Kiểm tra nếu parent_id được chọn, đảm bảo đó là danh mục cha (không phải danh mục con)
        if ($request->parent_id) {
            $parentCategory = Category::findOrFail($request->parent_id);
            if ($parentCategory->parent_id !== null) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Không thể chọn danh mục con làm danh mục cha.');
            }
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công.');
    }

    /**
     * Cập nhật thông tin danh mục.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        // Kiểm tra nếu parent_id được chọn, đảm bảo đó là danh mục cha (không phải danh mục con)
        if ($request->parent_id) {
            // Không cho phép chọn chính nó làm danh mục cha
            if ($request->parent_id == $id) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Không thể chọn chính danh mục này làm danh mục cha.');
            }

            $parentCategory = Category::findOrFail($request->parent_id);
            if ($parentCategory->parent_id !== null) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Không thể chọn danh mục con làm danh mục cha.');
            }

            // Kiểm tra xem danh mục này có danh mục con không
            if ($category->children()->count() > 0) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Không thể chuyển danh mục này thành danh mục con vì nó đã có danh mục con.');
            }
        }

        // Kiểm tra xem checkbox is_active có được gửi không
        $isActive = $request->has('is_active');

        // Debug: Ghi log giá trị của checkbox
        Log::info('Updating category: ' . $id);
        Log::info('is_active checkbox value: ' . ($isActive ? 'true' : 'false'));

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    /**
     * Xóa danh mục.
     */
    public function destroy($id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        // Kiểm tra xem danh mục có gói dịch vụ nào không
        if ($category->packages()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì có gói dịch vụ đang sử dụng.');
        }

        // Kiểm tra xem danh mục có danh mục con không
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì có danh mục con.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }
}

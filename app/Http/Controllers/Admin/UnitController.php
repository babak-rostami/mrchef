<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\unit\StoreRequest;
use App\Http\Requests\unit\UpdateRequest;
use App\Models\Unit;
use App\Services\ImageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Unit::class);
        $units = Unit::all();
        return view('unit.index', compact('units'));
    }

    public function create()
    {
        $this->authorize('create', Unit::class);
        return view('unit.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Unit::class);
        $data = $request->validated();

        Unit::create($data);

        return redirect()->route('admin.unit.index')->with('success', 'واحد اندازه گیری با موفقیت ثبت شد');
    }


    public function edit($id)
    {
        $unit = Unit::find($id);
        $this->authorize('update', $unit);

        return view('unit.edit', compact('unit'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $unit = Unit::find($id);
        if (!$unit) {
            return back()->with('error', 'واحد اندازه گیری پیدا نشد');
        }
        $this->authorize('update', $unit);

        $unit->update($data);

        return redirect()->route('admin.unit.index')->with('success', 'تغییرات با موفقیت ثبت شد');
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $this->authorize('delete', $unit);

        if (!isset($unit)) {
            return back()->with('error', 'واحد اندازه گیری وجود ندارد');
        }

        $unit->delete();

        return redirect()->route('admin.unit.index')->with('success', 'واحد اندازه گیری با موفقیت حذف شد');
    }
}

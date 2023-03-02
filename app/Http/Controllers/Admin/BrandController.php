<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Brand::query();

            return DataTables::of($query)
                ->addColumn('action', function ($brand) {
                    return '
                        <a class="block w-full px-2 py-1 mb-1 text-xs text-center text-white transition duration-500 bg-gray-700 border border-gray-700 rounded-md select-none ease hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                            href="' . route('admin.brands.edit', $brand->id) . '">
                            Sunting
                        </a>
                        <form class="block w-full" onsubmit="return confirm(\'Apakah anda yakin?\');" -block" action="' . route('admin.brands.destroy', $brand->id) . '" method="POST">
                        <button class="w-full px-2 py-1 text-xs text-white transition duration-500 bg-red-500 border border-red-500 rounded-md select-none ease hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('admin.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View returned
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(5));

        Brand::create($data);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(5));

        $brand->update($data);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.brands.index');
    }
}

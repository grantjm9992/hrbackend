<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request): JsonResponse
    {
        $companies = Company::all();

        return response()->json([
            'status' => 'success',
            'data' => $companies
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = Company::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Company created successfully',
            'data' => $company
        ]);
    }

    public function show(string $id)
    {
        $company = Company::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $company
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = Company::find($id);
        $company->name = $request->name;
        $company->save();

        return response()->json([
            'status' => 'success',
            'data' => $company
        ]);
    }

    public function destroy(string $id)
    {
    }
}

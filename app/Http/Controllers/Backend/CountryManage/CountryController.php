<?php

namespace App\Http\Controllers\Backend\CountryManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CountryManage\CountryStoreRequest;
use App\Http\Requests\Backend\CountryManage\CountryUpdateRequest;
use App\Models\Country;
use App\Services\CountryService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;

class CountryController extends Controller

{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }


    public function index()
    {
        $countries = $this->countryService->getAllCountries();
        return view('admin.backend.countrymanage.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.backend.countrymanage.create');
    }

    public function store(CountryStoreRequest $request)
    {


        $flag_img_name = null;
        if ($request->hasFile('flag')) {
            $flag_img_file = $request->file('flag');
            $flag_img_name = uniqid() . '_' . time() . '.' . $flag_img_file->getClientOriginalExtension();
            $flag_img_file->move(public_path('/upload/flag_images'), $flag_img_name);
        }

        $countryData = [
            'name' => $request->name,
            'code' => $request->code,
            'flag' => $flag_img_name,
            'status' => 'active',


        ];
        $country = $this->countryService->create($countryData);

        return redirect()->route('countrymanage.index')
            ->with([
                'message' => 'Successfully created',
                'alert-type' => 'success'
            ]);
    }

    public function countryDataTable(Request $request)
    {
        return $this->countryService->countryDataTable($request);
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('admin.backend.countrymanage.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, $id)
    {
        $country = $this->countryService->find($id);
        $country_data = [
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status ?? 'active',

        ];
        

        if ($request->hasFile('flag')) {
            if ($country->flag && file_exists(public_path('upload/flag_images/' . $country->flag))) {
                unlink(public_path('upload/flag_images/' . $country->flag));
            }

            $country_img_file = $request->file('flag');
            $country_img_name = uniqid() . '_' . time() . '.' . $country_img_file->getClientOriginalExtension();
            $country_img_file->move(public_path('/upload/flag_images'), $country_img_name);

            $country_data['flag'] = $country_img_name;
        }
        $country = $this->countryService->update($id, $country_data);

        return redirect()->route('countrymanage.index')
            ->with('message', 'Successfully updated')
            ->with('alert-type', 'success');
    }

    public function destroy($id)
    {
        try {
            $this->countryService->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
<?php

namespace App\Services;

use App\Repositories\Interfaces\CountryRepoInterface;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class CountryService
{
    protected $countryRepoInterface;

    public function __construct(CountryRepoInterface $countryRepoInterface)
    {
        $this->countryRepoInterface = $countryRepoInterface;
    }

    public function getAllCountries()
    {
        return $this->countryRepoInterface->findAll();
    }

    public function create(array $data)
    {
        $record = $this->countryRepoInterface->create($data);
        return $record;
    }

    public function find($id)
    {
        return $this->countryRepoInterface->find($id);
    }

    public function update($id, array $data)
    {

        $record = $this->countryRepoInterface->update($data, $id);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->countryRepoInterface->find($id);
        $record->delete();
    }

    public function countryDataTable($request)
    {


        $query = $this->countryRepoInterface->query();

        return DataTables::of($query)
            ->addIndexColumn()

            ->editColumn('code', function ($country) {
                return $country->code;
            })
            ->editColumn('flag', function ($country) {
                return '<img src="' . $country->acsrImagePath  . '" alt=""  class="rounded" width="30">';
            })

            // ->editColumn('status', function ($country) {
            //     return '<span class="badge bg-' . $country->acsrStatus['badge'] . '">' .
            //         $country->acsrStatus['text'] .
            //         '</span>';
            // })

            ->addColumn('action', function ($country) {
                return view('admin.backend.countrymanage._action', compact('country'))->render();
            })
            ->rawColumns([
                'code',
                'flag',
                'action',

            ])
            ->make(true);
    }
}

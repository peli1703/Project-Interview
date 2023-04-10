<?php

namespace App\Exports;


use App\Models\Interview;
//mengambil data dari db
use Maatwebsite\Excel\Concerns\FromCollection;
//mengatur nama nama column header di excelnya
use Maatwebsite\Excel\Concerns\WithHeadings;
//mengatur data yang dimunculkan tiap column di excelnya
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelExport implements FromCollection, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //didalam ini boleh menyertakan perintah alouquent lain seperti where,all,dll
        return Interview::with('response')->orderBy('created_at','DESC')->get();
    }

    public function headings(): array
    {
        return[
            'name',
            'email',
            'age',
            'phone_number',
            'last_education',
            'education_name',
            'status',
            'schedule',
        ];
    }

    public function map($item): array
    {
        return [
            $item->name,
            $item->email,
            $item->age,
            // \Carbon\Carbon::parse($item->created_at)->format('j F Y'),
            $item->phone_number,
            $item->last_education,
            $item->education_name,
            $item->response ? $item->response['status'] : '-',
            \Carbon\Carbon::parse($item->created_at)->format('j F Y'),
        ];
    }
}

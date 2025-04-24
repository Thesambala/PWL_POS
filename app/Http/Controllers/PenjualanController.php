<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Str;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadCrumb = (object)[
            'title' => 'Penjualan Barang',
            'list' => ['Home', 'penjualan']
        ];

        $page = (object)[
            'title' => 'List Penjualan barang'
        ];

        $activeMenu = 'penjualan';
        $user = UserModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadCrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with('user');
        if ($request->user_id) {
            $penjualan->where('user_id', $request->user_id);
        }
        return DataTables::of($penjualan)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btnsm">Detail</a> ';
                // $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' .
                //     url('/barang/' . $barang->barang_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id .
                //     '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {
        $user = UserModel::select('user_id', 'nama')->get();
        $PenjualanDetail = PenjualanDetailModel::select('barang_id', 'jumlah')->get();
        $barang = BarangModel::all();
        return view('penjualan.create_ajax', ['user' => $user, 'penjualanDetail' => $PenjualanDetail, 'barang' => $barang]);
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string',
            'user_id' => 'required|integer',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:m_barang,barang_id',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);
    
        try {
            $penjualan = PenjualanModel::create([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);
    
            $dataDetail = [];
            foreach ($request->barang_id as $i => $barangId) {
                $dataDetail[] = new PenjualanDetailModel([
                    'barang_id' => $barangId,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                ]);
            }
    
            $penjualan->detail()->saveMany($dataDetail);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan.',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan transaksi. ' . $e->getMessage(),
            ], 500);
        }
        return redirect('/');
    }

    public function show_ajax(String $id)
    {
        $Penjualan = PenjualanModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];
        $page =
            (object) [
                'title' => 'Detail Penjualan'
            ];
        $PenjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)
            ->with('penjualan')
            ->get();
        $activeMenu = 'penjualan'; // set menu yang sedang aktif
        return view('penjualan.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Penjualan' => $Penjualan, 'PenjualanDetail' => $PenjualanDetail, 'activeMenu' => $activeMenu]);
    }

    // public function edit_ajax(String $id)
    // {
    //     $penjualan = PenjualanModel::find($id);
    //     $user = UserModel::select('user_id', 'nama')->get();
    //     $PenjualanDetail = PenjualanDetailModel::select('detail_id', 'penjualan_id') -> get();
    //     return view('Penjualan.edit', ['penjualan' => $penjualan, 'user' => $user, 'PenjulanDetail' => $PenjualanDetail]);
    // }

    // public function update_ajax(Request $request, $id)
    // {
    //     // cek apakah request dari ajax
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             'user_id' => 'required|integer',
    //             'pembeli' => 'required|max:100', // nama harus diisi, berupa string, dan maksi
    //             'penjualan_kode' => 'required|string|max:100',
    //             'penjualan_tanggal' => 'required|date_format:Y-m-d'
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false, // respon json, true: berhasil, false: gagal
    //                 'message' => 'Validasi gagal.',
    //                 'msgField' => $validator->errors() // menunjukkan field mana yang error
    //             ]);
    //         }
    //         $check = PenjualanModel::find($id);
    //         if ($check) {
    //             if (!$request->filled('penjualan_id')) { // jika password tidak diisi, maka hapus dari request
    //                 $request->request->remove('penjualan_id');
    //             }
    //             $check->update($request->all());
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data berhasil diupdate'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data tidak ditemukan'
    //             ]);
    //         }
    //     }
    //     return redirect('/');
    // }

    public function confirm_ajax(String $id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        try {
            if ($request->ajax() || $request->wantsJson()) {
                $penjualan = PenjualanModel::find($id);
                if ($penjualan) {
                    // Delete all related details
                    $penjualan->details()->delete();
                    // Delete the penjualan itself
                    $penjualan->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ]);
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
            ]);
        }
        return redirect('/');
    }

    // public function import()
    // {
    //     return view('Penjualan.import');
    // }
    // public function import_ajax(Request $request)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             // validasi file harus xls atau xlsx, max 1MB
    //             'file_penjualan' => 'required|mimes:xls,xlsx|max:1024'
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi Gagal',
    //                 'msgField' => $validator->errors()
    //             ]);
    //         }
    //         $file = $request->file('file_penjualan'); // ambil file dari request
    //         $reader = IOFactory::createReader('Xlsx'); // load reader file excel
    //         $reader->setReadDataOnly(true); // hanya membaca data
    //         $spreadsheet = $reader->load($file->getRealPath()); // load file excel
    //         $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
    //         $data = $sheet->toArray(null, false, true, true); // ambil data excel
    //         $insert = [];
    //         if (count($data) > 1) { // jika data lebih dari 1 baris
    //             foreach ($data as $baris => $value) {
    //                 if ($baris > 1) { // baris ke 1 adalah header, maka lewati
    //                     $insert[] = [
    //                         'user_id' => $value['A'],
    //                         'pembeli' => $value['B'],
    //                         'penjualan_kode' => $value['C'],
    //                         'penjualan_tanggal' => now(),
    //                         'created_at' => now(),
    //                     ];
    //                 }
    //             }
    //             if (count($insert) > 0) {
    //                 // insert data ke database, jika data sudah ada, maka diabaikan
    //                 PenjualanModel::insertOrIgnore($insert);
    //             }
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data berhasil di import'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Tidak ada data yang di import'
    //             ]);
    //         }
    //     }
    //     return redirect('/');
    // }

    public function export_pdf()
    {
        $Penjualan = PenjualanModel::select('user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->orderBy('user_id')
            ->orderBy('penjualan_kode')
            ->with('user')
            ->get();

        // use Barryvdh\DomPDF \Facade\Pdf;
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $Penjualan]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Penjualan' . date('Y-m-d H:i:s') . '.pdf');
    }

}
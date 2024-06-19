@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                            @csrf
                        <table class="table">
                            <tr>
                                <td>Merk</td>
                                <td>{{ $rsetBarang->merk }}</td>
                            </tr>
                            <tr>
                                <td>Seri</td>
                                <td>{{ $rsetBarang->seri }}</td>
                            </tr>
                            <tr>
                                <td>Spesifikasi</td>
                                <td>{{ $rsetBarang->spesifikasi }}</td>
                            </tr>
                            <tr>
                                <td>Stok</td>
                                <td>{{ $rsetBarang->stok }}</td>
                            </tr>
                            <tr>
                                <td>Kategori ID</td>
                                <td>{{ $rsetBarang->kategori_id }}</td>
                            </tr>
                            <tr>
                                <td>Deskripsi Kategori</td>
                                <td>{{ $deskripsiKategori->kategori->deskripsi }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
        <div class="flex">
   
            <div class="col-md-12  text-center">
                

            <a href="javascript:history.back()" class="btn btn-md btn-primary mt-3 mb-3">Back</a>

            </div>
        </div>
    </div>
@endsection
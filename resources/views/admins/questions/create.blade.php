@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/questions">Questions</a></h1>
        <br>
        <div class="card mb-4">
            <form action="/admin/questions" method="POST">
                @csrf
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> questions table 
                    <input type="submit" class="btn btn-success store_button" value="저장" />
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">user_id(후기 작성자) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <select class="form-select @error('user_id') is-invalid @enderror" aria-label="Default select example" name="user_id" required>
                                        <option value="0" selected>회원을 고르세요</option>
                                        {{-- 유효성 검사 걸린 경우 --}}
                                        @if (old('user_id') != '') 
                                            @foreach ($users as $user)
                                                @if (old('user_id') == $user->id) 
                                                    <option value="{{ $user->id }}" selected>[{{ $user->id }}] {{ $user->name }}</option>
                                                @else  
                                                    <option value="{{ $user->id }}">[{{ $user->id }}] {{ $user->name }}</option> 
                                                @endif
                                            @endforeach
                                        {{-- 아닌 경우 --}}
                                        @else
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">[{{ $user->id }}] {{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                        <div style="margin-top : 5px!important; color : #dc3545;">회원을 고르세요</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">goods_id(상품 id) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <select class="form-select @error('goods_id') is-invalid @enderror" aria-label="Default select example" name="goods_id" required>
                                        <option value="0" selected>상품을 고르세요</option>
                                        {{-- 유효성 검사 걸린 경우 --}}
                                        @if (old('goods_id') != '') 
                                            @foreach ($goods as $good)
                                                @if (old('goods_id') == $good->id) 
                                                    <option value="{{ $good->id }}" selected>[{{ $good->id }}] {{ $good->title }}</option>
                                                @else  
                                                    <option value="{{ $good->id }}">[{{ $good->id }}] {{ $good->title }}</option> 
                                                @endif
                                            @endforeach
                                        {{-- 아닌 경우 --}}
                                        @else
                                            @foreach ($goods as $good)
                                                <option value="{{ $good->id }}">[{{ $good->id }}] {{ $good->title }}</option> 
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('goods_id')
                                        <div style="margin-top : 5px!important; color : #dc3545;">상품을 고르세요</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">content(설명) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="10" placeholder="내용을 입력하세요."  required>{{ old('content') ? old('content') : '' }}</textarea>
                                    @error('content')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">writeday(작성 날짜) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input id="datepicker" class="form-control @error('writeday') is-invalid @enderror" type="text" name="writeday" value="{{ old('writeday') ? old('writeday') : '' }}" id="datepicker" required>
                                    @error('writeday')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
@endsection
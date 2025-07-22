@extends('layouts.client')
@section('content-client')
    <style>
        .title-steps {
            padding: 20px 0px;
            font-weight: 600;
        }
    </style>
    <div class="container_fullwidth">
        <div class="container">
            <form action="{{ route('checkout.index') }}" method="POST" id="form__js">
                <input style="visibility: hidden;" id="total-order-input" value="{{ Cart::getTotal() }}" type="text" hidden>
                <input style="visibility: hidden;" id="total-order-const" value="{{ Cart::getTotal() }}" type="text"
                    hidden>
                <input style="visibility: hidden;" id="address" value="" type="text" hidden name="address">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <ol class="checkout-steps">
                            <h4 class="title-steps">
                                Thông Tin Cá Nhân
                            </h4>
                            <div class="step-description">
                                <div class="your-details">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Họ Và Tên</label>
                                        <input type="text" class="form-control" value="{{ $fullName }}"
                                            id="name" name="name" placeholder="Nhập họ và tên">
                                        @if ($errors->get('name'))
                                            <span id="name-error" class="error invalid-feedback" style="display: block">
                                                {{ implode(', ', $errors->get('name')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email</label>
                                        <input type="text" class="form-control" value="{{ $email }}"
                                            id="email" name="email" placeholder="Nhập địa chỉ email">
                                        @if ($errors->get('email'))
                                            <span id="email-error" class="error invalid-feedback" style="display: block">
                                                {{ implode(', ', $errors->get('email')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Số điện thoại</label>
                                        <input type="text" class="form-control" value="{{ $phoneNumber }}"
                                            id="phone_number" name="phone_number" placeholder="Nhập số điện thoại">
                                        @if ($errors->get('phone_number'))
                                            <span id="phone_number-error" class="error invalid-feedback"
                                                style="display: block">
                                                {{ implode(', ', $errors->get('phone_number')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Tỉnh/Thành phố</label>
                                        <select class="form-control" id="city" name="city">
                                            @forelse ($citys as $city)
                                                <option value="{{ $city['ProvinceID'] ?? 1 }}"
                                                    @if ($city['ProvinceID'] == $city) selected @endif>
                                                    {{ $city['ProvinceName'] ?? 'TP Ảo' }}</option>
                                            @empty
                                                <option value="1">TP Ảo</option>
                                            @endforelse
                                        </select>
                                        @if ($errors->get('city'))
                                            <span id="city-error" class="error invalid-feedback" style="display: block">
                                                {{ implode(', ', $errors->get('city')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="district">Quận/Huyện</label>
                                        <select class="form-control" id="district" name="district">
                                            @forelse ($districts as $district)
                                                <option value="{{ $district['DistrictID'] ?? 1 }}"
                                                    @if ($district['DistrictID'] == $district) selected @endif>
                                                    {{ $district['DistrictName'] ?? 'Quận Ảo' }}</option>
                                            @empty
                                                <option value="1">Quận Ảo</option>
                                            @endforelse
                                        </select>
                                        @if ($errors->get('district'))
                                            <span id="district-error" class="error invalid-feedback" style="display: block">
                                                {{ implode(', ', $errors->get('district')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="ward">Phường/Xã</label>
                                        <select class="form-control" id="ward" name="ward">
                                            @forelse ($wards as $ward)
                                                <option value="{{ $ward['WardCode'] ?? 1 }}"
                                                    @if ($ward['WardCode'] == $ward) selected @endif>
                                                    {{ $ward['WardName'] ?? 'Phường Ảo' }}</option>
                                            @empty
                                                <option value="1">Phường Ảo</option>
                                            @endforelse
                                        </select>
                                        @if ($errors->get('ward'))
                                            <span id="ward-error" class="error invalid-feedback" style="display: block">
                                                {{ implode(', ', $errors->get('ward')) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa Chỉ Nhà</label>
                                        <input type="text" class="form-control" value="{{ $apartment_number }}"
                                            id="apartment_number" name="apartment_number" aria-describedby="emailHelp"
                                            placeholder="Nhập địa chỉ nhà">
                                        @if ($errors->get('apartment_number'))
                                            <span id="apartment_number-error" class="error invalid-feedback"
                                                style="display: block">
                                                {{ implode(', ', $errors->get('apartment_number')) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </ol>
                    </div>
                    <div class="col-md-5">
                        <div>
                            <ol class="checkout-steps">
                                <h4 class="title-steps">
                                    Thông Tin Đơn Hàng
                                </h4>
                                <div class="step-description">
                                    <div class="your-details">
                                        <div class="info-order">
                                            <div class="info__order-box">
                                                <span>Tổng tiền sản phẩm</span>
                                                <span
                                                    id="total-product">{{ format_number_to_money(Cart::getTotal()) }}</span>
                                            </div>
                                        </div>
                                        <div class="info-order">
                                            <div class="info__order-box">
                                                <span>Phí vận chuyển</span>
                                                <span id="fee">0</span>
                                            </div>
                                        </div>
                                        <div class="info-order">
                                            <div class="info__order-box">
                                                <span>Áp dụng mã giảm giá (Voucher)</span>
                                                <div
                                                    style="display: flex; gap: 8px; align-items: center; margin-top: 8px;">
                                                    <input type="text" id="voucher_code" class="form-control"
                                                        placeholder="Nhập mã voucher" style="max-width: 180px;">
                                                    <button type="button" id="apply-voucher-btn"
                                                        class="btn btn-success">Áp dụng</button>
                                                </div>
                                                <div id="voucher-message" class="mt-2 text-danger" style="display:none; text-align:left; width:100%; clear:both;"></div>
                                            </div>
                                        </div>
                                        <div class="info-order">
                                            <div class="info__order-box">
                                                <span>Tổng đơn hàng</span>
                                                <span id="total-order">0</span>
                                            </div>
                                        </div>
                                        <div class="info-order">
                                            <div class="payment-method">
                                                <span>Chọn phương thức thanh toán</span>
                                                @if ($errors->get('payment_method'))
                                                    <span id="payment_method-error" class="error invalid-feedback"
                                                        style="display: block">
                                                        {{ implode(', ', $errors->get('payment_method')) }}
                                                    </span>
                                                @endif
                                            </div>
                                            @foreach ($payments as $payment)
                                                <div class="payment-method-select">
                                                    <label for="{{ $payment->id }}"
                                                        class="payment-method-select--check">
                                                        <div>
                                                            <input type="radio" value="{{ $payment->id }}"
                                                                name="payment_method" id="{{ $payment->id }}"
                                                                @if ($payment->id == 1) checked @endif>
                                                            <span class="label-momo">
                                                                {{ $payment->name }}
                                                            </span>
                                                        </div>
                                                        <img src="{{ asset("asset/imgs/$payment->img") }}"
                                                            alt="">
                                                    </label>
                                                </div>
                                            @endforeach
                                            <div style="padding-top: 40px;" class="text-center">
                                                <button class="btn btn-primary">Thanh Toán Đơn Hàng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ol>
                        </div>
                    </div>
                </div>
            </form>
            <div class="clearfix">
            </div>
        </div>
    </div>
    @vite(['resources/client/js/checkout.js', 'resources/client/css/checkout.css'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('apply-voucher-btn');
            btn.addEventListener('click', function() {
                const code = document.getElementById('voucher_code').value;
                const total = parseInt(document.getElementById('total-order-const').value);
                fetch("{{ route('checkout.api_apply_voucher') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                        },
                        body: JSON.stringify({
                            voucher_code: code,
                            total: total
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const msg = document.getElementById('voucher-message');
                        if (data.success) {
                            msg.classList.remove('text-danger');
                            msg.classList.add('text-success');
                            msg.innerText = data.message +
                                ` (Giảm: ${data.discount.toLocaleString()} VNĐ)`;
                            document.getElementById('total-order').innerText = data.new_total
                                .toLocaleString();
                            document.getElementById('total-order-input').value = data.new_total;
                            msg.style.display = 'block';
                        } else {
                            msg.classList.remove('text-success');
                            msg.classList.add('text-danger');
                            msg.innerText = data.message;
                            msg.style.display = 'block';
                        }
                    });
            });
        });
    </script>
@endsection

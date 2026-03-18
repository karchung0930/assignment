@extends('layouts.app')

@section('content')
    <section class="card p-6">
        <h1 class="text-3xl mb-6">Create a Transaction</h1>
        <p class="mb-6">
            <span>Wallet Balance:</span>
            <strong>{{ auth()->user()->wallet->currency }} {{ number_format(auth()->user()->wallet->amount, 2) }}</strong>
        </p>
        <form
            method="POST"
            action="/transaction/create"
            class="w-1/5"
            autocomplete="off"
        >
            @csrf

            <label>
                Category
                <select
                    id="select-category"
                    name="category"
                >
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            data-fee-rate="{{ $category->fee_rate }}"
                            data-fee-fixed="{{ $category->fee_fixed }}"
                            data-fee-threshold="{{ $category->fee_threshold }}"
                            {{ old('category') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            @error('category')
            <p
                id="error-message-category"
                class="text-red-600 -mt-4.5"
            >
                {{ $message }}
            </p>
            @enderror

            <label class="mb-3">
                Cost
                <input
                    id="input-cost"
                    type="number"
                    name="cost"
                    step="0.01"
                    min="0.01"
                    value="{{ old('cost') }}"
                >
            </label>

            @error('cost')
            <p
                id="error-message-cost"
                class="text-red-600 -mt-4.5"
            >
                {{ $message }}
            </p>
            @enderror

            <div
                id="fee-preview"
                class="hidden"
            >
                <p>Transaction Fee: {{ auth()->user()->wallet->currency }} <strong id="fee-amount">0.00</strong></p>
                <p>Total Deduction: {{ auth()->user()->wallet->currency }} <strong id="total-amount">0.00</strong></p>
            </div>
            <button class="btn-cta">Submit Transaction</button>
        </form>

        @if (session('success'))
            <p class="text-green-600 mt-3 font-semibold">{{ session('success') }}</p>
        @endif
    </section>

    <script>
        const selectCategory = document.querySelector('#select-category');
        const inputCost = document.querySelector('#input-cost');
        const feePreview = document.querySelector('#fee-preview');
        const feeAmount = document.querySelector('#fee-amount');
        const totalAmount = document.querySelector('#total-amount');
        const errorMessageCategory = document.querySelector('#error-message-category');
        const errorMessageCost = document.querySelector(('#error-message-cost'));

        function calculateFee() {
            const selected = selectCategory.options[selectCategory.selectedIndex];
            const cost = parseFloat(inputCost.value) || 0;

            if (!selected.value || cost <= 0) {
                feePreview.classList.add('hidden');
                feePreview.classList.remove(('block'));

                return;
            }

            const feeRate = parseFloat(selected.dataset.feeRate) || 0;
            const feeFixed = parseFloat(selected.dataset.feeFixed) || 0;
            const feeThreshold = parseFloat(selected.dataset.feeThreshold) || 0;

            let fee = 0;

            if (feeThreshold && cost > feeThreshold) {
                fee = feeFixed;
            } else {
                fee = cost * feeRate;
            }

            feeAmount.textContent = fee.toFixed(2);
            totalAmount.textContent = (cost + fee).toFixed(2);

            feePreview.classList.remove('hidden');
            feePreview.classList.add(('block'));
        }

        function removeErrorMessage(e) {
            if (e.target === selectCategory && errorMessageCategory) {
                errorMessageCategory.remove();
            } else if (e.target === inputCost && errorMessageCost) {
                errorMessageCost.remove();
            }
        }

        selectCategory.addEventListener('change', calculateFee);
        selectCategory.addEventListener('focus', removeErrorMessage);
        inputCost.addEventListener('input', calculateFee);
        inputCost.addEventListener('focus', removeErrorMessage);
    </script>
@endsection
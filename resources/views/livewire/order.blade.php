@php
    use App\Models\Product;
    use Illuminate\Support\Facades\Storage;
@endphp
<div x-data="{ open: false }" class="flex flex-col w-full mt-6">
    <div class="w-full mx-auto">
        <h1 class="text-center">Machine Refill Order</h1>
        <h2 class="text-right pr-4">{{ Carbon\Carbon::now()->isoFormat('dddd, MMMM D YYYY') }}</h2>
    </div>
    <div class="w-full flex items-start space-x-4">
        <div class="h-10">
            <h3 class="pl-8 py-2">Select machine:</h3>
        </div>
        <div>
            <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium
                    focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center w-60"
                    type="button"
                    @click="open = !open"
            >
                @if (!$selectedMachine)
                    Select Machine
                @else
                    {{ $selectedMachine->name }}
                @endif
                <svg
                        class="w-2.5 h-2.5 ms-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 10 6"
                >
                    <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 4 4 4-4"
                    />
                </svg>
            </button>

            <div x-show="open" x-cloak class="z-10 bg-white rounded-lg shadow-sm w-60 dark:bg-gray-700">
                <div class="p-3">
                    <label for="input-group-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg
                                    class="w-4 h-4 text-gray-500"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 20 20"
                            >
                                <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                                wire:model.live="search"
                                type="text"
                                class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg
                                focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                placeholder="Search machine"
                        >
                    </div>
                </div>

                <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700">
                    @foreach($machines as $machine)
                        <li>
                            <button
                                    wire:click="selectMachine({{$machine}}), open = false"
                                    class="block px-4 py-2 hover:bg-gray-100 w-full"
                            >
                                {{ $machine->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @if($selectedMachine)
        <div class="grid grid-cols-3 md:grid-cols-5">
            @foreach($selectedMachine->slots as $slot)
                <div class="flex flex-col items-center space-y-2 mt-8">
                    <span>{{ $slot->name }}</span>
                    <img alt="product" class="w-20 h-20"
                         src="{{ Storage::url($slot->product->image) }}">
                    <span>${{ $slot->price }}</span>
                    <input
                            wire:model="quantities.{{ $slot->id }}"
                            wire:key="{{ $slot->id }}"
                            type="number"
                            id="quantity"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg text-center w-1/2
                        focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                    >
                </div>
            @endforeach
        </div>
        <div class="px-8 mt-8">
            <label for="comments" class="block mb-2 text-sm font-medium text-gray-900">Comments:</label>
            <textarea
                    id="comments"
                    wire:model="comments"
                    rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
        </div>
    @endif
    <div>
        @if ($selectedMachine)
            <div class="flex items-center justify-center">
                <button
                        type="button"
                        wire:click="saveOrder()"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none mt-8 w-32"
                >
                    Save Order
                </button>
                <button
                        type="button"
                        wire:click="cancelOrder()"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300
                    font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none mt-8 w-32"
                >
                    Cancel
                </button>
            </div>
        @endif
    </div>
    <div>
        <div class="flex items-center justify-center">
            <button
                    type="button"
                    wire:click="generateReport()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none mt-8 w-40"
            >
                Generate Report
            </button>
        </div>
    </div>
    @if($reportGenerated)
        @if($reportHasItems === true)
            <div class="grid grid-cols-3 md:grid-cols-5">
                @foreach($products as $product)
                    <div class="flex flex-col items-center space-y-2 mt-8">
                        <span>{{ Product::where('id', $product['id'])->first()->name }}</span>
                        <img
                            alt="product"
                            class="w-20 h-20"
                            src="{{ Storage::url(Product::where('id', $product['id'])->first()->image) }}"
                        >
                        <span>Quantity: {{ $product['quantity'] }}</span>
                    </div>
              @endforeach
            </div>
            <div class="flex items-center justify-center">
                <button
                        type="button"
                        wire:click="completeReport()"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none mt-8 w-36"
                >
                    Complete Order
                </button>
                <button
                        type="button"
                        wire:click="cancelReport()"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300
                        font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none mt-8 w-36"
                >
                    Cancel
                </button>
            </div>
        @else
            <div class="flex items-center justify-center">
                <span class="mt-4 font-bold">No Open Orders!</span>
            </div>
        @endif
    @endif
</div>

<?php

namespace App\Livewire;

use App\Models\Machine;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Slot;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Order extends Component
{
    public Collection $machines;
    public string $search = '';
    public ?Machine $selectedMachine;
    public string $comments = '';
    public array $quantities = [];
    public bool $reportGenerated = false;
    public bool $reportHasItems = false;
    public array $products = [];
    protected ?Collection $orders;

    public function selectMachine(Machine $machine): void
    {
        $this->selectedMachine = $machine;
        $this->reportGenerated = false;

    }

    public function saveOrder(): void
    {
        if ($this->quantities) {
            $order = \App\Models\Order::create([
                'machine_id' => $this->selectedMachine->id,
                'comments' => $this->comments,
            ]);
            foreach ($this->quantities as $slot => $quantity) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => Slot::find($slot)->product->id,
                    'quantity' => $quantity,
                ]);
            }

            $this->selectedMachine = null;

            session()->flash('status', 'Order created successfully!');

            $this->quantities = [];

        }

    }

    public function cancelOrder(): void
    {
        $this->selectedMachine = null;
    }

    public function generateReport(): void
    {
        $this->orders = \App\Models\Order::where('status', 'open')->get();

        if ($this->orders->isNotEmpty()) {
            $products = [];

            $this->reportHasItems = true;
            foreach (Product::all() as $product) {
                $products[]['id'] = $product->id;
            }

            $x = count($products) - 1;
            for ($i = $x; $i >= 0; $i--) {
                $products[$i]['quantity'] = 0;
            }

            foreach ($this->orders as $order) {
                foreach (OrderItem::where('order_id', $order->id)->get() as $item) {
                    $position = array_search($item->product_id, array_column($products, 'id'));
                    $products[$position]['quantity'] += $item->quantity;
                }
            }

            $this->products = $products;

        } else {
            $this->reportHasItems = false;
        }
        $this->reportGenerated = true;

    }

    public function completeReport(): void
    {
        $this->orders = \App\Models\Order::where('status', 'open')->get();

        foreach ($this->orders as $order) {
            $order->update([
                'status' => 'completed',
            ]);
        }

        $this->orders = null;

        $this->reportGenerated = false;
        $this->reportHasItems = false;
    }

    public function cancelReport(): void
    {
        $this->reportGenerated = false;
    }

    public function render(): View
    {
        $this->machines = Machine::where('name', 'LIKE', '%' . $this->search . '%')->get();
        return view('livewire.order');
    }
}
